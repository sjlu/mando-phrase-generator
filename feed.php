<?php
$one_line_story_templates = array();
$one_line_story_templates[] = '{*actor*} <fb:if-multiple-actors>have<fb:else></fb:else></fb:if-multiple-actors> added a Chinese phrase to {*pronoun*} profile.';

try 
{
	$template_bundle_id = $facebook->api_client->feed_registerTemplateBundle($one_line_story_templates); 
} 
catch (Exception $e) 
{
	$registered_bundles = $facebook->api_client->feed_getRegisteredTemplateBundles();
	for ($count=0;$count<=25;$count++)
		$facebook->api_client->feed_deactivateTemplateBundleByID($bundle[$count]['template_bundle_id']);
	
	$template_bundle_id = $facebook->api_client->feed_registerTemplateBundle($one_line_story_templates);
}

$tokens = array(  
	'pronoun' => '<fb:pronoun uid="' . $user . '" possessive="true" useyou="false"/>',
);

$target_ids = array(); $body_general = ''; 

try
{
	$facebook->api_client->feed_publishUserAction( $template_bundle_id, json_encode($tokens) , implode(',', $target_ids), $body_general);
} 
catch (Exception $e) 
{
}

$facebook->api_client->feed_deactivateTemplateBundleByID($template_bundle_id);
?>