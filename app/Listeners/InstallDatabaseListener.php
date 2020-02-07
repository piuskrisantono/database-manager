<?php

namespace App\Listeners;

use App\Dbrequest;
use App\Events\NewInstalledDatabaseEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InstallDatabaseListener implements ShouldQueue
{

    public function handle(NewInstalledDatabaseEvent $event)
    {

        sleep(60);


        $dbrequest = Dbrequest::whereIn('servicename', $event->dbrequestservicename);

        $dbrequest->update(['installed' => 'Installed']);
    }
}
