<?php
include 'conf/config.php';

$rs = $facebook->api_client->fql_query("SELECT uid FROM user WHERE has_added_app=1 and uid IN (SELECT uid2 FROM friend WHERE uid1 = $user)");
$arFriends = "";

if ($rs)
{
	for ( $i = 0; $i < count($rs); $i++ )
	{
		if ( $arFriends != "" )
			$arFriends .= ",";
	
		$arFriends .= $rs[$i]["uid"];
	}
}

$sNextUrl = urlencode("&refuid=".$user);

$invfbml = <<<FBML
You've been invited to add the Mando Mandarin Phrase Generator application! <fb:name uid="$user" firstnameonly="true" shownetwork="false"/> wants you to add Mando Mandarin Phrase Generator so you can start learning Chinese by learning one phrase at a time!
<fb:req-choice url="http://www.facebook.com/add.php?api_key=$appapikey&next=$sNextUrl" label="Add" />
FBML;

?>

<fb:request-form type="Mando Mandarin Phrase Generator" action="index.php" content="<?=htmlentities($invfbml)?>" invite="true">
<fb:multi-friend-selector max="20" actiontext="Here are your friends who don't have Mando Mandarin Phrase Generator." showborder="true" rows="5" exclude_ids="<?=$arFriends?>" />
</fb:request-form>