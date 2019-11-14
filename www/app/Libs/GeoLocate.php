<?php 

namespace App\Libs;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class GeoLocate {

    protected static $url;
    protected static $apiKey;
	protected static $client;

	public function __construct()
    {
        self::$apiKey = config('app.geo_locate_api_key');
        self::$url = 'http://ip-api.com/php/';
    }

    public static function fetch($ip) {
        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', 'http://ip-api.com/php/'.$ip);
        $response = unserialize($request->getBody());

        if ($response['status'] === 'success') {
            return $response;
        }
        return response()->json(['error' => 'Unable to fetch data']);
    }

    public static function fetchClient() {
        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', 'http://ip-api.com/php/'.request()->getClientIp());
        $response = unserialize($request->getBody());

        if ($response['status'] === 'success') {
            return $response;
        }

        if (request()->getClientIp() === '127.0.0.1') {
            return response()->json([
                'error' => 'Unable to call on localhost',
            ]);
        }
        return response()->json(['error' => 'Unable to fetch data']);
    }

}