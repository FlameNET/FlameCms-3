<?php
/**
 * Adomasalcore3 Loader
 * Yes, I've Created this "subpart" of loader
 * And no, you may not use it for your projects. 
 * it can make the things very confusing...
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Loader Class
 *
 * Loads framework components.
 *
 * @package	 CodeIgniter
 * @subpackage  Libraries
 * @category	Loader
 * @author	  EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/loader.html
 */
class MY_Loader extends CI_Loader{
	
	/**
	 * List of nested loaded classes
	 *
	 * @var array
	 */
	protected $_ci_nested_classes =	array();
	
	/**
	 * List of nested loaded classes paths 
	 * For Verification
	 *
	 * @var array
	 */
	protected $_ci_nested_classes_paths =	array();
	function get_all_nested_names(){
		return $this->_ci_nested_classes_paths;
	}
	/**
	 * Is Nested Loaded
	 *
	 * A utility method to test if a class is in the self::$_ci_nested_classes array.
	 *
	 * @used-by Mainly used by Form Helper function _get_validation_object().
	 *
	 * @param   string	  $class  Class name to check for
	 * @return  string|bool Class object name if loaded or FALSE
	 */
	public function is_nested_loaded($class)
	 {
		  return array_search(ucfirst($class), $this->$_ci_nested_classes_paths, TRUE);
	 }
	/**
	 * Library Loader
	 *
	 * Loads and instantiates libraries.
	 * Designed to be called from application controllers.
	 *
	 * @param   string  $library	Library name
	 * @param   array   $params	 Optional parameters to pass to the library class constructor
	 * @param   string  $object_name	An optional object name to assign to
	 * @return  object
	 */
	public function library($library, $params = NULL, $object_name = NULL)
	{
		if (empty($library))
		{
			return $this;
		}
		elseif (is_array($library))
		{
			foreach ($library as $key => $value)
			{
				if (is_int($key))
				{
					$this->library($value, $params);
				}
				else
				{
					$this->library($key, $params, $value);
				}
			}

			return $this;
		}

		if ($params !== NULL && ! is_array($params))
		{
			$params = NULL;
		}

		$this->_ci_load_library($library, $params, $object_name);
		return $this;
	}
	// --------------------------------------------------------------------

	/**
	 * Internal CI Library Loader
	 *
	 * @used-by CI_Loader::nested_library()
	 * @uses	CI_Loader::_ci_init_library()
	 *
	 * @param   string  $class	  Class name to load
	 * @param   mixed   $params	 Optional parameters to pass to the class constructor
	 * @param   string  $object_name	Optional object name to assign to
	 * @return  void
	 */
	protected function _ci_load_library($class, $params = NULL, $object_name = NULL)
	{
		// Get the class name, and while we're at it trim any slashes.
		// The directory path can be included as part of the class name,
		// but we don't want a leading slash
		$class = str_replace('.php', '', trim($class, '/'));

		// Was the path included with the class name?
		// We look for a slash to determine this
		if (($last_slash = strrpos($class, '/')) !== FALSE)
		{
			// Extract the path
			$subdir = substr($class, 0, ++$last_slash);

			// Get the filename from the path
			$class = substr($class, $last_slash);
		}
		else
		{
			$subdir = '';
		}

		$class = ucfirst($class);

		// Is this a stock library? There are a few special conditions if so ...
		if (file_exists(BASEPATH.'libraries/'.$subdir.$class.'.php'))
		{
			return $this->_ci_load_stock_library($class, $subdir, $params, $object_name);
		}

		// Let's search for the requested library file and load it.
		$parent = array();
		foreach ($this->_ci_library_paths as $path)
		{
			// BASEPATH has already been checked for
			if ($path === BASEPATH)
			{
				continue;
			}

			$filepath = $path.'libraries/'.$subdir.$class.'.php';
			// Safety: Was the class already loaded by a previous call?
			if (class_exists($class, FALSE))
			{
				// Before we deem this to be a duplicate request, let's see
				// if a custom object name is being supplied. If so, we'll
				// return a new instance of the object
				if ($object_name !== NULL)
				{
					$CI =& get_instance();
					if ( ! isset($CI->$object_name))
					{
						return $this->_ci_init_library($class, '', $params, $object_name);
					}
				}

				log_message('debug', $class.' class already loaded. Second attempt ignored.');
				return;
			}
			// Does the file exist? No? Bummer...
			elseif ( ! file_exists($filepath))
			{
				continue;
			}

			include_once($filepath);
			return $this->_ci_init_library($class, '', $params, $object_name);
		}

		// One last attempt. Maybe the library is in a subdirectory, but it wasn't specified?
		if ($subdir === '')
		{
			return $this->_ci_load_library($class.'/'.$class, $params, $object_name);
		}

		// If we got this far we were unable to find the requested class.
		log_message('error', 'Unable to load the requested class: '.$class);
		show_error('Unable to load the requested class: '.$class);
	}

