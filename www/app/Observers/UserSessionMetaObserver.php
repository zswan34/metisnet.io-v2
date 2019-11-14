<?php

namespace App\Observers;

use App\UserSessionMeta;

class UserSessionMetaObserver
{

    public function creating(UserSessionMeta $userSessionMeta)
    {

    }

    /**
     * Handle the user session meta "updated" event.
     *
     * @param  \App\UserSessionMeta  $userSessionMeta
     * @return void
     */
    public function updated(UserSessionMeta $userSessionMeta)
    {
        //
    }

    /**
     * Handle the user session meta "deleted" event.
     *
     * @param  \App\UserSessionMeta  $userSessionMeta
     * @return void
     */
    public function deleted(UserSessionMeta $userSessionMeta)
    {
        //
    }

    /**
     * Handle the user session meta "restored" event.
     *
     * @param  \App\UserSessionMeta  $userSessionMeta
     * @return void
     */
    public function restored(UserSessionMeta $userSessionMeta)
    {
        //
    }

    /**
     * Handle the user session meta "force deleted" event.
     *
     * @param  \App\UserSessionMeta  $userSessionMeta
     * @return void
     */
    public function forceDeleted(UserSessionMeta $userSessionMeta)
    {
        //
    }
}
