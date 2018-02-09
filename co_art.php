<?php include 'core/base.php';





//arts
if(isset($_GET['art']))
	{
	$short = mysql_escape_string($_GET['art']);
	if(empty($_GET['art']))
		{
		header("Location: /$site_index");
		exit;
		}
	else
		{
		$query = "SELECT co_art.co_art_name, co_art.co_art_desc FROM card, co, co_art, co_art_list WHERE '$short'=co_art.co_art_id AND co_art.co_art_id=co_art_list.co_art_id AND co_art_list.co_id=co.co_id AND '$site_id'=card.site_id AND card.co_id=co.co_id AND card.card_approve='1' AND card.card_video='' LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($result)==0)
			{
			$pagetitle = '';
			$result = mysql_query("SELECT page_pass FROM page WHERE page_url='arts' AND '$site_id'=site_id");
			while($row = mysql_fetch_assoc($result))
				{
				$page_pass=$row['page_pass'];
				if($page_pass == '1'){check_logged();}
				}
			include $head;
			echo '<h1>Sorry</h1><hr>';
			echo '<p>There are no BizCard Spotlights&trade; for this Category.</p>';
			}
		else
			{
			while($row = mysql_fetch_array($result))
				{
				$co_art_name = $row["co_art_name"];
				$co_art_desc = html_entity_decode($row["co_art_desc"]);
				$pagetitle = $co_art_name;
				$result = mysql_query("SELECT page_pass FROM page WHERE page_url='arts' AND '$site_id'=site_id");
				while($row = mysql_fetch_assoc($result))
					{
					$page_pass=$row['page_pass'];
					if($page_pass == '1'){
						//check_logged();
						}
					}
				include $head;
				echo '<h1>'.$pagetitle.'</h1><hr>';
				if(!empty($co_art_desc))
					{
					echo '<p>'.$co_art_desc.'</p><hr>';
					} else {}
				$page_link = '/arts/'.$short.'/';
				$query = "SELECT COUNT(*) FROM card, co_art_list WHERE '$site_id'=card.site_id AND '$short'=co_art_list.co_art_id AND co_art_list.co_id=card.co_id AND card.card_approve='1' AND card.card_video=''";
				$limit = '9999';
				echo '<div class="pages" id="top">'; echo pagination($query,$page_link,$limit); echo '</div>'; $limstring = paginationCount($query,$limit);
				echo '<div class="deck">';
				$query2 = "SELECT card.card_id, card.card_front, co.co_id, co.co_name FROM card, co, co_art_list WHERE '$short'=co_art_list.co_art_id AND co_art_list.co_id=co.co_id AND '$site_id'=site_id AND card.co_id=co.co_id AND card.card_approve='1' AND card.card_video='' ORDER BY card.card_id DESC $limstring";
				$result = mysql_query($query2) or die(mysql_error());
				while($row = mysql_fetch_array($result))
					{
					$card_front=$row['card_front'];
					$co_id = $row["co_id"];
					$co_name = $row["co_name"];
					echo '<p class="spot"><a href="/company/'.$co_id.'"><img src="/assets/img/spotlights/tn-'.$card_front.'" alt="'.$co_name.'">';
					$subresult = mysql_query("SELECT card.card_id FROM card, co, co_art_list WHERE '$short'=co_art_list.co_art_id AND co_art_list.co_id=co.co_id AND '$site_id'=site_id AND '$co_id'=card.co_id AND card.card_approve='1' AND card.card_video!='' LIMIT 1") or die(mysql_error());
					if(mysql_num_rows($subresult)==0)
						{
						echo '<br><span class="space">&nbsp;</span>';
						}
					else
						{
						while($row = mysql_fetch_array($subresult))
							{
							echo '<br><span class="play">Video</span><span class="ultra">ultra</span>';					
							}
						}
					echo '</a></p>';
					}
				echo '<div class="clear">&nbsp</div></div>'; echo '<div class="pages">'; echo pagination($query,$page_link,$limit); echo '</div>';
				}
			}
		}
		//echo $co_art_desc;
		$currentpage = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		$social_network = '<hr><span style="position:relative;top:4px;margin-right:-1px;margin-top:0px;margin-bottom:0px;padding-bottom:-10px;padding-top:10px;"><a title="'.$co_art_name.'" href="http://www.facebook.com/sharer.php?s=100&p[url]='.$currentpage.'&p[images][0]=http://supportartseducation.com/assets/img/logo.png&p[title]='.$co_art_name.'&p[summary]='.$co_art_desc.'" target="_blank" style=""><img src="http://supportartseducation.com/assets/img/facebook-icon.png" alt="Share on Facebook" style="margin-top:0px;" /></a></span>
		<span class="st_linkedin"></span><span class="st_twitter" ></span><span class="st_email"></span><a href="javascript:window.print()" class="print">Print</a>';
		
	echo $social_network;
	include $foot;
	}
else
	{
	header("Location: /$site_index");
	exit;
	}




?>