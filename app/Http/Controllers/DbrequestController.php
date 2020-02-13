<?php

namespace App\Http\Controllers;

use App\Dbrequest;
use App\Events\NewInstalledDatabaseEvent;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DbrequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dbrequest = Dbrequest::with(['user'])->get()->where('installed', '!=', 'On Progress')->where('installed', '!=', 'Installed');

        return view('db.request', ['dbs' => $dbrequest]);
    }

    public function create()
    {

        return view("db.create");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'servicename.regex' => 'Service name must only contain lower case alphabet, number, and \'-\' (dash)',
        ];

        $validator = Validator::make($request->all(), [
            'servicename' => array('regex:/^[0-9-a-z]/', 'unique:dbrequests')
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        //
        $db = new Dbrequest();

        $requestedDisk = "";
        // for ($count = 0; $count < sizeof($request->requestedDiskName); $count++) {
        //     $requestedDisk .= $request->requestedDiskName[$count] . ", " . $request->requestedDiskSize[$count] . ", ";
        // }

        for ($count = 0; $count < sizeof($request->requestedDiskSize); $count++) {
            $requestedDisk .=  $request->requestedDiskSize[$count] . ", ";
        }
        $requestedDisk = substr($requestedDisk, 0, strlen($requestedDisk) - 2);
        $db->servicename = $request->servicename;
        $db->requestedby = Auth::user()->id;
        $db->engine = $request->requestType;
        $db->requestedcpu = $request->requestCpu;
        $db->requestedmemory = $request->requestMemory;
        $db->requesteddisk = $requestedDisk;
        $db->vmstatus = false;
        $db->requestedvip = "";
        $db->installed = "";
        $db->save();

        HistoryController::store(Auth::user()->username, "created request for", $request->servicename, "");
        return redirect('/dbrequest')->with('success', 'Successfully Created Request');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function edit($servicename)
    {
        $dbrequest = Dbrequest::find($servicename);

        return view('db.editrequest', ['dbrequest' => $dbrequest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $servicename)
    {

        $messages = [
            'servicename.regex' => 'Service name must only contain lower case alphabet, number, and \'-\' (dash)',
        ];

        $validator = Validator::make($request->all(), [
            'servicename' => array('regex:/^[0-9-a-z]/')
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $db = Dbrequest::find($servicename);
        $before = $db;
        $description = "";

        if ($before->servicename != $request->servicename)  $description = $description .  " service name from " . $before->servicename . " to " . $request->serviceName . ", ";
        if ($before->engine != $request->requestType)  $description = $description . " DBMS from " . $before->engine . " to " . $request->requestType . ", ";
        if ($before->requestedcpu != $request->requestCpu)  $description = $description . " requested CPU from " . $before->requestedcpu . " to " . $request->requestCpu . ", ";
        if ($before->requestedmemory != $request->requestMemory)  $description = $description . " requested memory from " . $before->requestedmemory . " to " . $request->requestMemory . ", ";

        $requestedDisk = "";
        for ($count = 0; $count < sizeof($request->requestedDiskSize); $count++) {
            $requestedDisk .=  $request->requestedDiskSize[$count] . ", ";
        }
        $requestedDisk = substr($requestedDisk, 0, strlen($requestedDisk) - 2);
        $db->servicename = $request->servicename;
        $db->requestedby = $db->requestedby;
        $db->engine = $request->requestType;
        $db->requestedcpu = $request->requestCpu;
        $db->requestedmemory = $request->requestMemory;
        $db->requesteddisk = $requestedDisk;
        $db->vmstatus = false;
        $db->requestedvip = "";
        $db->installed = "";
        $db->save();



        // $differences = array_diff($after, $before);
        // array_pop($differences);

        // $diff = implode(", ", $differences);

        // dd($diff);






        HistoryController::store(Auth::user()->username, "edited request for", $servicename, $description);



        return redirect('/dbrequest')->with('success', 'Successfully Updated Request');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($servicename)
    {
        //
        $db = Dbrequest::find($servicename);

        $db->delete();

        HistoryController::store(Auth::user()->username, "deleted request for", $servicename, "");

        return Redirect::back()->with('success', 'Successfully Deleted');
    }

    public function updateVip(Request $request, $servicename)
    {
        $validator = Validator::make($request->all(), [
            'requestedvip' => 'ipv4'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $dbrequest = Dbrequest::find($servicename);

        if ($request->requestedvip == null) $request->requestedvip = "";

        $dbrequest->requestedvip = $request->requestedvip;

        $dbrequest->save();

        HistoryController::store(Auth::user()->username, "updated VIP for request", $servicename, "become " . $request->requestedvip);

        return redirect('/dbrequest')->with('success', 'Successfully Store VIP');
    }

    public function updateVmStatus($servicename)
    {
        $dbrequest = Dbrequest::find($servicename);

        $dbrequest->vmstatus ? $dbrequest->vmstatus = false  : $dbrequest->vmstatus = true;

        $dbrequest->save();

        HistoryController::store(Auth::user()->username, "updated VM Status for request", $servicename, "becomes " . $dbrequest->vmstatus);

        return redirect('/dbrequest')->with('success', 'Successfully Updated VM Status');
    }

    public function cancelVmStatus($servicename)
    {
        $dbrequest = Dbrequest::find($servicename);

        $dbrequest->vmstatus = false;

        $dbrequest->save();

        HistoryController::store(Auth::user()->username, "canceled ready request", $servicename, "");


        return redirect('/dbrequest')->with('success', 'Successfully Canceled VM');
    }


    public function viewInstaller()
    {
        //
        // $dbs = Dbrequest::where('requestedvip', '!=', null)->where('requestedvip', '!=', '')->where('vmstatus', true)->where('installed', '!=', 'On Progress')->where('installed', '!=', 'Installed')->get();
        // @if(($db->engine == 'Postgres' && $db->requestedvip != null && $db->vmstatus != false) || ($db->engine == 'Mongo'  && $db->vmstatus != false))

        $dbs = Dbrequest::where('vmstatus', true)
            ->where('installed', '!=', 'On Progress')
            ->where('installed', '!=', 'Installed')->where(
                function ($query) {
                    $query->where('engine', 'Postgres')
                        ->orWhere('engine', 'Mongo');
                }
            )->get();
        return view('db.install', ['dbs' => $dbs]);
    }



    public function runInstaller(Request $request)
    {
        $dbrequest = Dbrequest::whereIn('servicename', $request->installDatabase);

        $dbrequest->update(['installed' => 'On Progress']);

        $engine = "";

        if ($request->version == '10') {
            $engine = "PostgreSQL 10";
        } else if ($request->version == '11') {
            $engine = "PostgreSQL 11";
        } else if ($request->version == '3.4') {
            $engine = "MongoDB 3.4";
        } else {
            $engine = "MongoDB 3.6";
        }

        $dbrequest->update(['engine' => $engine]);

        $dbrequestservicename = $dbrequest->pluck('servicename')->toArray();
	$dbrequestvip = $dbrequest->pluck('requestedvip')->toArray();


        foreach ($dbrequestservicename as $dbservicename) {

            HistoryController::store(Auth::user()->username, "installed database for service", $dbservicename, "");
        }

        event(new NewInstalledDatabaseEvent($dbrequestservicename, $engine, $dbrequestvip));


        return redirect('/')->with('success', 'Successfully Installed DB');
    }

    public function getInstalled()
    {
        //
        $dbs = Dbrequest::whereIn('installed', array("Installed", "On Progress", "Failed"))->paginate(8);

        return view('db.dbinstance', ['dbs' => $dbs]);
    }

    public function addInstalled(Request $request)
    {

        $messages = [
            'servicename.regex' => 'Service name must only contain lower case alphabet, number, and \'-\' (dash)',
        ];

        $validator = Validator::make($request->all(), [
            'servicename' => array('regex:/^[0-9-a-z]/', 'unique:dbrequests'),
            'requestedvip' => 'ipv4'
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        //
        $db = new Dbrequest();
        $db->servicename = $request->servicename;
        $db->requestedby = Auth::user()->id;
        $db->engine = $request->version;
        $db->requestedcpu = 999;
        $db->requestedmemory = 999;
        $db->requesteddisk = "";
        $db->vmstatus = true;
        $db->requestedvip = $request->requestedvip;
        $db->installed = "Installed";
        $db->save();

        HistoryController::store(Auth::user()->username, "added installed database named", $request->servicename, "with DBMS " . $request->requestType . " and virtual IP " . $request->requestedvip);
        return redirect('/')->with('success', 'DB Successfully Added');
    }


    public function editInstalled($servicename)
    {
        $dbrequest = Dbrequest::find($servicename);

        return view('db.editinstalled', ['dbrequest' => $dbrequest]);
    }


    public function updateInstalled(Request $request, $servicename)
    {

        $messages = [
            'servicename.regex' => 'Service name must only contain lower case alphabet, number, and \'-\' (dash)',
            'requestedvip' => 'ipv4'
        ];

        $validator = Validator::make($request->all(), [
            'servicename' => array('regex:/^[0-9-a-z]/')
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $db = Dbrequest::find($servicename);

        $description = "";
        if ($db->servicename != $request->servicename) {
            $description = "Servicename from " . $db->servicename . " to " . $request->servicename;
            $db->servicename = $request->servicename;
        }
        if ($db->engine != $request->version) {
            $description = $description . ", DB engine from " . $db->engine . " to " . $request->version;
            $db->engine = $request->version;
        }
        if ($db->requestedvip != $request->requestedvip) {
            $description = $description . ", virtual IP from " . $db->requestedvip . " to " . $request->requestedvip;
            $db->requestedvip = $request->requestedvip;
        }

        $db->requestedby = Auth::user()->id;
        $db->requestedcpu = 999;
        $db->requestedmemory = 999;
        $db->requesteddisk = "";
        $db->vmstatus = true;
        $db->installed = "Installed";
        $db->save();

        HistoryController::store(Auth::user()->username, "edited installed database for", $servicename, $description);

        return redirect('/')->with('success', 'Installed DB Successfully Updated');
    }



    public function authDb(Request $request)
    {
        $conn = pg_connect("host=" . $request->hostname . "db-01.infra-wallet.lokal port=5432 dbname=postgres user=" . $request->username . " password=" . $request->password);

        $config = pg_query($conn, "select  name, setting, unit, short_desc, extra_desc, context, pending_restart from pg_settings where context != 'internal' and context !='backend' order by category;");


        return view('db.viewconfig', ['config' => $config, 'dbcredentials' => $request]);
    }

    public function modifyConfig(Request $request)
    {
        $conn = pg_connect("host=" . $request->hostname . "db-01.infra-wallet.lokal port=5432 dbname=postgres user=" . $request->username . " password=" . $request->password);

        $changed_configuration = "Changed ";


        for ($i = 0; $i < sizeof($request->changedconfigvalue); $i++) {
            $conn = pg_connect("host=" . $request->hostname . "db-01.infra-wallet.lokal port=5432 dbname=postgres user=" . $request->username . " password=" . $request->password);
            pg_query($conn, "ALTER SYSTEM SET " . $request->changedconfigname[$i] . "='" . $request->changedconfigvalue[$i] . "'");

            $changed_configuration .= $changed_configuration .  $request->changedconfigname[$i] . " become " .  $request->changedconfigvalue[$i] . ",";
        }

        $changed_configuration = substr($changed_configuration, 0, strlen($changed_configuration) - 2);

        HistoryController::store(Auth::user()->username, "changed database configuration for service", $request->hostname, $changed_configuration);

        if ($request->counterRestart != '0') {
#		dd("ssh -p 2209 ansible@" . $request->hostname  . "db-01.infra-wallet.lokal sudo systemctl restart postgresql-11");
		exec("sudo -u ansible ssh -p 2209 ansible@" . $request->hostname  . "db-01.infra-wallet.lokal sudo systemctl restart postgresql-1" . substr($request->engine, 12,12));
		return redirect('/')->with('success', 'Successfully Changed Configuration');
        } else {
            pg_query($conn, "select * from pg_reload_conf();");
            pg_query($conn, "select pg_sleep(3)");
	    return Redirect::back()->with('success', 'Successfully Changed Configuration');
        }
    }
}
