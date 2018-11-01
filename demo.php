<?php
// include apicaller
require __DIR__.'/apicaller.php';
// create new apicaller
$client = new apicaller();

// DEMO get_all_* functions (No actions)
// pls dont look at render_cli() :c
$locations = $client->get_all_locations();
foreach($locations as $value)
{
	echo "Location: \r\n";
	echo $client->render_cli($value);
	echo '------------'."\r\n";
}
$datacenters = $client->get_all_datacenters();
foreach($datacenters as $value)
{
	echo "Datacenter: \r\n";
	echo $client->render_cli($value);
	echo '------------'."\r\n";
}
$images = $client->get_all_images();
foreach($images as $value)
{
	echo "Images: \r\n";
	echo $client->render_cli($value);
	echo '------------'."\r\n";
}
$servers = $client->get_all_servers();
foreach($servers as $value)
{
	echo "Servers: \r\n";
	echo $client->render_cli($value);
	echo '------------'."\r\n";
}
$volumes = $client->get_all_volumes();
foreach($volumes as $value)
{
	echo "Volumes: \r\n";
	echo $client->render_cli($value);
	echo '------------'."\r\n";
}
$floating_ips = $client->get_all_floating_ips();
foreach($floating_ips as $value)
{
	echo "Floating Ips: \r\n";
	echo $client->render_cli($value);
	echo '------------'."\r\n";
}
$ssh_keys = $client->get_all_ssh_keys();
foreach($ssh_keys as $value)
{
	echo "SSH Keys: \r\n";
	echo $client->render_cli($value);
	echo '------------'."\r\n";
}
$server_types = $client->get_all_server_types();
foreach($server_types as $value)
{
	echo "Server Types: \r\n";
	echo $client->render_cli($value);
	echo '------------'."\r\n";
}
