<?php

namespace App\Observers;

use App\Upload;
use Ramsey\Uuid\Uuid;

class UploadObserver
{
    public function creating(Upload $upload)
    {
        $upload->setAttribute('uuid', Uuid::uuid4());
    }

    /**
     * Handle the upload "updated" event.
     *
     * @param  \App\Upload  $upload
     * @return void
     */
    public function updated(Upload $upload)
    {
        //
    }

    /**
     * Handle the upload "deleted" event.
     *
     * @param  \App\Upload  $upload
     * @return void
     */
    public function deleted(Upload $upload)
    {
        //
    }

    /**
     * Handle the upload "restored" event.
     *
     * @param  \App\Upload  $upload
     * @return void
     */
    public function restored(Upload $upload)
    {
        //
    }

    /**
     * Handle the upload "force deleted" event.
     *
     * @param  \App\Upload  $upload
     * @return void
     */
    public function forceDeleted(Upload $upload)
    {
        //
    }
}
