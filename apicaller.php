<?php
require __DIR__.'/vendor/autoload.php';


class apicaller 
{
	private $c;
	public function __construct()
    {
		$dotenv = new Dotenv\Dotenv(__DIR__);
		$dotenv->load();
		$this->c = new GuzzleHttp\Client(['base_uri' => 'https://api.hetzner.cloud/v1/', 'headers' => ['Authorization' => 'Bearer '. getenv('APIKEY')]]);
	}
	
	/*
		curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer $API_TOKEN" \
		-d '{"name": "my-server", "server_type": "cx11", "location": "nbg1", "start_after_create": true, "image": "ubuntu-16.04", "ssh_keys": ["my-ssh-key"], "volumes": ["1"], "user_data": "#cloud-config\nruncmd:\n- [touch, /root/cloud-init-worked]\n"}' \
		https://api.hetzner.cloud/v1/servers
	*/
	public function create_server()
	{

		return 'hi';
	}

	/*
		SSH KEYS API
	*/
	/*
		https://docs.hetzner.cloud/#ssh-keys-get-all-ssh-keys
	*/
	public function get_all_ssh_keys()
	{
		$r = $this->c->request('GET', 'ssh_keys');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->ssh_keys;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#ssh-keys-create-an-ssh-key
	*/
	public function create_an_ssh_key(string $name, string $public_key)
	{
		$fd = ['name' => $name, 'public_key' => $public_key];
		$r = $this->c->request('POST', 'ssh_keys', ['form_params' => $fd ]);
		if($r->getStatusCode() == 201)
			return json_decode((string)$r->getBody())->ssh_key;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#ssh-keys-delete-an-ssh-key
	*/
	public function delete_an_ssh_key(int $id)
	{
		$r = $this->c->request('DELETE', 'ssh_keys/' .  $id);
		if($r->getStatusCode() == 204)
			return true;
		else
			return $r->getStatusCode();
	}

	/*
		SERVER TYPES API
	*/
	/*
		https://docs.hetzner.cloud/#server-types-get-all-server-types
	*/
	public function get_all_server_types()
	{
		$r = $this->c->request('GET', 'server_types');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->server_types;
		else
			return $r->getStatusCode();
	}

	/*
		DC/LC API
	*/
	/*
		https://docs.hetzner.cloud/#datacenters-get-all-datacenters
	*/
	public function get_all_datacenters()
	{
		$r = $this->c->request('GET', 'datacenters');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->datacenters;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#locations-get-all-locations
	*/
	public function get_all_locations()
	{
		$r = $this->c->request('GET', 'locations');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->locations;
		else
			return $r->getStatusCode();
	}

	/*
		IMAGES API
	*/
	/*
		https://docs.hetzner.cloud/#images-get-all-images
	*/
	public function get_all_images()
	{
		$r = $this->c->request('GET', 'images');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->images;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#images-delete-an-image
	*/
	public function delete_an_image(int $id)
	{
		$r = $this->c->request('DELETE', 'images/' .  $id);
		if($r->getStatusCode() == 204)
			return true;
		else
			return $r->getStatusCode();
	}

	/*
		VOLUME API
	*/
	/*
		https://docs.hetzner.cloud/#volumes-get-all-volumes
	*/
	public function get_all_volumes()
	{
		$r = $this->c->request('GET', 'volumes');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->volumes;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#volumes-create-a-volume
	*/
	public function create_a_volume(int $size, string $name, string $location = null, int $server = 0)
	{
		$fd = ['size' => $size, 'name' => $name];
		if($location != null)
			$fd['location'] = $location;
		if($server != 0)
			$fd['server'] = $server;
		$r = $this->c->request('POST', 'volumes', ['form_params' => $fd ]);
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->volumes;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#volumes-delete-a-volume
	*/
	public function delete_a_volume(int $id)
	{
		$r = $this->c->request('DELETE', 'volumes/' .  $id);
		if($r->getStatusCode() == 204)
			return true;
		else
			return $r->getStatusCode();
	}
}