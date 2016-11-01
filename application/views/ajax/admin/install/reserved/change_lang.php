<?php
$sys=&get_inst();
$lang=$_POST['lang'];
$sys->ilang->set_installer_lang($lang);