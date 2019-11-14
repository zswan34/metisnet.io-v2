<?php

namespace App\Libs;

use App\Timezone;
use Carbon\Carbon;
use GuzzleHttp\Client;

class ServerStatus
{
    protected $client;
    protected $request;
    protected $response;
    protected $err;
    protected $api_key;
    protected $api_url;
    protected $api_query;
    protected $status_code;
    protected $timezone;

    public function __construct()
    {
        $this->client = new Client();
        $this->api_key = config('server.api_key');
        $this->api_query = 'getMonitors/';
        $this->api_url = 'https://api.uptimerobot.com/v2/';
        $this->request = [
            'api_key' => $this->api_key,
            'format' => 'json',
            'logs' => 1,
            'log_types' => '1-2-98',
            'logs_limit' => '1',
            'all_time_uptime_ratio' => 1,
            'all_time_uptime_durations' => 1
        ];
        $this->timezone = [
            'timezone' => ''
        ];
        if (auth()->check()) {
            $time = Timezone::find(auth()->user()->timezone_id);
            $this->timezone = [
                'timezone' => $time->value
                ];
        }


        $this->response = $this->client->request('POST', $this->api_url.$this->api_query, [
            'json' => $this->request
        ]);
        $this->status_code = $this->response->getStatusCode();
        if ($this->status_code === 200)
        {
            $this->response = $this->response->getBody()->getContents();
        }
        $this->response = json_decode($this->response);
    }

    public function getAllServers() {
        return $this->response->monitors;
    }

    public function getServerByID($id) {
        $server = [];
        foreach ($this->response->monitors as $monitor) {
            if ((int)$id === $monitor->id)
            {
                array_push($server, $monitor);
            }
        }
        if (empty($server))
        {
            return abort(500);
        }
        return $server;
    }

    public function getServerByName($name) {
        $server = [];
        $name = strtolower($name);
        foreach ($this->response->monitors as $monitor) {
            if ($name === strtolower($monitor->friendly_name))
            {
                array_push($server, $monitor);
            }
        }
        if (empty($server))
        {
            return abort(500);
        }
        return $server;
    }
}