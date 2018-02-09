<?php $pagetitle = "Lost Password"; include 'core/base.php'; $div="register"; include $head;





echo '<h1>'.$pagetitle.'</h1>';

if(!isset($_SESSION['user_id']))
	{
	if (isset($_POST) && !empty($_POST['lost_user_email']) && (filter_var($_POST['lost_user_email'], FILTER_VALIDATE_EMAIL)))
		{
		$lost_user_email = mysql_real_escape_string($_POST['lost_user_email']);
		
		$result = mysql_query("SELECT user_login FROM user WHERE user_email='$lost_user_email'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$lost_user_login = $row['user_login'];
		if(mysql_num_rows($result)==0)
			{
			echo '<p>This email address could not be found. <a href="/lost-password">Please try again</a>.</p>';
			}
		else
			{
			$lost_user_pass = substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6);
			$hash_lost_user_pass = md5($lost_user_pass);
			$result = mysql_query("UPDATE user SET user_pass='$hash_lost_user_pass' WHERE user_email='$lost_user_email'")or die('Error : ' . mysql_error());
			send_mail($site_contact, $_POST['lost_user_email'], ''.$site_name.' - Your New Password', 'Your username is: '.$lost_user_login.' and your password is: '.$lost_user_pass);
			echo '<p>Your password has been reset. Please check your email for your new password!</p>';
			}
		}
	else
		{
		?>
		<p>Lost your password? Fill out the form below to have your password reset.</p>
		<hr>
		<form method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data">
		
		<fieldset>
		    <legend<?= (isset($_POST['lost_user_email']) && (!filter_var($_POST['lost_user_email'], FILTER_VALIDATE_EMAIL)) ? ' class="error"' : '') ?>>*Email:</legend>
			<ul><li><input type="text" name="lost_user_email" id="lost_user_email" value="<?php if(isset($_POST['lost_user_email']) != ''){ echo $_POST['lost_user_email']; } else {} ?>"></li>
			<li><button type="submit" value="Send" name="submit" onMouseOut="return lost_user()">Reset My Password</button></li></ul>
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