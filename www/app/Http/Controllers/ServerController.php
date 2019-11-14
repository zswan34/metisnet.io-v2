<?php

namespace App\Http\Controllers;

use App\Libs\ServerStatus;
use App\Timezone;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    protected $servers;

    public function __construct()
    {
        $servers = new ServerStatus();
        $this->servers = $servers;
    }

    public function getServers() {
        return view('servers');
    }

    public function getServer() {
        return view('server');
    }

    public function getServerApi() {
        $timezone = Timezone::find(auth()->user()->timezone_id);
        return [
            'monitors' => $this->servers->getAllServers(),
            'timezone' => $timezone->value,
            ];
    }

    public function getServerApiShow($server_api) {
        $timezone = Timezone::find(auth()->user()->timezone_id);
        return [
            'monitors' => $this->servers->getServerByID($server_api),
            'timezone' => $timezone->value
        ];
    }
}
