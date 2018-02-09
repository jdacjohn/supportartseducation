<?php include 'core/base.php';





//company
if(isset($_GET['co']))
	{
	$short = mysql_escape_string($_GET['co']);
	if(empty($_GET['co']))
		{
		header("Location: /$site_index");
		exit;
		}
	else
		{
		//echo $short.$site_id;
		$query = "SELECT * FROM co, co_site_list WHERE '$short'=co.co_id AND '$site_id'=co_site_list.site_id AND co_site_list.co_id=co.co_id LIMIT 1";
		$result = mysql_query($query) or die(mysql_error());
		//echo $query;
		//echo mysql_num_rows($result);
		if(mysql_num_rows($result)==0)
			{
			$pagetitle = '';
			$result = mysql_query("SELECT page_pass FROM page WHERE page_url='home' AND '$site_id'=site_id");
			while($row = mysql_fetch_assoc($result))
				{
				$page_pass=$row['page_pass'];
				if($page_pass == '1'){
					//check_logged();
					}
				}
			echo '<h1>Sorry</h1><hr>';
			echo '<p>This business does not exist.</p>';
			}
		else
			{
			while($row = mysql_fetch_array($result))
				{
				$co_name = $row['co_name'];
				$co_phone = $row['co_phone'];
				$co_fax = $row['co_fax'];
				$co_address_1 = $row['co_address_1'];
				$co_address_2 = $row['co_address_2'];
				$co_city = $row['co_city'];
				$co_state = $row['co_state'];
				$co_zip = $row['co_zip'];
				$co_email = $row['co_email'];
				$co_url1 = $row['co_url1'];
				$co_url2 = $row['co_url2'];
				$co_url2_name = $row['co_url2_name'];
				$co_url3 = $row['co_url3'];
				$co_url3_name = $row['co_url3_name'];
				$co_gallery = $row['co_gallery'];
				$co_linkedin = $row['co_linkedin'];
				$co_facebook = $row['co_facebook'];
				$co_google = $row['co_google'];
				$co_twitter = $row['co_twitter'];
				$co_youtube = $row['co_youtube'];
				$co_desc = strip_tags(html_entity_decode($row['co_desc'], ENT_QUOTES, 'utf-8'),$allowed_html);
				$seo_desc = $row['co_seo_desc'];
				$seo_keywords = $row['co_seo_keywords'];
				$pagetitle = $co_name;				
				$subquery = "SELECT card_video FROM card WHERE '$short'=co_id AND card_video!='' AND card_approve='1'  ORDER BY card_id DESC LIMIT 1";
				$subresult = mysql_query($subquery);
				if(mysql_num_rows($subresult)==0)
					{
					$subquery_sql = "SELECT * FROM card WHERE '$short'=co_id AND card_approve='1' ORDER BY card_id ASC";
					$subresult_result = mysql_query($subquery_sql) or die(mysql_error()); $card_id = '';
					if(mysql_num_rows($subresult_result)==0)
						{
						}
					elseif(mysql_num_rows($subresult_result)==1)
						{
						while($subrow_result = mysql_fetch_array($subresult_result))
							{
							$card_front=$subrow_result['card_front'];
							if(!empty($card_front))
								{
								//echo "<meta property='og:image' content='/assets/img/spotlights/new-".$card_front."'/>";
								}
							if(!empty($card_video))
								{
								//echo str_replace('class="BrightcoveExperience"', 'class="BrightcoveExperience"><param name="wmode" value="opaque"><param name="linkBaseURL" value="http://'.$site_url.'/company/'.$short.'"', $card_video);
								}
							else
								{
								}
							//echo '</div></div>';
							}
						//echo '<hr>';
						}
					else
						{}
					$facebookOg = '
						<meta property="og:description" content="'.$row['co_desc'].'"/>
						<meta property="og:type" content="movie"/>
						<meta property="og:url" content="http://'.$site_url.'/company/'.$short.'"/>
						<meta property="og:image" content="http://supportartseducation.com/assets/img/spotlights/new-'.$card_front.'"/>
						
					';
					}
				else
					{
					while($subrow = mysql_fetch_array($subresult))
						{
						$card_video=strip_tags(html_entity_decode($subrow['card_video'], ENT_QUOTES, 'utf-8'),$allowed_html);
						$video_id = my_strip('@videoPlayer" value="','" />',$card_video);
						$player_id = my_strip('playerID" value="','" />',$card_video);
						$video = $bc->find('find_video_by_id', $video_id);
						$facebookOg = '
						<meta property="og:description" content="'.$video->longDescription.'"/>
						<meta property="og:type" content="movie"/>
						<meta property="og:video:height" content="270"/>
						<meta property="og:video:width" content="480"/>
						<meta property="og:url" content="http://'.$site_url.'/company/'.$short.'"/>
						<meta property="og:video" content="http://c.brightcove.com/services/viewer/federated_f9/?isVid=1&isUI=1&playerID='.$player_id.'&autoStart=true&videoId='.$video_id.'">
						<meta property="og:video:secure_url" content="https://secure.brightcove.com/services/viewer/federated_f9/?isVid=1&isUI=1&playerID='.$player_id.'&autoStart=true&videoId='.$video_id.'&secureConnections=true">
						<meta property="og:image" content="'.$video->thumbnailURL.'"/>
						<meta property="og:video:type" content="application/x-shockwave-flash">
						<meta property="og:video" content="http://supportartseducation.com/assets/img/spotlights/new-'.$card_front.'">
						<meta property="og:video:type" content="video/mp4"/>
						';
						}
					}
				include $head;
				//check_logged();
				$co_descwtags = $co_desc;
				$co_desc = trim($co_desc);
				$co_desc = str_replace('"','',strip_tags($co_desc));
				$co_desc = str_replace('&',' ',$co_desc);
				$co_desc = str_replace('Pickles&',' ',$co_desc);
				$subquerys = "SELECT * FROM card WHERE '$short'=co_id AND card_approve='1' AND city_code = '2' AND card_front <> '' ORDER BY card_id ASC";
				$subresults = mysql_query($subquerys) or die(mysql_error()); $card_id = '';

				while($subrows = mysql_fetch_array($subresults))
					{
					$card_ids=$subrows['card_id'];
					$card_fronts=$subrows['card_front'];
				}
				$currentpage = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				$social_network = '<span style="position:relative;top:4px;margin-right:-1px;margin-top:0px;margin-bottom:0px;padding-bottom:-10px;padding-top:10px;">
				<a title="'.$co_name.'" rel="http://supportartseducation.com/assets/img/spotlights/tn-'.$card_front.'" href="http://www.facebook.com/sharer.php?
					s=100
					&p[url]='.$currentpage.'
					&p[images][0]=http://supportartseducation.com/assets/img/spotlights/new-'.$card_fronts.'
					&p[title]='.$co_name.'
					&p[summary]='.$co_desc.'" target="_blank" style="">
					<img src="http://supportartseducation.com/assets/img/facebook-icon.png" alt="Share on Facebook" style="margin-top:0px;" /></a></span>
				<span style="position:relative;top:4px;margin-right:7px;margin-left:4px;margin-top:0px;margin-bottom:0px;padding-bottom:-10px;padding-top:10px;"><a target="_blank" href="https://plus.google.com/share?url='.$currentpage.'" ><img
				  src="https://www.gstatic.com/images/icons/gplus-64.png" width="16" alt="Share on Google+"/></a></span><span style="position:relative;top:4px;margin-right:0px;margin-top:0px;margin-bottom:0px;margin-right:0px;padding-bottom:-10px;padding-top:10px;"><a target="_blank" href="http://twitter.com/share?url='.$currentpage.'&text='.$co_name.'"><img src="../assets/img/social-twitter2.png"></a></span>
				
				<span class="st_linkedin"></span>';	$social_network_home = '<span class="st_linkedin"></span><span class="st_facebook" st_url="http://supportartseducation.com/company/'.$short.'" st_title="'.$co_name.'" >';
				echo '<div style="float:right;text-align:center;">'.$social_network.'<br />Share This Profile</div>';
				echo '<h1>'.$pagetitle.'</h1><div style="float:right;margin-top:-35px;"></div><hr>';
				$subquery = "SELECT * FROM card WHERE '$short'=co_id AND card_approve='1' ORDER BY card_id ASC";
				$subresult = mysql_query($subquery) or die(mysql_error()); $card_id = '';
				if(mysql_num_rows($subresult)==0)
					{
					}
				elseif(mysql_num_rows($subresult)==1)
					{
					while($subrow = mysql_fetch_array($subresult))
						{
						$card_id=$subrow['card_id'];
						$card_front=$subrow['card_front'];
						$card_video=strip_tags(html_entity_decode($subrow['card_video'], ENT_QUOTES, 'utf-8'),$allowed_html);
						echo '<div class="listing"><div>';
						if(!empty($card_front))
							{
							echo '<img src="/assets/img/spotlights/new-'.$card_front.'">';
							}
						if(!empty($card_video))
							{
							echo str_replace('class="BrightcoveExperience"', 'class="BrightcoveExperience"><param name="wmode" value="opaque"><param name="linkBaseURL" value="http://'.$site_url.'/company/'.$short.'"', $card_video);
							}
						else
							{
							}
						echo '</div></div>';
						}
					echo '<hr>';
					}
				else
					{
					while($subrow = mysql_fetch_array($subresult))
						{
						$card_id=$subrow['card_id']; $card_front=$subrow['card_front']; $card_video=strip_tags(html_entity_decode($subrow['card_video'], ENT_QUOTES, 'utf-8'),$allowed_html);
						
							
						echo '<div class="listing" id="l"><div>';
						if(!empty($card_front))
							{
							echo '<img src="/assets/img/spotlights/new-'.$card_front.'">';
							}
						if(!empty($card_video))
							{
							echo str_replace('class="BrightcoveExperience"', 'class="BrightcoveExperience"><param name="wmode" value="opaque"><param name="linkBaseURL" value="http://'.$site_url.'/company/'.$short.'"', $card_video);
							}
						else
							{
							}
						echo '</div></div>';
						}
					echo '<div class="clear">&nbsp;</div><hr>';
					}
				if(empty($co_desc)) {echo '';} else { echo '<p>'.$co_descwtags.'</p>'; }					
				echo '<div id="card"><div id="left">';	
				if(empty($co_phone)) {echo '';} else { echo '<p><strong>Phone:</strong> '.$co_phone.'</p>'; }
				if(empty($co_fax)) {echo '';} else { echo '<p><strong>Fax:</strong> '.$co_fax.'</p>'; }				
				if(empty($co_email)) {echo '';} else { echo '<p><strong>Email:</strong> <a href="mailto:'.$co_email.'">'.$co_email.'</a></p>'; }
				if(empty($co_address_1) && empty($co_address_2) && empty($co_city) && empty($co_state) && empty($co_zip))
					{
					}
				else
					{
					if(!empty($co_address_1) OR !empty($co_address_2) OR !empty($co_city) OR !empty($co_state) OR !empty($co_zip))
						{
						echo '<p><strong>Address:</strong><br/>';
						if(empty($co_address_1)) {echo '';} else { echo $co_address_1.'</br/>'; }
						if(empty($co_address_2)) {echo '';} else { echo $co_address_2.'</br/>'; }
						if(empty($co_city)) {echo '';} else { echo $co_city; }
						if(!empty($co_state))
							{
							$subresult = mysql_query("SELECT state_name FROM state WHERE $co_state=state_id") or die(mysql_error());
							while($subrow = mysql_fetch_array($subresult))
								{
								$state_name = $subrow['state_name'];
								echo ', '.$state_name;
								}
							}
						if(empty($co_zip)) {echo '';} else { echo ' '.$co_zip; }
						echo '</p>';
						
						echo '<p><a href="http://maps.google.com/maps?q=';
						if(!empty($co_address_1)){ echo $co_address_1.' '; }
						if(!empty($co_address_2)){ echo $co_address_2.' '; }
						if(!empty($co_city)) { echo $co_city.','; }
						if(!empty($co_state))
							{
							$subresult = mysql_query("SELECT state_name FROM state WHERE $co_state=state_id") or die(mysql_error());
							while($subrow = mysql_fetch_array($subresult))
								{
								$state_name = $subrow['state_name'];
								echo $state_name.' ';
								}
							}
						if(!empty($co_zip)){ echo $co_zip; }
						echo '" target="_blank">';
						echo '
						<img alt="Googlemap" src="http://maps.google.com/maps/api/staticmap?center=';
						if(!empty($co_address_1)){ echo $co_address_1.' '; }
						if(!empty($co_address_2)){ echo $co_address_2.' '; }
						if(!empty($co_city)) { echo $co_city.','; }
						if(!empty($co_state))
							{
							$subresult = mysql_query("SELECT state_name FROM state WHERE $co_state=state_id") or die(mysql_error());
							while($subrow = mysql_fetch_array($subresult))
								{
								$state_name = $subrow['state_name'];
								echo $state_name.' ';
								}
							}
						if(!empty($co_zip)){ echo $co_zip; }
						echo '&markers=small|';
						if(!empty($co_address_1)){ echo $co_address_1.' '; }
						if(!empty($co_address_2)){ echo $co_address_2.' '; }
						if(!empty($co_city)) { echo $co_city.','; }
						if(!empty($co_state))
							{
							$subresult = mysql_query("SELECT state_name FROM state WHERE $co_state=state_id") or die(mysql_error());
							while($subrow = mysql_fetch_array($subresult))
								{
								$state_name = $subrow['state_name'];
								echo $state_name.' ';
								}
							}
						if(!empty($co_zip)){ echo $co_zip; }
						echo '&zoom=14'
						.'&size=375x200'
						.'&sensor=false"/></a>';
						echo '<br><a href="http://maps.google.com/maps?q=';
						if(!empty($co_address_1)){ echo $co_address_1.' '; }
						if(!empty($co_address_2)){ echo $co_address_2.' '; }
						if(!empty($co_city)) { echo $co_city.','; }
						if(!empty($co_state))
							{
							$subresult = mysql_query("SELECT state_name FROM state WHERE $co_state=state_id") or die(mysql_error());
							while($subrow = mysql_fetch_array($subresult))
								{
								$state_name = $subrow['state_name'];
								echo $state_name.' ';
								}
							}
						if(!empty($co_zip)){ echo $co_zip; }
						echo '" target="_blank">View Larger Map</a></p>';
						}
					}
				echo '</div><div id="right">';		
				if(empty($co_url1)) {echo '';} else { echo '<p><strong>Website:</strong> <a href="http://'.remove_http($co_url1).'" target="_blank">'.remove_http($co_url1).'</a></p>'; }
				if(empty($co_url2) OR empty($co_url2_name)) {echo '';} else { echo '<p><strong>'.$co_url2_name.':</strong> <a href="http://'.remove_http($co_url2).'" target="_blank">'.remove_http($co_url2).'</a></p>'; }
				if(empty($co_url2) OR empty($co_url3_name)) {echo '';} else { echo '<p><strong>'.$co_url3_name.':</strong> <a href="http://'.remove_http($co_url3).'" target="_blank">'.remove_http($co_url3).'</a></p>'; }
				if(empty($co_gallery)) {echo '';} else { echo '<p><strong>Photo Gallery:</strong> <a href="http://'.remove_http($co_gallery).'" target="_blank">'.remove_http($co_gallery).'</a></p>'; }
				if(empty($co_linkedin)) {echo '';} else { echo '<p><strong>Linked In:</strong> <a href="http://'.remove_http($co_linkedin).'" target="_blank">'.remove_http($co_linkedin).'</a></p>'; }
				if(empty($co_facebook)) {echo '';} else { 
				echo '<p><strong>Facebook:</strong>';
				echo ' <a href="http://'.remove_http($co_facebook).'" target="_blank">'.remove_http($co_facebook).'</a><br>';
				echo ' <div style="float:left;" class="fb-like" data-href="'.remove_http($co_facebook).'" data-send="true" data-width="450" data-show-faces="true" data-font="arial"></div><br></p>';}
				if(empty($co_google)) {echo '';} else { echo '<p><strong>Google+:</strong> <a href="http://'.remove_http($co_google).'" target="_blank">'.remove_http($co_google).'</a></p>'; }
				if(empty($co_twitter)) {echo '';} else { echo '<p><strong>Twitter:</strong> <a href="http://'.remove_http($co_twitter).'" target="_blank">'.remove_http($co_twitter).'</a><br><a href="http://'.remove_http($co_twitter).'" target="_blank"><img src="../../assets/img/twitter.jpg"></a></p>'; }
				if(empty($co_youtube)) {echo '';} else { echo '<p><strong>YouTube:</strong> <a href="http://'.remove_http($co_youtube).'" target="_blank">'.remove_http($co_youtube).'</a></p>'; }
				echo '</div><div class="clear">&nbsp;</div></div>';
				}
			}
		}
	if($co_desc == ""){
	}else{
		$co_desc = strip_tags($co_desc);
	}
	$currentpage = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
$social_network = '<hr><span style="position:relative;top:4px;margin-right:-1px;margin-top:0px;margin-bottom:0px;padding-bottom:-10px;padding-top:10px;"><a title="'.$co_name.'" rel="http://supportartseducation.com/assets/img/spotlights/tn-'.$card_front.'" href="http://www.facebook.com/sharer.php?s=100&p[url]='.$currentpage.'&p[images][0]=http://supportartseducation.com/assets/img/spotlights/new-'.$card_front.'&p[title]='.$co_name.'&p[summary]='.$co_desc.'" target="_blank" style=""><img src="http://supportartseducation.com/assets/img/facebook-icon.png" alt="Share on Facebook" style="margin-top:0px;" /></a></span>
<span style="position:relative;top:4px;margin-right:0px;margin-left:4px;margin-top:0px;margin-bottom:0px;padding-bottom:-10px;padding-top:10px;"><a target="_blank" href="https://plus.google.com/share?url='.$currentpage.'" ><img
  src="https://www.gstatic.com/images/icons/gplus-64.png" width="16" alt="Share on Google+"/></a></span>
  <span style="position:relative;top:4px;margin-right:0px;margin-top:0px;margin-bottom:0px;margin-right:0px;padding-bottom:-10px;padding-top:10px;"><a target="_blank" href="http://twitter.com/share?url='.$currentpage.'&text='.$co_name.'"><img src="../assets/img/social-twitter2.png"></a></span>
<span class="st_linkedin"></span>';	$social_network_home = '<span class="st_linkedin"></span><span class="st_facebook" st_url="http://supportartseducation.com/company/'.$short.'" st_title="'.$co_name.'" ></span><span class="st_google"></span><span class="st_email"></span><a href="javascript:window.print()" class="print">Print</a>';
	echo $social_network;
	include $foot;
	}
else
	{
	header("Location: /$site_index");
	exit;
	}




?>