<?php include 'core/base.php';


//vip
if(isset($_GET['vip']))
	{
	$vip = $_GET['vip'];
	$vip_id = mysql_escape_string($vip);
	if (!empty($vip_id))
		{
		$result = mysql_query("SELECT * FROM vip WHERE vip_url='$vip_id' AND site_id='$site_id'");
		if (mysql_num_rows($result) > 0)
			{
			while($row = mysql_fetch_assoc($result))
				{
				$vip_id=$row['vip_id'];
				$vip_name=$row['vip_name'];
				$vip_sponsors=$row['sponsors'];
				$vip_headline=$row['vip_headline'];
				$vip_full=strip_tags(html_entity_decode($row['vip_full'], ENT_QUOTES, 'utf-8'),$allowed_html);
				$vip_video=strip_tags(html_entity_decode($row['vip_video'], ENT_QUOTES, 'utf-8'),$allowed_html);
				$vip_url=$row['vip_url'];
				$vip_seo_desc=$row['vip_seo_desc'];
				$vip_sponsors_title=$row['sponsors_title'];
				$vip_date=convert_date($row['vip_date']);
				$viptitle = $vip_headline;
				include $head;
				echo '<div class="vip">';
				if($userlevel_no == '5')
					{
					echo '<a href="/panel/vip.php?edit='.$vip_id.'" class="edit">Edit this VIP Page</a>';
					} else {}
				echo '<h1>'.$viptitle.'</h1><div class="clear">&nbsp;</div><hr>';
				if(!empty($vip_video))
					{
					echo str_replace('class="BrightcoveExperience"', 'class="BrightcoveExperience"><param name="wmode" value="opaque"', $vip_video);
					} else {}	
				if(!empty($vip_full))
					{
					echo $vip_full;
						} else {}
				if(empty($sponsors_toggle)){
					echo '<div class="clear"></div></div>';
					$sponsors = explode(',', $vip_sponsors);
					echo "";
					if(!empty($vip_sponsors_title)){
						echo "<div class='deck'><h2 align='center'>".$vip_sponsors_title."</h2>";
					}else{
						echo "<div class='deck'><h2 align='center'>".$vip_name." Sponsors</h2>";
					}
					foreach($sponsors as $sponsor){
						$sponsor_img = mysql_query("SELECT * FROM `card` WHERE card_id = '$sponsor'");
						while($rows = mysql_fetch_array($sponsor_img)){
							echo "<p class='spot'><a href='http://www.supportartseducation.com/company/".$rows['co_id']."'><img src='http://www.supportartseducation.com/assets/img/spotlights/tn-".$rows['card_front']."'></a></p>";
						}
					}
				}
				echo "</div><br clear='all'>";
				}			
			}
		else
			{
			$home_url = 'http://'.$site_url.'';
			header("Location: $home_url");
			exit;
			}
		}
	}
	
else
	{
	$home_url = 'http://'.$site_url.'';
	header("Location: $home_url");
	exit;
	}
	?>
	<?php
	$currentpage = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
$social_network = '<hr><span style="position:relative;top:4px;margin-right:-1px;margin-top:0px;margin-bottom:0px;padding-bottom:-10px;padding-top:10px;"><a title="'.$vip_name.'" rel="http://supportartseducation.com/assets/img/spotlights/tn-'.$card_front.'" href="http://www.facebook.com/sharer.php?s=100&p[url]='.$currentpage.'&p[images][0]=http://supportartseducation.com/assets/img/spotlights/new-'.$card_front.'&p[title]='.$vip_name.'&p[summary]='.$vip_seo_desc.'" target="_blank" style=""><img src="http://supportartseducation.com/assets/img/facebook-icon.png" alt="Share on Facebook" style="margin-top:0px;" /></a></span>
<span style="position:relative;top:4px;margin-right:0px;margin-left:4px;margin-top:0px;margin-bottom:0px;padding-bottom:-10px;padding-top:10px;"><a target="_blank" href="https://plus.google.com/share?url='.$currentpage.'" ><img
  src="https://www.gstatic.com/images/icons/gplus-64.png" width="16" alt="Share on Google+"/></a></span>
  <span style="position:relative;top:4px;margin-right:0px;margin-top:0px;margin-bottom:0px;margin-right:0px;padding-bottom:-10px;padding-top:10px;"><a target="_blank" href="http://twitter.com/share?url='.$currentpage.'&text='.$vip_name.'"><img src="../assets/img/social-twitter2.png"></a></span>
<span class="st_linkedin"></span>';	$social_network_home = '<span class="st_linkedin"></span><span class="st_facebook" st_url="http://'.$vip_url.'.supportartseducation.com" st_title="'.$vip_name.'" ></span><span class="st_google"></span><span class="st_email"></span><a href="javascript:window.print()" class="print">Print</a>';
	echo $social_network;


include $foot; ?>