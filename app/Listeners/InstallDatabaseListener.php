<?php

namespace App\Listeners;

use App\Dbrequest;
use App\Events\NewInstalledDatabaseEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;

class InstallDatabaseListener implements ShouldQueue
{

    public function handle(NewInstalledDatabaseEvent $event)
    {	
	if (strpos($event->engine, 'PostgreSQL') !== false) {
		
		
        	$newcontent = "[all]\n";
	        foreach ($event->dbrequestservicename as $name) {
        	    $newcontent .= $name . "db-01.infra-wallet.lokal\n";
	            $newcontent .= $name . "db-02.infra-wallet.lokal\n";
	        }
        	$newcontent .= "\n[master]\n";
	        foreach ($event->dbrequestservicename as $name) {
	            $newcontent .= $name . "db-01.infra-wallet.lokal\n";
	        }
        	$newcontent .= "\n[slave]\n";
	        foreach ($event->dbrequestservicename as $name) {
        	    $newcontent .= $name . "db-02.infra-wallet.lokal\n";
	        }


		File::put('/var/www/database-manager/storage/app/hosts', $newcontent);
		exec("sudo -u ansible  ansible-playbook -i /var/www/database-manager/storage/app/hosts /var/www/database-manager/storage/app/postgres/postgres-replication/playbook.yml --vault-password-file storage/app/.vault --extra-vars \"version=" . substr($event->engine, 11, 12)  . "\" >> postgres_replication.log");
		exec("sudo -u ansible ansible-playbook -i /var/www/database-manager/storage/app/hosts /var/www/database-manager/storage/app/postgres/pgbackrest/playbook.yml --vault-password-file storage/app/.vault  -e \"version=" . substr($event->engine, 11, 12)  . "\" >> postgres_pgbackrest.log");




		$newcontent = "[all]\n";
                foreach ($event->dbrequestservicename as $name) {
                    $newcontent .= $name . "db-01.infra-wallet.lokal\n";
                    $newcontent .= $name . "db-02.infra-wallet.lokal\n";
		    $newcontent .= $name . "pgbouncer-01.infra-wallet.lokal\n";
                    $newcontent .= $name . "pgbouncer-02.infra-wallet.lokal\n";
                }
                $newcontent .= "\n[all_pgpool]\n";

		$counter = 0;
                foreach ($event->dbrequestservicename as $name) {
                	$newcontent .= $name . "pgbouncer-01.infra-wallet.lokal virtual_ip=" .$event->virtualip[$counter] . "\n";
			$newcontent .= $name . "pgbouncer-02.infra-wallet.lokal virtual_ip=" .$event->virtualip[$counter] . "\n";
			$counter++;
		}
		$newcontent .= "\n[master_pgpool]\n";
		foreach ($event->dbrequestservicename as $name) {
                        $newcontent .= $name . "pgbouncer-01.infra-wallet.lokal\n";
                }
                $newcontent .= "\n[slave_pgpool]\n";
                foreach ($event->dbrequestservicename as $name) {
                	$newcontent .= $name . "pgbouncer-02.infra-wallet.lokal\n";
		}


		$newcontent .= "\n[all_postgresql]\n";
                foreach ($event->dbrequestservicename as $name) {
                        $newcontent .= $name . "db-01.infra-wallet.lokal\n";
                        $newcontent .= $name . "db-02.infra-wallet.lokal\n";
                }
                $newcontent .= "\n[master_postgresql]\n";
                foreach ($event->dbrequestservicename as $name) {
                        $newcontent .= $name . "db-01.infra-wallet.lokal\n";
                }
                $newcontent .= "\n[slave_postgresql]\n";
                foreach ($event->dbrequestservicename as $name) {
                        $newcontent .= $name . "db-02.infra-wallet.lokal\n";
                }

		File::put('/var/www/database-manager/storage/app/hosts', $newcontent);
	
		exec("sudo -u ansible ansible-playbook -i /var/www/database-manager/storage/app/hosts /var/www/database-manager/storage/app/postgres/pgpool/playbook.yml --vault-password-file storage/app/.vault -e \"version=" . substr($event->engine, 11, 12)  . "\" >> postgres_pgpool.log");
	}
	else{
	        $newcontent = "[all]\n";
                foreach ($event->dbrequestservicename as $name) {
                    $newcontent .= $name . "db-01.infra-wallet.lokal\n";
                    $newcontent .= $name . "db-02.infra-wallet.lokal\n";
	            $newcontent .= $name . "arb-01.infra-wallet.lokal\n";
                }
                $newcontent .= "\n[master]\n";
                foreach ($event->dbrequestservicename as $name) {
                    $newcontent .= $name . "db-01.infra-wallet.lokal\n";
                }
                $newcontent .= "\n[slave]\n";
                foreach ($event->dbrequestservicename as $name) {
                    $newcontent .= $name . "db-02.infra-wallet.lokal\n";
                }
                $newcontent .= "\n[arbiter]\n";
                foreach ($event->dbrequestservicename as $name) {
                    $newcontent .= $name . "arb-01.infra-wallet.lokal\n";
                }


                File::put('/var/www/database-manager/storage/app/mongo/hosts', $newcontent);
                exec("sudo -u ansible  ansible-playbook -i /var/www/database-manager/storage/app/mongo/hosts /var/www/database-manager/storage/app/mongo/playbook.yml --vault-password-file storage/app/.vault --extra-vars \"version=" . substr($event->engine, 8, 10)  . "\" >> mongo.log");
		
		$newcontent = "[mongo]\n";
                foreach ($event->dbrequestservicename as $name) {
                    $newcontent .= $name . "db-02.infra-wallet.lokal\n";
                }

                File::put('/var/www/database-manager/storage/app/mongodb-consistent-backup/hosts', $newcontent);
                exec("sudo -u ansible  ansible-playbook -i /var/www/database-manager/storage/app/mongodb-consistent-backup/hosts /var/www/database-manager/storage/app/mongodb-consistent-backup/install.yaml >> mongo-backup.log");
		}        

        $dbrequest = Dbrequest::whereIn('servicename', $event->dbrequestservicename);

        $dbrequest->update(['installed' => 'Installed']);
    }

    public function failed(NewInstalledDatabaseEvent $event, $exception)
    {
        $dbrequest = Dbrequest::whereIn('servicename', $event->dbrequestservicename);

        $dbrequest->update(['installed' => 'Failed']);
    }

}
