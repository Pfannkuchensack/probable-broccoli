<?php

require __DIR__.'/apicaller.php';

$client = new apicaller();
//var_dump($client->get_all_datacenters());
/*$lcs = $client->get_all_locations();
foreach($lcs as $lc)
{
	echo "Name: " . $lc->name . "\r\n";
}*/

$lcs = $client->get_all_ssh_keys();
foreach($lcs as $lc)
{
	//var_dump($lc);
	echo "Name: " . $lc->name . "\r\n";
}