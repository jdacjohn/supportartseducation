<?php $pagetitle = "Register"; include 'core/base.php';



	

if(isset($_GET['reactivate'])){
	$useremail = $_GET['reactivate'];
	//mysql_query("UPDATE user SET supportartseducation_status='0' WHERE user_login ='$useremail'");
	//mysql_query("UPDATE co SET supportartseducation_status='0' WHERE co_contact_email ='$useremail'");
	echo "<script language='javascript'>";
	echo "alert('Your account is now reactivated, you will be redirected to our home page.')";
	echo "window.location='/'";
	echo "</script>";
	header("Location: /prelaunch?reactivate");
}
//featured
$result = mysql_query("SELECT * FROM page WHERE page_url='register' AND site_id='$site_id'");
if (mysql_num_rows($result) > 0)
	{
	while($row = mysql_fetch_assoc($result))
		{
		$page_id=$row['page_id'];
		$page_pass=$row['page_pass'];
		$page_headline=$row['page_headline'];
		$page_full=strip_tags(html_entity_decode($row['page_full'], ENT_QUOTES, 'utf-8'),$allowed_html);
		$page_video=strip_tags(html_entity_decode($row['page_video'], ENT_QUOTES, 'utf-8'),$allowed_html);
		$pagetitle = $page_headline;
		if($page_pass == '1'){check_logged();}
		include $head;
		if($userlevel_no == '5'){echo '<a href="/panel/page.php?edit='.$page_id.'" class="edit">Edit this Page</a>';}
		echo '<h1>'.$pagetitle.'</h1><div class="clear">&nbsp;</div><hr>';
		if(!empty($page_video))
			{
			echo str_replace('class="BrightcoveExperience"', 'class="BrightcoveExperience"><param name="wmode" value="opaque"', $page_video);
			} else {}
		if(!empty($page_full)){echo $page_full.'<hr>';}
		}
	}
if(!isset($_SESSION['user_id']))
	{
	//form processing
	if (isset($_POST) && !empty($_POST['new_user_email']) && (filter_var($_POST['new_user_email'], FILTER_VALIDATE_EMAIL)) && (filter_var($_POST['new_user_email'], FILTER_VALIDATE_EMAIL)) && ($_POST['new_user_email']==$_POST['new_user_email2']) && !empty($_POST['new_user_pass']))
		{
		$new_user_login = mysql_real_escape_string($_POST['new_user_email']);
		$new_user_pass = mysql_real_escape_string($_POST['new_user_pass']);
		$new_user_email = mysql_real_escape_string($_POST['new_user_email']);
		$new_user_name_f = mysql_real_escape_string($_POST['new_user_name_f']);
		$new_user_name_l = mysql_real_escape_string($_POST['new_user_name_l']);
		$hash_new_user_pass = md5($new_user_pass);
		$query = mysql_query("INSERT INTO user (user_login, user_pass, user_email, user_ip, user_date, userlevel_no, user_name_f, user_name_l) VALUES ('$new_user_login', '$hash_new_user_pass', '$new_user_email', '$_SERVER[REMOTE_ADDR]', NOW(), '1', '$new_user_name_f', '$new_user_name_l')");
		if(mysql_affected_rows($link)==1)
			{
			echo '<p>Thank You. You have now been registered. <a href="/login">Login to Your New Account</a></p>';
			//mail to admin
				//subject and recipient
				$subject = $site_name.' - New User';
				$recipient = $site_contact;
				$headers ="From: ${_POST['new_user_email']}" . "\r\n";
				
				//mail server stuff
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
				$message = '<html><head><title>'.$site_name.' - New User</title></head>';
				$message .= '<body>';
				
				//email body
				$message .= "<strong>Name:</strong> ${_POST['new_user_name_f']} ${_POST['new_user_name_l']}<br><br>
				<strong>Email:</strong> ${_POST['new_user_email']}
				</body></html>";
	
				//mail send function
				@$send=mail($recipient,$subject,$message,$headers);
			//end mail to admin
			}
		else
			{
			echo '<p>There was an error. <a href="/register">Please try again</a>.</p>';
			}
		}
	else
		{
		?>
		<form method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data">
		
		<fieldset>
		    <legend<?= (isset($_POST['new_user_email']) && (!filter_var($_POST['new_user_email'], FILTER_VALIDATE_EMAIL)) ? ' class="error"' : '') ?>>*Your Email:</legend>
			<ul><li><input type="text" name="new_user_email" id="new_user_email" onMouseOver="return check_email()" value="<?php if(isset($_POST['new_user_email']) != ''){ echo $_POST['new_user_email']; } else {} ?>"><div id="emailhint"></div></li></ul>
		</fieldset>
		
		<fieldset>
		    <legend<?= (isset($_POST['new_user_email2']) && (empty($_POST['new_user_email2']) or ($_POST['new_user_email'] != $_POST['new_user_email2'])) ? ' class="error"' : '') ?>>*Verify Your Email:</legend>
			<ul><li><input type="text" name="new_user_email2" id="new_user_email2" value="<?php if(isset($_POST['new_user_email2']) != ''){ echo $_POST['new_user_email2']; } else {} ?>"></li></ul>
		</fieldset>
		
		<fieldset>
		    <legend<?= (isset($_POST['new_user_pass']) && empty($_POST['new_user_pass']) ? ' class="error"' : '') ?>>*New Password:</legend>
			<ul><li><input type="password" name="new_user_pass" value="<?php if(isset($_POST['new_user_pass']) != ''){ echo $_POST['new_user_pass']; } else {} ?>"></li></ul>
		</fieldset>
		
		<fieldset>
		    <legend>First Name:</legend>
			<ul><li><input type="text" name="new_user_name_f" value="<?php if(isset($_POST['new_user_name_f']) != ''){ echo $_POST['new_user_name_f']; } else {} ?>"></li></ul>
		</fieldset>
		
		<fieldset>
		    <legend>Last Name:</legend>
			<ul><li><input type="text" name="new_user_name_l" value="<?php if(isset($_POST['new_user_name_l']) != ''){ echo $_POST['new_user_name_l']; } else {} ?>"></li>
			<li><button type="submit" value="Send" name="submit">Register</button></li></ul>
		</fieldset>
						
		</form>
		<?php
		}
	}

else
	{
	echo '<p>If you are not '; if($user_name_f!=''){echo $user_name_f;} else {echo $user_login;} echo '... Please <a href="/login/?logout">Log Out</a> before registering.</p>';
	}





include $foot; ?>