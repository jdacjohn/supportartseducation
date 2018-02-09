<?php
ob_start();
if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');

function checkEmail($str)
	{
	return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
	}

function send_mail($from,$to,$subject,$body)
	{
	$headers = '';
	$headers .= "From: $from\n";
	$headers .= "Reply-to: $from\n";
	$headers .= "Return-Path: $from\n";
	$headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Date: " . date('r', time()) . "\n";
	mail($to,$subject,$body,$headers);
	}

function get_php_self()
	{
	return isset($_SERVER['PHP_SELF']) ? htmlentities(strip_tags($_SERVER['PHP_SELF'],''), ENT_QUOTES, 'UTF-8') : '';
	}

function check_logged()
	{ 
	global $_SESSION;
	if(!isset($_SESSION['user_id']))
		{
		$_SESSION['destination'] = $_SERVER['REQUEST_URI'];
		header("Location: /login");
		exit;
		}
	}
	
function check_access($user_no)
	{
	global $_SESSION;
	global $userlevel_no;
	if(!isset($_SESSION['user_id']))
		{
		header("Location: /login");
		exit;
		}
	else
		{
		if($userlevel_no < $user_no)
			{
			header("Location: /accessdenied");
			exit;
			}
		else
			{
			}
		}
	}
	
function current_url()
	{
	$url = "http://";
	if ($_SERVER["SERVER_PORT"] != "80")
		{
		$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
	else
		{
		$url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
	return $url;
	}
	
function convert_date($data_date)
	{
	$date=strtotime($data_date);
	$final_date=date("F j, Y, g:i a", $date);
	return $final_date;
	}
	
function remove_http($url = '')
	{
	return(str_replace(array('http://','https://'), '', $url));
	}
/*
$url = 'http://google.com';
echo remove_http($url);
*/

function pagination($query, $page_link, $limit)
	{ 
	global $PHP_SELF;	
	$getcount = mysql_query ($query);
	$postnum = mysql_result($getcount,0);
	
	if($postnum > $limit)
		{
		$tagend = round($postnum % $limit,0); $splits = round(($postnum - $tagend)/$limit,0);
		if($tagend == 0){$num_pages = $splits;} else{$num_pages = $splits + 1;}
		if(isset($_GET['pg'])){$pg = $_GET['pg'];} else{$pg = '1';}
		$startpos = ($pg*$limit)-$limit;
		$limstring = "LIMIT $startpos,$limit";
		}
	else
		{
		$limstring = "LIMIT 0,$limit";
		}
	if($postnum > $limit)
		{
		if(!empty($page_link))
			{
			}
		else
			{
			$page_link = '?pg=';
			}
		$m = $pg + 2; $n = $pg + 1; $p = $pg - 1; $q = $pg - 2;
		if($pg > 1){echo '<a href="'.$page_link.'1">&laquo;</a> <a href="'.$page_link.''.$p.'">&lsaquo;</a> ';} else{}
		if($q > 0){echo '<a href="'.$page_link.''.$q.'">'.$q.'</a> ';} else {}
		if($p > 0){echo '<a href="'.$page_link.''.$p.'">'.$p.'</a> ';} else {}
		echo "<span>$pg</span> ";
		if($n <= $num_pages){echo '<a href="'.$page_link.''.$n.'">'.$n.'</a> ';} else {}
		if($m <= $num_pages){echo '<a href="'.$page_link.''.$m.'">'.$m.'</a> ';} else {}
		if($pg < $num_pages){echo '<a href="'.$page_link.''.$n.'">&rsaquo;</a> <a href="'.$page_link.''.$num_pages.'">&raquo;</a>';} else {}
		}
	}

function paginationCount($query, $limit)
	{ 
	$getcount = mysql_query ($query);
	$postnum = mysql_result($getcount,0);
	if($postnum > $limit)
		{
		$tagend = round($postnum % $limit,0); $splits = round(($postnum - $tagend)/$limit,0);
		if($tagend == 0){$num_pages = $splits;} else{$num_pages = $splits + 1;}
		if(isset($_GET['pg'])){$pg = $_GET['pg'];} else{$pg = '1';}
		$startpos = ($pg*$limit)-$limit;
		$limstring = "LIMIT $startpos,$limit";
		}
	else
		{
		$limstring = "LIMIT 0,$limit";
		}
	return($limstring);
	}
	
function my_strip($start,$end,$total)
	{
	$total = stristr($total,$start);
	$f2 = stristr($total,$end);
	return substr($total,strlen($start),-strlen($f2));
	}
?>