	// --------------------------------------------------------------------

	/**
	 * Internal CI Stock Nested Library Loader
	 *
	 * @used-by CI_Loader::_ci_load_library()
	 * @uses	CI_Loader::_ci_init_library()
	 *
	 * @param   string  $library_name   Library name to load
	 * @param   string  $file_path  Path to the library filename, relative to libraries/
	 * @param   mixed   $params	 Optional parameters to pass to the class constructor
	 * @param   string  $object_name	Optional object name to assign to
	 * @return  void
	 */
	protected function _ci_load_stock_library($library_name, $file_path, $params, $object_name)
	{
		$prefix = 'CI_';

		if (class_exists($prefix.$library_name, FALSE))
		{
			if (class_exists(config_item('subclass_prefix').$library_name, FALSE))
			{
				$prefix = config_item('subclass_prefix');
			}

			// Before we deem this to be a duplicate request, let's see
			// if a custom object name is being supplied. If so, we'll
			// return a new instance of the object
			if ($object_name !== NULL)
			{
				$CI =& get_instance();
				if ( ! isset($CI->$object_name))
				{
					return $this->_ci_init_library($library_name, $prefix, $params, $object_name);
				}
			}

			log_message('debug', $library_name.' class already loaded. Second attempt ignored.');
			return;
		}

		$paths = $this->_ci_library_paths;
		array_pop($paths); // BASEPATH
		array_pop($paths); // APPPATH (needs to be the first path checked)
		array_unshift($paths, APPPATH);

		foreach ($paths as $path)
		{
			if (file_exists($path = $path.'libraries/'.$file_path.$library_name.'.php'))
			{
				// Override
				include_once($path);
				if (class_exists($prefix.$library_name, FALSE))
				{
					return $this->_ci_init_library($library_name, $prefix, $params, $object_name);
				}
				else
				{
					log_message('debug', $path.' exists, but does not declare '.$prefix.$library_name);
				}
			}
		}

		include_once(BASEPATH.'libraries/'.$file_path.$library_name.'.php');

		// Check for extensions
		$subclass = config_item('subclass_prefix').$library_name;
		foreach ($paths as $path)
		{
			if (file_exists($path = $path.'libraries/'.$file_path.$subclass.'.php'))
			{
				include_once($path);
				if (class_exists($subclass, FALSE))
				{
					$prefix = config_item('subclass_prefix');
					break;
				}
				else
				{
					log_message('debug', $path.' exists, but does not declare '.$subclass);
				}
			}
		}

		return $this->_ci_init_library($library_name, $prefix, $params, $object_name);
	}

	// --------------------------------------------------------------------

