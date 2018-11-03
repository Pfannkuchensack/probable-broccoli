<?php

// include apicaller
require __DIR__.'/apicaller.php';
// create new apicaller
$client = new apicaller();
session_start();
if(!isset($_SESSION['locations']) || (isset($_GET['reset'])  && in_array('locations', $_GET['reset'])))
	$_SESSION['locations'] = $client->get_all_locations();
if(!isset($_SESSION['images']) || (isset($_GET['reset'])  && in_array('images', $_GET['reset'])))
	$_SESSION['images'] = $client->get_all_images();
if(!isset($_SESSION['servers']) || (isset($_GET['reset'])  && in_array('servers', $_GET['reset'])))
	$_SESSION['servers'] = $client->get_all_servers();
if(!isset($_SESSION['volumes']) || (isset($_GET['reset'])  && in_array('volumes', $_GET['reset'])))
	$_SESSION['volumes'] = $client->get_all_volumes();
if(!isset($_SESSION['floating_ips']) || (isset($_GET['reset'])  && in_array('floating_ips', $_GET['reset'])))
	$_SESSION['floating_ips'] = $client->get_all_floating_ips();
if(!isset($_SESSION['ssh_keys']) || (isset($_GET['reset'])  && in_array('ssh_keys', $_GET['reset'])))
	$_SESSION['ssh_keys'] = $client->get_all_ssh_keys();
if(!isset($_SESSION['server_types']) || (isset($_GET['reset'])  && in_array('server_types', $_GET['reset'])))
	$_SESSION['server_types'] = $client->get_all_server_types();
$resets =[];
foreach($_SESSION as $type => $v)
	$resets[$type] = count($v);
$content = '';
if(isset($_GET['show']))
{
	foreach($_SESSION[$_GET['show']] as $value)
		$content .= $client->render_html($value);
}

include ('views/header.view.php');
