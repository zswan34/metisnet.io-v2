<?php

namespace App\Observers;

use App\Libs\GeoLocate;
use App\Setting;
use App\Timezone;
use App\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{

    public function creating(User $user)
    {
        $domain = explode('@', $user->getAttribute('email'))[1];

        if ($domain === 'metiscyber.com') {
            $user->assignRole('member');
        }

        $geo = GeoLocate::fetchClient();

        if (config('app.env') === 'local') {
            $geo = 'America/Denver';
        }

        $timezone = Timezone::findByValue($geo);

        $user->setAttribute('uid', mt_rand(100000, 999999));
        $user->setAttribute('sid', $user->createSid());
        $user->setAttribute('timezone_id', $timezone->id);
    }

    public function created(User $user)
    {
        $user->setting()->create([
            'color_theme_id' => 1,
            'navbar_color_id' => 3,
            'sidenav_color_id' => 20,
            'footer_color_id' => 3]);
        $user->account()->create();
        $path = 'accounts/' . $user->account->uuid . '/' . $user->uid;
        Storage::disk('local')
            ->makeDirectory($path);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
