<?php 

namespace App\Libs;

use GoDaddy\GoDaddyClient;
use GoDaddy\Helper\GoDaddyDNSRecordParams;

class GoDaddy {

    protected $godaddyClient;
    protected $godaddy_key;
    protected $godaddy_secret;
    protected $domains;

    public function __construct($godaddy_key, $godaddy_secret) {
        $this->godaddy_key = $godaddy_key;
        $this->godaddy_secret = $godaddy_secret;
        $this->godaddyClient = new GoDaddyClient($this->godaddy_key, $this->godaddy_secret);
        $this->domains = $this->godaddyClient->connectDomains();
    }

    public function connected() {
        $connected = true;
        try {
            $this->godaddyClient->connectDomains();
        } catch (\Exception $e) {
            $connected = false;
        }
        return $connected;
    }

    public function getDomains() {
        return json_decode($this->domains->getDomains());
    }

    public function getDomain($name) {
        return json_decode($this->domains->getDomain($name));
    }

    public function getDns($domain_name) {
        return $this->domains->getDns($domain_name);
    }

    public function getDnsByType($domain_name, $param, $include_host = false) {
        $domain = '';
        $a = GoDaddyDNSRecordParams::DNS_KEY_A;
        $cname = GoDaddyDNSRecordParams::DNS_KEY_CNAME;
        $mx = GoDaddyDNSRecordParams::DNS_KEY_MX;

        switch ($param) {
            case 'a':
                $domain = $this->domains->getDnsByType($domain_name, $a);
                if ($include_host) {
                    $dns = [];
                    $d = json_decode($domain);
                    foreach($d as $gd) {
                        if ($gd->name !== '@') {
                            $dns[] = $gd;
                        }
                    }
                    $domain = $dns;
                }
                break;

        }
        return $domain;
    }

}