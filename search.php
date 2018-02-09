<?php $pagetitle = "Search"; include 'core/base.php'; include $head;





$result = mysql_query("SELECT page_pass FROM page WHERE page_url='search' AND '$site_id'=site_id");
while($row = mysql_fetch_assoc($result))
	{
	$page_pass=$row['page_pass'];
	if($page_pass == '1'){/*check_logged();*/}
	}

echo '<h1>Search</h1><hr>';
if(isset($_POST['submit']))
	{
	if(isset($_GET['go']))
		{
		if(preg_match("/^[  a-zA-Z]+/", $_POST['name']))
			{
			$name=$_POST['name'];
			$result = mysql_query("SELECT DISTINCT co.co_id, co.co_name, co.co_desc, card.co_id, card.city_code FROM co, co_site_list, card WHERE co.co_id=co_site_list.co_id AND co.co_id=card.co_id AND card.city_code='2' AND co_site_list.site_id='$site_id' AND (co_name LIKE '%" . $name .  "%' OR co_address_1 LIKE '%" . $name .  "%' OR co_address_2 LIKE '%" . $name .  "%' OR co_city LIKE '%" . $name .  "%' OR co_state LIKE '%" . $name .  "%' OR co_zip LIKE '%" . $name .  "%' OR co_phone LIKE '%" . $name .  "%' OR co_fax LIKE '%" . $name .  "%' OR co_email LIKE '%" . $name .  "%' OR co_url1 LIKE '%" . $name .  "%' OR co_desc LIKE '%" . $name ."%') ORDER BY co.co_name ASC") or die(mysql_error());
			if(mysql_num_rows($result)==0)
				{
				echo  '<p>Sorry, there were no matches.</p>';
				}
			else
				{
				echo '';
				while($row = mysql_fetch_array($result))
					{
					$co_name =$row['co_name'];
					$co_id=$row['co_id'];
					$card_sql = "SELECT * FROM `card` WHERE co_id = '$co_id' AND card_approve = '1' AND card_front <> ''";
					$card_result = mysql_query($card_sql);
					while($rows = mysql_fetch_array($card_result)){
						$card_front = $rows['card_front'];
						echo '<div class="deck"><p class="spot"><a href="/company/'.$co_id.'"><img src="/assets/img/spotlights/tn-'.$card_front.'" alt="'.$co_name.'"></div>';
						//echo "<div style='width:303px;height:300px;float:left;'><div align='center' style='width:100%;height:100%;vertical-align:middle;'> <a  href=\"/company/$co_id\" style='display: inline-block; vertical-align: middle;'><img src='assets/img/spotlights/tn-".$card_front."' style='vertical-align:middle;'></a></div></div>";
					}
					
					}
				echo '<br clear="all">';
				}
			}
		else
			{
			echo  '<p>Please enter a search query</p>';
			}
		}
	else
		{
		echo  '<p>Please enter a search query</p>';
		}
	}
else
	{
	echo  '<p>Please enter a search query</p>';
	}






include $foot; ?>