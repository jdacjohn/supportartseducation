<?php include 'core/base.php';
$uri = $_SERVER['REQUEST_URI'];
if ( strpos($uri,'?reactivate') !== false ) {
   echo "<h1 style='background-color:#ff0000;padding:20px 10px;'>Your account has been reactivated.</h1>";
}
$result = mysql_query("SELECT page_pass FROM page WHERE page_url='home' AND '$site_id'=site_id");
while($row = mysql_fetch_assoc($result))
	{
	$page_pass=$row['page_pass'];
	if(($page_pass == '0') OR isset($_GET['prelaunch']) OR 1==1)
		{
		$homepage = "on";
		include $head;
		?>
<div class="content" id="col">
<div class="homepage">
  <?php 
			$result = mysql_query("SELECT page_video FROM page WHERE page_url='home' AND '$site_id'=site_id");
			while($row = mysql_fetch_assoc($result))
				{
				$page_video=strip_tags(html_entity_decode($row['page_video'], ENT_QUOTES, 'utf-8'),$allowed_html);
				if(!empty($page_video))
					{
					echo str_replace('class="BrightcoveExperience"', 'class="BrightcoveExperience"><param name="wmode" value="opaque"><param name="linkBaseURL" value="http://'.$site_url.'/"', $page_video);
					} else {}
				}
			?>
</div>
<div id="col1">
  <h1><a href="/featured">Featured Spotlights</a></h1>
  <hr>
  <div class="hero">
    <?php	
				$result = mysql_query("SELECT card.card_id, card.card_front, co.co_id, co.co_name FROM card, co, co_feat_list, co_site_list WHERE '$site_id'=card.site_id AND '$site_id'=co_feat_list.site_id AND '$site_id'=co_site_list.site_id AND co.co_id=card.co_id AND co.co_id=co_feat_list.co_id AND co.co_id=co_site_list.co_id AND card_approve='1' AND card_video='' ORDER BY RAND() DESC LIMIT 2") or die(mysql_error());
				while($row = mysql_fetch_array($result))
					{
					$card_front=$row['card_front'];
					$co_id = $row["co_id"];
					$co_name = $row["co_name"];
					echo '<p class="spot"><a href="/company/'.$co_id.'"><img src="/assets/img/spotlights/tn-'.$card_front.'" alt="'.$co_name.'">';
						$subresult = mysql_query("SELECT card.card_id FROM card, co WHERE $site_id=site_id AND card.co_id=$co_id AND card.card_approve='1' AND card.card_video!='' LIMIT 1") or die(mysql_error());
						while($row = mysql_fetch_array($subresult))
							{
							echo '<br><span class="play">Video</span><span class="ultra">ultra</span>';
							}
					echo '</a></p>';
					}
				?>
    <a href="/featured" class="button">View Featured</a></div>
</div>
<div id="col2">
<?php
		$result = mysql_query("SELECT * FROM page WHERE page_url='home' AND '$site_id'=site_id");
		while($row = mysql_fetch_assoc($result))
			{
			$page_id=$row['page_id'];
			$page_name=$row['page_name'];
			$page_full=strip_tags(html_entity_decode($row['page_full'], ENT_QUOTES, 'utf-8'),$allowed_html);
			$page_date=convert_date($row['page_date']);
			$pagetitle = $page_name;
			echo $page_full;
			echo '<div class="clear"></div></div><div class="clear">&nbsp;</div>';
			}
		include $foot;
		}
	else//*************************************************ELSE!!!!!!!!!!!!!!!!!
		{
		?>
<html>
		<head>
              <!-- Start Brightcove Embed for Facebook News Feed -->

      <meta name="medium" content="video" />

      <link rel="image_src" href="http://brightcove.vo.llnwd.net/d7/unsecured/media/196565915/196565915_14878699001_vs-196565915-vid14876941001-img0000.jpg?pubId=196565915" />

      <link rel="Viral_Player" href="http://link.brightcove.com/services/player/bcpid1425663498001?bckey=AQ~~,AAABS5tCuEE~,H_fW3C-DpOzDRylKQ_hbfA52BjwHf-vd" />

      <meta name="video_height" content="336" />

      <meta name="video_width" content="385" />

      <meta name="video_type" content="application/x-shockwave-flash" />

      <!-- End Brightcove Embed for Facebook News Feed -->

      <!-- facebook button end -->

		<title><?php echo $site_name; ?></title>
		<link type="text/css" href="<?php echo 'http://'.$site_url; ?>/assets/css/prelaunch.css" rel="stylesheet" media="screen">
		<script type="text/javascript"> 
		 
		/*
		 
			This example shows how to utilize the linkBaseURL player configuration parameter
		and the getLink() and setLink() methods of the Social module to display a custom URL
		in players and maintain deep linking capabilities by appending the Playlist ID and
		video ID to the URL.
		 
		More information about linkBaseURL:
		http://help.brightcove.com/publisher/docs/publishing/config-params.cfm
		 
		More information about the Social module:
		http://help.brightcove.com/developer/docs/playerapi/player-API.cfm#Social%20Module
		 
			This code utilizes the templateReady and videoChange events to know when to update
		the URL displayed in the players menu function. Because modules load before the
		individual components, the tabBar component for example, the initial videoChange event
		occurs before the templateReady event does. This means we could not access the current
		Playlist. To get around this limitation we will update the link for the initial video
		in the templateReady event handler and then all subsiquent changes will trigger the
		onVideoChange handler. Since the tabBar component will then be available, we can safely
		execute the custom updateLink function.
		 
		 
		*/
		 
		 
		var player;
		var video, content, exp, menu, ads, social;
		var tabBar;
		 
		function onTemplateLoaded(pPlayer) {
			trace("templateLoaded");
		 
			player = bcPlayer.getPlayer(pPlayer);
		 
			video 	= player.getModule(APIModules.VIDEO_PLAYER);
			content = player.getModule(APIModules.CONTENT);
			exp 	= player.getModule(APIModules.EXPERIENCE);
			menu 	= player.getModule(APIModules.MENU);
			ads 	= player.getModule(APIModules.ADVERTISING);
			social 	= player.getModule(APIModules.SOCIAL);
		 
		 
			exp.addEventListener(BCExperienceEvent.CONTENT_LOAD, onContentLoad);
			exp.addEventListener(BCExperienceEvent.TEMPLATE_READY, onTemplateReady);
			video.addEventListener(BCVideoEvent.VIDEO_CHANGE, onVideoChange);
		 
		}
		 
		function onContentLoad(e) { trace(e.type); }
		 
		function onTemplateReady(e) {
			trace(e.type);
		 
			tabBar = exp.getElementByID("playlistTabs");
			updateLink(video.getCurrentVideo().id, tabBar.getSelectedData().id);
		 
		}
		 
		 
		function onVideoChange(e) {
			trace(e.type);
		 
			if(exp.getReady()) { // If template is Ready
		 
				// Because TemplateReady has already fired we can now access the currentVideo and currentPlaylist from the tabBar module
				updateLink(video.getCurrentVideo().id, tabBar.getSelectedData().id);
		 
			}
		 
		}
		 
		function updateLink(videoId, playlistId) {
		 
			// 	Brightcove players published using the standard Javascript publishing code automatically
			// listen for bclid and bctid in order to select featured items. If your application is setup
			// in another format, such as Actionsript, you can choose to alter these key names to something
			// compatible with your application. Your application will be responsible for properly setting
			// the featured content
		 
			var playlistKey = "bclid";
			var videoKey = "bctid";
		 
		 
			var currentLink = social.getLink();
			trace("Original Link: " + currentLink);
		 
			// Get the current URL and remove any existing URL parameter
			if(currentLink.indexOf("?") != -1) {
				currentLink = currentLink.substring(0,currentLink.indexOf("?"));
			}
		 
			var newLink = currentLink + "?" + playlistKey + "=" + playlistId + "&" + videoKey + "=" + videoId;
			trace("New Link: " + newLink);
			social.setLink(newLink);
		 
		}
		 
		</script>
		<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>
		<script type="text/javascript" src="http://admin.brightcove.com/js/APIModules_all.js"></script>
		</head>
		<body>
<div class="container">
          <div class="head">
    <?php
		if(!empty($site_facebook))
			{
			echo '<a href="http://'.remove_http($site_facebook).'" class="facebook" target="_blank">&nbsp;</a>';
			}
		if(!empty($site_twitter))
			{
			echo '<a href="http://'.remove_http($site_twitter).'" class="twitter" target="_blank">&nbsp;</a>';
			}
		?>
  </div>
          <a href="http://www.supportartseducation" title=""><img src="assets/img/13-070212-fac0d4.jpg" alt="" /></a>
          <object id="myExperience" class="BrightcoveExperience">
    <param name="bgcolor" value="#FFFFFF" />
    <param name="width" value="960" />
    <param name="height" value="445" />
    <param name="playerID" value="1686393378001" />
    <param name="playerKey" value="AQ~~,AAABS5tCuEE~,H_fW3C-DpOzdEUiSLm9nLbvw3C2BJ4dg" />
    <param name="isVid" value="true" />
    <param name="isUI" value="true" />
    <param name="dynamicStreaming" value="true" />
  </object>
          
          <!-- End of Brightcove Player --> 
          
          <script type="text/javascript">brightcove.createExperiences();</script>
          
          
          
          <?php 
		
		$result = mysql_query("SELECT page_form, page_form_txt FROM page WHERE page_url='home' AND '$site_id'=site_id");
		while($row = mysql_fetch_assoc($result))
			{
			$page_form=$row['page_form'];
			$page_form_txt=$row['page_form_txt'];
			
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
					echo '<h2>Thank You</h2><p>'.$site_name.' will be in contact with you.</p>';
					}
				else
					{
					?>
          <?php if($page_form==1){
			
			
			if(!empty($page_form_txt))
				{
				$page_form_txt=strip_tags(html_entity_decode($row['page_form_txt'], ENT_QUOTES, 'utf-8'),$allowed_html);
				echo $page_form_txt;
				} else {}
					
			?>
          <form method="post" action="<?php echo 'http://'.$site_url; ?>" enctype="multipart/form-data" name="page_form">
    <fieldset>
              <legend class="<?= (isset($_POST['ls_name']) && empty($_POST['ls_name']) ? 'error' : '') ?>">*Name:</legend>
              <ul>
        <li>
                  <input name="ls_name" value="<?= @$_POST['ls_name']?>" type="text">
                </li>
      </ul>
            </fieldset>
    <fieldset>
              <legend class="<?= (isset($_POST['ls_email']) && (!filter_var($_POST['ls_email'], FILTER_VALIDATE_EMAIL)) ? 'error' : '') ?>">*Email Address:</legend>
              <ul>
        <li>
                  <input name="ls_email" value="<?= @$_POST['ls_email']?>" type="text">
                </li>
      </ul>
            </fieldset>
    <fieldset>
              <legend class="<?= (isset($_POST['ls_phone']) && empty($_POST['ls_phone']) ? 'error' : '') ?>">*Phone:</legend>
              <ul>
        <li>
                  <input name="ls_phone" value="<?= @$_POST['ls_phone']?>" type="text">
                </li>
      </ul>
            </fieldset>
    <fieldset>
              <legend>Message:</legend>
              <ul>
        <li>
                  <textarea name="ls_message" rows="5"><?= @$_POST['ls_message']?>
</textarea>
                </li>
        <li>
                  <input type="submit" value="Send" />
                </li>
      </ul>
            </fieldset>
  </form>
          <?php } else {} ?>
          <?php
					}
			
			}
		?>
        </div>
<p class="footer">Copyright &copy;
          <?php $copyYear = 2010; $curYear = date('Y'); echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : ''); ?>
          LocalSpotlights.com &middot; All Rights Reserved</p>
</body>
</html>
<?php
		}
	}





?>