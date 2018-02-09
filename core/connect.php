<?php
if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');

$link = mysql_connect($db_host,$db_user,$db_user_pass) or die('Unable to establish a DB connection');
mysql_select_db($db_database,$link);
?>