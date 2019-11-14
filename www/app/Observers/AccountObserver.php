<?php

namespace App\Observers;

use App\Account;
use Ramsey\Uuid\Uuid;

class AccountObserver
{

    public function creating(Account $account)
    {
        $uid = mt_rand(100000, 999999);

        $account->setAttribute('uid', $uid);
        $account->setAttribute('uuid', Uuid::uuid4());
    }

    /**
     * Handle the account "updated" event.
     *
     * @param  \App\Account  $account
     * @return void
     */
    public function updated(Account $account)
    {
        //
    }

    /**
     * Handle the account "deleted" event.
     *
     * @param  \App\Account  $account
     * @return void
     */
    public function deleted(Account $account)
    {
        //
    }

    /**
     * Handle the account "restored" event.
     *
     * @param  \App\Account  $account
     * @return void
     */
    public function restored(Account $account)
    {
        //
    }

    /**
     * Handle the account "force deleted" event.
     *
     * @param  \App\Account  $account
     * @return void
     */
    public function forceDeleted(Account $account)
    {
        //
    }
}
