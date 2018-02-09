<?php include 'core/base.php';





//featured
$result = mysql_query("SELECT * FROM page WHERE page_url='featured' AND site_id='$site_id'");
if (mysql_num_rows($result) > 0)
	{
	while($row = mysql_fetch_assoc($result))
		{
		$page_id=$row['page_id'];
		$page_pass=$row['page_pass'];
		$page_headline=$row['page_headline'];
		$page_full=strip_tags(html_entity_decode($row['page_full'], ENT_QUOTES, 'utf-8'),$allowed_html);
		$pagetitle = $page_headline;
		if($page_pass='1'){
			//check_logged();
		}
		include $head;
		if($userlevel_no == '5'){echo '<a href="/panel/page.php?edit='.$page_id.'" class="edit">Edit this Page</a>';}
		echo '<h1>'.$pagetitle.'</h1><div class="clear">&nbsp;</div><hr>';
		if(!empty($page_full)){echo $page_full.'<hr>';}
		}
	}
//Featured
$query = "SELECT co.co_id FROM co, co_feat_list, card WHERE '$site_id'=co_feat_list.site_id AND co_feat_list.co_id=co.co_id AND co.co_id=card.co_id LIMIT 1";
$result = mysql_query($query) or die(mysql_error());
if(mysql_num_rows($result)==0)
	{
	echo '<p>There are no Featured Companies at this time.</p>';
	}
else
	{
	$page_link = '/featured/';
	$query = "SELECT COUNT(*) FROM card, co, co_feat_list, co_site_list WHERE '$site_id'=card.site_id AND '$site_id'=co_feat_list.site_id AND '$site_id'=co_site_list.site_id AND co.co_id=card.co_id AND co.co_id=co_feat_list.co_id AND co.co_id=co_site_list.co_id AND card_approve='1' AND card_video=''";
	$limit = '9999';
	echo '<div class="pages">'; echo pagination($query,$page_link,$limit); echo '</div>'; $limstring = paginationCount($query,$limit);	
	echo '<div class="deck">';
	$query2 = "SELECT card.card_id, card.card_front, co.co_id, co.co_name FROM card, co, co_feat_list, co_site_list WHERE '$site_id'=card.site_id AND '$site_id'=co_feat_list.site_id AND '$site_id'=co_site_list.site_id AND co.co_id=card.co_id AND co.co_id=co_feat_list.co_id AND co.co_id=co_site_list.co_id AND card_approve='1' AND card_video='' ORDER BY card.card_id DESC $limstring";
	$result = mysql_query($query2) or die(mysql_error());
	while($row = mysql_fetch_array($result))
		{
		$card_front=$row['card_front'];
		$co_id = $row["co_id"];
		$co_name = $row["co_name"];
		echo '<p class="spot"><a href="/company/'.$co_id.'"><img src="/assets/img/spotlights/tn-'.$card_front.'" alt="'.$co_name.'">';
		$subresult = mysql_query("SELECT card.card_id FROM card, co, co_feat_list, co_site_list WHERE '$site_id'=card.site_id AND '$site_id'=co_feat_list.site_id AND '$site_id'=co_site_list.site_id AND '$co_id'=card.co_id AND '$co_id'=co_feat_list.co_id AND '$co_id'=co_site_list.co_id AND card_approve='1' AND card_video!='' LIMIT 1") or die(mysql_error());
		if(mysql_num_rows($subresult)==0){echo '<br><span class="space">&nbsp;</span>';}
		else{echo '<br><span class="play">Video</span><span class="ultra">ultra</span>';}
		echo '</a></p>';
		}
	echo '<div class="clear">&nbsp</div></div>'; echo '<div class="pages">'; echo pagination($query,$page_link,$limit); echo '</div>'; $limstring = paginationCount($query,$limit);
	}





echo $social_network; include $foot; ?>