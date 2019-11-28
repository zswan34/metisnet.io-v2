<?php 

namespace App\Libs;

use App\UserSession;
use App\UserSessionMeta;
use Jenssegers\Agent\Agent;

class Meta {

    public static function saveDataFromAuthUser() {
        if (auth()->check()) {

            $agent = new Agent();
            $userSession = new UserSession();
            $userSession->browser = $agent->browser();
            $userSession->browser_version = $agent->version($agent->browser());
            $userSession->device = $agent->device();
            $userSession->platform = $agent->platform();
            $userSession->platform_version = $agent->version($agent->platform());
            $userSession->ip_address = request()->getClientIp();
            $userSession->user_id = auth()->user()->id;
            $userSession->save();

            if (config('app.env') !== 'local') {
                $locationData = GeoLocate::fetchClient();
                $userSessionMeta = new UserSessionMeta();
                $userSessionMeta->user_session_id = '';
                $userSessionMeta->as = $locationData['as'];
                $userSessionMeta->city = $locationData['city'];
                $userSessionMeta->country = $locationData['country'];
                $userSessionMeta->countryCode = $locationData['countryCode'];
                $userSessionMeta->isp = $locationData['isp'];
                $userSessionMeta->lat = $locationData['lat'];
                $userSessionMeta->lon = $locationData['lon'];
                $userSessionMeta->org = $locationData['org'];
                $userSessionMeta->query = $locationData['query'];
                $userSessionMeta->region = $locationData['region'];
                $userSessionMeta->regionName = $locationData['regionName'];
                $userSessionMeta->timezone = $locationData['timezone'];
                $userSessionMeta->zip = $locationData['zip'];
                $userSessionMeta->save();
            }
        }
    }
}