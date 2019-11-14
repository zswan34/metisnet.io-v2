<?php

namespace App\Observers;

use App\UserSession;
use Jenssegers\Agent\Agent;

class UserSessionObserver
{

    public function creating(UserSession $userSession)
    {
        $agent = new Agent();

        $userSession->setAttribute('browser', $agent->browser());
        $userSession->setAttribute('browser_version', $agent->version($agent->browser()));
        $userSession->setAttribute('device', $agent->browser());
        $userSession->setAttribute('platform', $agent->platform());
        $userSession->setAttribute('platform_version', $agent->version($agent->platform()));
        $userSession->setAttribute('ip_address', request()->getClientIp());
    }

    /**
     * Handle the user session "updated" event.
     *
     * @param  \App\UserSession  $userSession
     * @return void
     */
    public function updated(UserSession $userSession)
    {
        //
    }

    /**
     * Handle the user session "deleted" event.
     *
     * @param  \App\UserSession  $userSession
     * @return void
     */
    public function deleted(UserSession $userSession)
    {
        //
    }

    /**
     * Handle the user session "restored" event.
     *
     * @param  \App\UserSession  $userSession
     * @return void
     */
    public function restored(UserSession $userSession)
    {
        //
    }

    /**
     * Handle the user session "force deleted" event.
     *
     * @param  \App\UserSession  $userSession
     * @return void
     */
    public function forceDeleted(UserSession $userSession)
    {
        //
    }
}
