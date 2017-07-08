<?php
defined('FlameCMS') or die('No Script Cuddies');
class Settings{
	function add($name,$value){
		$sys=&get_inst();
		$id=null;
		$id=$this->get_id($name);
		if($id!==null){
			$this->edit($name,$value,$id);
			return true;
		}
		$new_data=array();
		$new_data['setting_ind']=$name;
		if(is_array($value) || is_object($value)){
			$new_data['setting_value']=json_encode($value);
			$new_data['setting_type']='j';
		}elseif(is_bool($value)){
			$new_data['setting_value']=json_encode($value);
			$new_data['setting_type']='b';
		}elseif(is_string($value)){
			$new_data['setting_value']=''.$value;
			$new_data['setting_type']='s';
		}elseif(is_int($value)){
			$new_data['setting_value']=''.$value;
			$new_data['setting_type']='i';
		}elseif(is_float($value)){
			$new_data['setting_value']=''.$value;
			$new_data['setting_type']='f';
		}elseif(is_double($value)){
			$new_data['setting_value']=''.$value;
			$new_data['setting_type']='d';
		}
		$sys->db->set($new_data);
		$sys->db->insert('settings');
		return $sys->db->insert_id();
	}
	function edit($name,$value,$id=null){
		$sys=&get_inst();
		$new_data=array();
		$new_data['setting_ind']=$name;
		if(is_array($value) || is_object($value)){
			$new_data['setting_value']=json_encode($value);
			$new_data['setting_type']='j';
		}elseif(is_bool($value)){
			$new_data['setting_value']=json_encode($value);
			$new_data['setting_type']='b';
		}elseif(is_string($value)){
			$new_data['setting_value']=''.$value;
			$new_data['setting_type']='s';
		}elseif(is_int($value)){
			$new_data['setting_value']=''.$value;
			$new_data['setting_type']='i';
		}elseif(is_float($value)){
			$new_data['setting_value']=''.$value;
			$new_data['setting_type']='f';
		}elseif(is_double($value)){
			$new_data['setting_value']=''.$value;
			$new_data['setting_type']='d';
		}
		if($id===null){
			$id=$this->get_id($name);
			$sys->db->where('setting_id',$id);
		}else{
			$sys->db->where('setting_id',$id);
		}
		$sys->db->set($new_data);
		$sys->db->update('settings');
		return $id;
	}
	function get_id($name){
		$sys=&get_inst();
		if(''.intval($name)==$name){
			/*id?*/
			$sys->db->where('setting_id',$name);
			$r=$sys->db->get('settings');
		}else{
			/*setting name*/
			$sys->db->where('setting_ind',$name);
			$r=$sys->db->get('settings');
		}
		if($r->num_rows()>0){
			$row=$r->row_array();
			//$row['setting_type'];
			return $row['setting_id'];
		}else{
			return null;
		}
	}
	function get($name){
		$sys=&get_inst();
		if(''.intval($name)==$name){
			/*id?*/
			$sys->db->where('setting_id',$name);
			$r=$sys->db->get('settings');
		}else{
			/*setting name*/
			$sys->db->where('setting_ind',$name);
			$r=$sys->db->get('settings');
		}
		if($r->num_rows()>0){
			$row=$r->row_array();
			//$row['setting_type'];
			//$row['setting_value'];
			if($row['setting_type']=='j')/*json*/{
				return (array) json_decode($row['setting_value']);
			}elseif($row['setting_type']=='b'){
				return ((json_decode($row['setting_value'])=='true') || (json_decode($row['setting_value'])==true))?true:false;
			}elseif($row['setting_type']=='s'){
				return $row['setting_value'];
			}elseif($row['setting_type']=='i'){
				return intval($row['setting_value']);
			}elseif($row['setting_type']=='f'){
				return floatval($row['setting_value']);
			}elseif($row['setting_type']=='d'){
				return doubleval($row['setting_value']);
			}
		}else{
			return null;
		}
	}
	function get_all(){
		$sys=&get_inst();
		$q=$sys->db->get('settings');
		return $q->result_array();
	}
}