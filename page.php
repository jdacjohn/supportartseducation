<?php include 'core/base.php';





//page
if(isset($_GET['page']))
	{
	$page = $_GET['page'];
	$page_id = mysql_escape_string($page);
	if (!empty($page_id))
		{
		$result = mysql_query("SELECT * FROM page WHERE page_url='$page_id' AND site_id='$site_id'");
		if (mysql_num_rows($result) > 0)
			{
			while($row = mysql_fetch_assoc($result))
				{
				$page_id=$row['page_id'];
				$page_pass=$row['page_pass'];
				$page_name=$row['page_name'];
				$page_headline=$row['page_headline'];
				$page_full=strip_tags(html_entity_decode($row['page_full'], ENT_QUOTES, 'utf-8'),$allowed_html);
				$page_video=strip_tags(html_entity_decode($row['page_video'], ENT_QUOTES, 'utf-8'),$allowed_html);
				$page_url=$row['page_url'];
				$page_date=convert_date($row['page_date']);
				$pagetitle = $page_headline;
				if($page_pass == '1'){
					//check_logged();
					}
				$seo_desc=$row['page_seo_desc'];
				$seo_keywords=$row['page_seo_keywords'];
				include $head;
				echo '<div class="page">';
				if($userlevel_no == '5')
					{
					echo '<a href="/panel/page.php?edit='.$page_id.'" class="edit">Edit this Page</a>';
					} else {}
				echo '<h1>'.$pagetitle.'</h1><div class="clear">&nbsp;</div><hr>';
				if(!empty($page_video))
					{
					echo str_replace('class="BrightcoveExperience"', 'class="BrightcoveExperience"><param name="wmode" value="opaque"', $page_video);
					} else {}
				if(!empty($page_full))
					{
					echo str_replace('<form action="https://www.paypal.com/cgi-bin/webscr" method="post">', '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
					<input type="hidden" name="custom" value="'.$user_id.'">', $page_full);
					} else {}
				if($page_url == 'contact')
					{
					//form processing
					if (isset($_POST) && !empty($_POST['ls_name']) && !empty($_POST['ls_phone']) && (filter_var($_POST['ls_email'], FILTER_VALIDATE_EMAIL)))
						{
						//form fields
						$ls_name = $_POST['ls_name'];
						$ls_email = $_POST['ls_email'];
						$ls_phone = $_POST['ls_phone'];
						$ls_message = $_POST['ls_message'];
						
						//subject and recipient
						$subject = $site_name.' - Inquiry';
						$recipient = $site_contact;
						$headers ="From: ${_POST['ls_email']}" . "\r\n";
						
						//mail server stuff
						$headers .= 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
						$message = '<html><head><title>'.$site_name.' - Inquiry</title></head>';
						$message .= '<body>';
						
						//email body
						$message .= "<strong>Name:</strong> ${_POST['ls_name']}<br><br>
						<strong>Email:</strong> ${_POST['ls_email']}<br><br>
						<strong>Phone:</strong> ${_POST['ls_phone']}<br><br>
						<strong>Message:</strong> ${_POST['ls_message']}
						</body></html>";
						
						//mail send function
						@$send=mail($recipient,$subject,$message,$headers) or die("Your submission did not go through. Please use the back button try again. Thank you.");
						echo '<hr><h2>Thank You</h2><p>'.$site_name.' will be in contact with you.</p>';
						}
					else
						{
						?>
						<hr>
						<form method="post" action="/pages/contact" enctype="multipart/form-data">
						
						<fieldset>
						    <legend class="<?= (isset($_POST['ls_name']) && empty($_POST['ls_name']) ? 'error' : '') ?>">*Name:</legend>
							<ul><li><input name="ls_name" value="<?= @$_POST['ls_name']?>" type="text"></li></ul>
						</fieldset>
						
						<fieldset>
						    <legend class="<?= (isset($_POST['ls_email']) && (!filter_var($_POST['ls_email'], FILTER_VALIDATE_EMAIL)) ? 'error' : '') ?>">*Email Address:</legend>
							<ul><li><input name="ls_email" value="<?= @$_POST['ls_email']?>" type="text"></li></ul>
						</fieldset>
						
						<fieldset>
						    <legend class="<?= (isset($_POST['ls_phone']) && empty($_POST['ls_phone']) ? 'error' : '') ?>">*Phone:</legend>
						    <ul><li><input name="ls_phone" value="<?= @$_POST['ls_phone']?>" type="text"></li></ul>
						</fieldset>
							
						<fieldset>
						    <legend>Message:</legend>
							<ul><li><textarea name="ls_message" rows="5"><?= @$_POST['ls_message']?></textarea></li>
							<li><input type="submit" value="Send" /></li></ul>
						</fieldset>
										
						</form>
						<?php
						}
					}
				echo '<div class="clear"></div></div>';
				}
			}
		else
			{
			include $head;
			header("Location: /");
			}
		}
	}
	
else
	{
	include $head;
	header("Location: /");
	}





include $foot; ?>