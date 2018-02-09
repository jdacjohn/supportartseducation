<?php $pagetitle = "Log In"; include 'core/base.php';

if(isset($_GET['logoff']))
	{
	$_SESSION = array();
	session_destroy();
	header("Location: http://$site_url/$site_index");
	exit;
	}

if(isset($_POST['submit']))
	{
	// Checking whether the Login form has been submitted and will hold our errors
	$error = array();
			
	if(!$_POST['user_login'] || !$_POST['user_pass'])
		$error[] = 'All the fields must be filled in!';
		
	if(!count($error))
		{
		$_POST['user_login'] = mysql_real_escape_string($_POST['user_login']);
		$_POST['user_pass'] = mysql_real_escape_string($_POST['user_pass']);
		// Escaping all input data
		$row = mysql_fetch_assoc(mysql_query("SELECT user_id, user_login FROM user WHERE user_login='{$_POST['user_login']}' AND user_pass='".md5($_POST['user_pass'])."'"));
		if($row['user_login'])
			{
			// If everything is OK login
			$_SESSION['user_login']=$row['user_login'];
			$_SESSION['user_id'] = $row['user_id'];
			// Store some data in the session
			}
		else $error[]='Wrong login and/or password!';
		}
		
	if($error)
		$_SESSION['msg']['login-error'] = implode('<br />',$error);
		// Save the error messages in the session
		header("Location: /login");
		exit;
	}

if(!isset($_SESSION['user_id']))
	{
	include $head;
	?>
	<!-- Login Form -->
	<h1>Member Login</h1><div class="clear">&nbsp;</div><hr>
	
	<form action="<?php echo $PHP_SELF; ?>" method="post">
	<?php
	if(isset($_SESSION['msg']['login-error']))
		{
		echo '<div class="error">'.$_SESSION['msg']['login-error'].'</div>';
		unset($_SESSION['msg']['login-error']);
		}
	?>
	<fieldset>
	    <legend>email:</legend>
		<ul><li><input type="text" name="user_login"></li></ul>
	</fieldset>

	<fieldset>
	    <legend>password:</legend>
		<ul><li><input type="password" name="user_pass"></li>
		<li><input type="submit" name="submit" value="Login"></li></ul>
	</fieldset>
	<hr>
	<h3><a href="/lost-password">Lost Your Password?</a> &middot; <a href="/register">Register Today!</a></h3>
	</form>
	<?php
	}
else
	{
	$result = mysql_query("SELECT user_site_list_id FROM user_site_list WHERE user_id='$user_id' AND site_id='$site_id'");
	if (mysql_num_rows($result) > 0)
		{
		}
	else
		{
		mysql_query("INSERT INTO user_site_list (user_id, site_id) VALUES ('$user_id', '$site_id')");	
		}
	if(isset($_SESSION['destination']))
		{
	    header('Location: ' . $_SESSION['destination']);
	    exit;
		}
	else
		{
		header("Location: /panel");
		exit;
		}
	}





include $foot; ?>