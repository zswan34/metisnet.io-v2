<?php

namespace App\Providers;

use App\Account;
use App\DomainAccountItem;
use App\Observers\AccountObserver;
use App\Observers\DomainAccountItemObserver;
use App\Observers\SettingObserver;
use App\Observers\TimezoneObserver;
use App\Observers\UploadObserver;
use App\Observers\UserObserver;
use App\Observers\UserSessionMetaObserver;
use App\Observers\UserSessionObserver;
use App\Setting;
use App\Timezone;
use App\Upload;
use App\User;
use App\UserSession;
use App\UserSessionMeta;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Setting::observe(SettingObserver::class);
        User::observe(UserObserver::class);
        Account::observe(AccountObserver::class);
        UserSession::observe(UserSessionObserver::class);
        Timezone::observe(TimezoneObserver::class);
        UserSessionMeta::observe(UserSessionMetaObserver::class);
        Upload::observe(UploadObserver::class);
        DomainAccountItem::observe(DomainAccountItemObserver::class);
    }
}
