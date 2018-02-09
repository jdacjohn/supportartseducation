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
				if($page_pass == '1'){check_logged();}
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