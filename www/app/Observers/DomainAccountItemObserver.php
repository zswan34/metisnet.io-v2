<?php

namespace App\Observers;

use App\DomainAccountItem;
use Ramsey\Uuid\Uuid;

class DomainAccountItemObserver
{

    public function creating(DomainAccountItem $domainAccountItem)
    {
        $domainAccountItem->setAttribute('uid', mt_rand(100000, 999999));
        $domainAccountItem->setAttribute('uuid', Uuid::uuid4());
    }

    /**
     * Handle the domain account item "updated" event.
     *
     * @param  \App\DomainAccountItem  $domainAccountItem
     * @return void
     */
    public function updated(DomainAccountItem $domainAccountItem)
    {
        //
    }

    /**
     * Handle the domain account item "deleted" event.
     *
     * @param  \App\DomainAccountItem  $domainAccountItem
     * @return void
     */
    public function deleted(DomainAccountItem $domainAccountItem)
    {
        //
    }

    /**
     * Handle the domain account item "restored" event.
     *
     * @param  \App\DomainAccountItem  $domainAccountItem
     * @return void
     */
    public function restored(DomainAccountItem $domainAccountItem)
    {
        //
    }

    /**
     * Handle the domain account item "force deleted" event.
     *
     * @param  \App\DomainAccountItem  $domainAccountItem
     * @return void
     */
    public function forceDeleted(DomainAccountItem $domainAccountItem)
    {
        //
    }
}
