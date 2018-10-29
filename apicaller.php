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
		ACTIONS API
	*/
	/*
		https://docs.hetzner.cloud/#actions-list-all-actions
	*/
	public function list_all_actions()
	{
		$r = $this->c->request('GET', 'actions');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->actions;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#actions-get-one-action
	*/
	public function get_one_action(int $id)
	{
		$r = $this->c->request('GET', 'actions/' . $id);
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->action;
		else
			return $r->getStatusCode();
	}

	/*
		SERVER ACTIONS API
	*/
	/*
		https://docs.hetzner.cloud/#server-actions-get-all-actions-for-a-server
	*/
	public function get_all_actions_for_a_server(int $id)
	{
		$r = $this->c->request('GET', 'servers/' . $id . '/actions');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->actions;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#server-actions-power-on-a-server
	*/
	public function power_on_a_server(int $id)
	{
		$r = $this->c->request('GET', 'servers/' . $id . '/actions/poweron');
		if($r->getStatusCode() == 201)
			return json_decode((string)$r->getBody())->action;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#server-actions-soft-reboot-a-server
	*/
	public function soft_reboot_a_server(int $id)
	{
		$r = $this->c->request('GET', 'servers/' . $id . '/actions/reboot');
		if($r->getStatusCode() == 201)
			return json_decode((string)$r->getBody())->action;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#server-actions-reset-a-server
	*/
	public function reset_a_server(int $id)
	{
		$r = $this->c->request('GET', 'servers/' . $id . '/actions/reset');
		if($r->getStatusCode() == 201)
			return json_decode((string)$r->getBody())->action;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#server-actions-shutdown-a-server
	*/
	public function shutdown_a_server(int $id)
	{
		$r = $this->c->request('GET', 'servers/' . $id . '/actions/shutdown');
		if($r->getStatusCode() == 201)
			return json_decode((string)$r->getBody())->action;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#server-actions-power-off-a-server
	*/
	public function power_off_a_server(int $id)
	{
		$r = $this->c->request('GET', 'servers/' . $id . '/actions/poweroff');
		if($r->getStatusCode() == 201)
			return json_decode((string)$r->getBody())->action;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#server-actions-reset-root-password-of-a-server
	*/
	public function reset_root_password_of_a_server(int $id)
	{
		$r = $this->c->request('GET', 'servers/' . $id . '/actions/reset_password');
		if($r->getStatusCode() == 201)
		{
			$tmp = json_decode((string)$r->getBody());
			return ['action' => $tmp->action, 'root_password' => $tmp->root_password];
		}
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#server-actions-create-image-from-a-server
	*/
	public function create_image_from_a_server(int $id, string $description, string $type)
	{
		$fd = [];
		if($type != '')
			$fd['type'] = $type;
		if($description != '')
			$fd['description'] = $description;
		$r = $this->c->request('POST', 'servers/' . $id . '/actions/create_image', ['form_params' => $fd ]);
		if($r->getStatusCode() == 201)
			return json_decode((string)$r->getBody())->image;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#server-actions-rebuild-a-server-from-an-image
	*/
	public function rebuild_a_server_from_an_image(int $id, $image)
	{
		$fd = ['image' => $image];
		$r = $this->c->request('POST', 'servers/' . $id . '/actions/rebuild', ['form_params' => $fd ]);
		if($r->getStatusCode() == 201)
		{
			$tmp = json_decode((string)$r->getBody());
			return ['action' => $tmp->action, 'root_password' => $tmp->root_password];
		}
		else
			return $r->getStatusCode();
	}

	/*
		SERVER API
	*/
	/*
		https://docs.hetzner.cloud/#servers-get-all-servers
	*/
	public function get_all_servers()
	{
		$r = $this->c->request('GET', 'servers');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->servers;
		else
			return $r->getStatusCode();
	}

	/*
		https://docs.hetzner.cloud/#servers-create-a-server
	*/
	public function create_a_server(string $name, string $server_type, $image, bool $start_after_create, $ssh_keys =[], $volumes = [], string $user_data = '', $location = '', $datacenter = '')
	{
		$fd = ['name' => $name, 'server_type' => $server_type, 'image' => $image];
		if($start_after_create == false)
			$fd['start_after_create'] = false;
		if(!empty($ssh_keys))
			$fd['ssh_keys'] = $ssh_keys;
		if(!empty($volumes))
			$fd['volumes'] = $volumes;
		if($user_data != '')
			$fd['user_data'] = $user_data;
		if($location != '')
			$fd['location'] = $location;
		if($datacenter != '')
			$fd['datacenter'] = $datacenter;
		$r = $this->c->request('POST', 'servers', ['form_params' => $fd ]);
		if($r->getStatusCode() == 201)
			return json_decode((string)$r->getBody())->ssh_key;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#servers-delete-a-server
	*/
	public function delete_a_server(int $id)
	{
		$r = $this->c->request('DELETE', 'servers/' .  $id);
		if($r->getStatusCode() == 200)
			return true;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#servers-get-metrics-for-a-server
	*/
	public function get_metrics_for_a_server(int $id, string $start, string $end, array $type = ['cpu','disk','network'], int $step = 60)
	{
		$r = $this->c->request('GET', 'servers/' . $id . '/metrics?type=' . implode(',',$type) . "&start=" . $start . '&end=' . $end . "&step=" . $step);
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->metrics;
		else
			return $r->getStatusCode();
	}

	/*
		FLOATING IPS API
	*/
	/*
		https://docs.hetzner.cloud/#floating-ips-get-all-floating-ips
	*/
	public function get_all_floating_ips()
	{
		$r = $this->c->request('GET', 'floating_ips');
		if($r->getStatusCode() == 200)
			return json_decode((string)$r->getBody())->floating_ips;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#floating-ips-create-a-floating-ip
	*/
	public function create_a_floating_ip($type = 'ipv4')
	{
		$fd = ['type' => $name];
		$r = $this->c->request('POST', 'floating_ips', ['form_params' => $fd ]);
		if($r->getStatusCode() == 201)
			return json_decode((string)$r->getBody())->ssh_key;
		else
			return $r->getStatusCode();
	}
	/*
		https://docs.hetzner.cloud/#floating-ips-delete-a-floating-ip
	*/
	public function delete_a_floating_ip(int $id)
	{
		$r = $this->c->request('DELETE', 'floating_ips/' .  $id);
		if($r->getStatusCode() == 204)
			return true;
		else
			return $r->getStatusCode();
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