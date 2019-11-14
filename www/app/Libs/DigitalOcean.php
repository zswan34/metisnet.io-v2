<?php 

namespace App\Libs;

use DigitalOceanV2\Adapter\BuzzAdapter;
use DigitalOceanV2\DigitalOceanV2;
use GrahamCampbell\DigitalOcean\DigitalOceanManager;

class DigitalOcean
{

    protected static $adapter;
    protected static $digitalocean;

    public function __construct()
    {
        $adapter = new BuzzAdapter(config('digitalocean.connections.main.token'));
        self::$digitalocean = new DigitalOceanV2($adapter);
    }

    public static function getRegions()
    {
        $adapter = new BuzzAdapter('34e7461df69017226c9e2555b98c4d794c2977306b2f91aaa4b00be94fbcf1ba');
        $digitalocean =  new DigitalOceanV2($adapter);
        $account = $digitalocean->account();
        return $account->getUserInformation();
    }

}