	/**
	 * Internal CI Library Instantiator
	 *
	 * @used-by CI_Loader::_ci_load_stock_library()
	 * @used-by CI_Loader::_ci_load_library()
	 *
	 * @param   string	  $class	  Class name
	 * @param   string	  $prefix	 Class name prefix
	 * @param   array|null|bool $config	 Optional configuration to pass to the class constructor:
	 *					  FALSE to skip;
	 *					  NULL to search in config paths;
	 *					  array containing configuration data
	 * @param   string	  $object_name	Optional object name to assign to
	 * @return  void
	 */
	protected function _ci_init_library($class, $prefix, $config = FALSE, $object_name = NULL)
	{
		// Is there an associated config file for this class? Note: these should always be lowercase
		if ($config === NULL)
		{
			// Fetch the config paths containing any package paths
			$config_component = $this->_ci_get_component('config');

			if (is_array($config_component->_config_paths))
			{
				$found = FALSE;
				foreach ($config_component->_config_paths as $path)
				{
					// We test for both uppercase and lowercase, for servers that
					// are case-sensitive with regard to file names. Load global first,
					// override with environment next
					if (file_exists($path.'config/'.strtolower($class).'.php'))
					{
						include($path.'config/'.strtolower($class).'.php');
						$found = TRUE;
					}
					elseif (file_exists($path.'config/'.ucfirst(strtolower($class)).'.php'))
					{
						include($path.'config/'.ucfirst(strtolower($class)).'.php');
						$found = TRUE;
					}

					if (file_exists($path.'config/'.ENVIRONMENT.'/'.strtolower($class).'.php'))
					{
						include($path.'config/'.ENVIRONMENT.'/'.strtolower($class).'.php');
						$found = TRUE;
					}
					elseif (file_exists($path.'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php'))
					{
						include($path.'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php');
						$found = TRUE;
					}

					// Break on the first found configuration, thus package
					// files are not overridden by default paths
					if ($found === TRUE)
					{
						break;
					}
				}
			}
		}

		$class_name = $prefix.$class;

		// Is the class name valid?
		if ( ! class_exists($class_name, FALSE) && (strpos($object_name,'/')===false))
		{
			log_message('error', 'Non-existent class: '.$class_name);
			show_error('Non-existent class: '.$class_name);
		}

		// Set the variable name we will assign the class to
		// Was a custom class name supplied? If so we'll use it
		if (empty($object_name))
		{
			$object_name = strtolower($class);
			if (isset($this->_ci_varmap[$object_name]))
			{
				$object_name = $this->_ci_varmap[$object_name];
			}
		}

		// Don't overwrite existing properties
		$CI =& get_instance();
		if(strpos($object_name,'/')!==false){
			if(!is_array($this->_ci_nested_classes_paths)){
				$this->_ci_nested_classes_paths=array();
			}
			$this->internal_worker($class_name,$object_name,$config);
			$this->_ci_nested_classes_paths[]=preg_replace("/\\/$/","",$object_name);
			asort($this->_ci_nested_classes_paths);
		}else{
			/* NORMAL */
			if (isset($CI->$object_name))
			{
				if ($CI->$object_name instanceof $class_name)
				{
					log_message('debug', $class_name." has already been instantiated as '".$object_name."'. Second attempt aborted.");
					return;
				}
				show_error("Resource '".$object_name."' already exists and is not a ".$class_name." instance.");
			}
	
			// Save the class name and object name
			$this->_ci_classes[$object_name] = $class;
	
			// Instantiate the class
			$CI->$object_name = isset($config)
				? new $class_name($config)
				: new $class_name();
		}
	}
	private $max_inner=9;
	private function internal_worker($class_name='',$object_name='',$config=null){
		$CI=&get_instance();
		$class_names=array_filter(explode('/',$object_name), create_function('$value', 'return $value !== "";'));
		$reversed_class_names=array_reverse($class_names);
		$count=count($reversed_class_names);
		$cc=0;
		$last_parent='';
		$PO=(object) array();
		foreach($reversed_class_names as $name){
			 $PO_G=$this->internal_worker_parent_obj($class_names);
			 if(($cc==0) && ($PO_G!==null) && ($count>1)){
			 	if(class_exists($class_name)){
					$PO_G->$name = isset($config)
					? new $class_name($config)
					: new $class_name();
			 	}else{
			 		log_message('error', 'Non-existent class: '.$class_name);
					show_error('Non-existent class: '.$class_name);
			 	}
				$PO = $PO_G;
			 }elseif(($PO_G!==null) && ($count>1)){
				$PO_G->$name=$PO;
				$PO = $PO_G;
			 }elseif($count>1){
				$CI->$name=$PO;
			 }else{
				$CI->$name=isset($config)
					? new $class_name($config)
					: new $class_name();
			 }
			 $cc++;
		 }
	}
	private function internal_worker_parent_obj(&$Class_names){
		$CI=&get_instance();
		array_pop($Class_names);
		$cc=0;
		$count=count($Class_names);
		if($count==0){
			return NULL;
		}
		$current_object=(object) array();
		foreach($Class_names as $name){
			if($cc==0){
				$current_object=$CI->$name;
			}elseif(@is_object($current_object->$name)){
				$current_object=$current_object->$name;
			}else{
				log_message('error', 'Non-existent class: '.$name);
				show_error('Non-existent class: '.$name);
				return null;
			}
			$cc++;
			/* END OF CYCLE */
		}
		return $current_object;
	}
}
