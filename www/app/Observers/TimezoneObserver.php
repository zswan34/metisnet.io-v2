<?php

namespace App\Observers;

use App\Timezone;

class TimezoneObserver
{

    public function creating(Timezone $timezone)
    {
        //
    }

    /**
     * Handle the timezone "updated" event.
     *
     * @param  \App\Timezone  $timezone
     * @return void
     */
    public function updated(Timezone $timezone)
    {
        //
    }

    /**
     * Handle the timezone "deleted" event.
     *
     * @param  \App\Timezone  $timezone
     * @return void
     */
    public function deleted(Timezone $timezone)
    {
        //
    }

    /**
     * Handle the timezone "restored" event.
     *
     * @param  \App\Timezone  $timezone
     * @return void
     */
    public function restored(Timezone $timezone)
    {
        //
    }

    /**
     * Handle the timezone "force deleted" event.
     *
     * @param  \App\Timezone  $timezone
     * @return void
     */
    public function forceDeleted(Timezone $timezone)
    {
        //
    }
}
