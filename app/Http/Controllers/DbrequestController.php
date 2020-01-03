<?php

namespace App\Http\Controllers;

use App\Dbrequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\HistoryController;

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
        $dbrequest = Dbrequest::with(['user'])->get();

        return view('db.request', ['dbs' => $dbrequest]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dbs = Dbrequest::where('requestedvip', '!=', null)->where('requestedvip', '!=', '')->where('vmstatus', true)->get();
        return view('db.create', ['dbs' => $dbs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $db->servicename = $request->serviceName;
        $db->requestedby = Auth::user()->id;
        $db->engine = $request->requestType;
        $db->requestedcpu = $request->requestCpu;
        $db->requestedmemory = $request->requestMemory;
        $db->requestedDisk = $requestedDisk;
        $db->vmstatus = false;
        $db->requestedvip = "";
        $db->installed = "";
        $db->save();

        HistoryController::store(Auth::user()->id, "created request for", $request->serviceName, "");
        return redirect('/dbrequest')->with('success', 'DB Successfully Requested');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
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
        $db = Dbrequest::find($servicename);
        $before = $db;
        $description = "";

        if ($before->servicename != $request->serviceName)  $description = $description .  " service name from " . $before->servicename . " to " . $request->serviceName . ", ";
        if ($before->engine != $request->requestType)  $description = $description . " DBMS from " . $before->engine . " to " . $request->requestType . ", ";
        if ($before->requestedcpu != $request->requestCpu)  $description = $description . " requested CPU from " . $before->requestedcpu . " to " . $request->requestCpu . ", ";
        if ($before->requestedmemory != $request->requestMemory)  $description = $description . " requested memory from " . $before->requestedmemory . " to " . $request->requestMemory . ", ";

        $requestedDisk = "";
        for ($count = 0; $count < sizeof($request->requestedDiskSize); $count++) {
            $requestedDisk .=  $request->requestedDiskSize[$count] . ", ";
        }
        $requestedDisk = substr($requestedDisk, 0, strlen($requestedDisk) - 2);
        $db->servicename = $request->serviceName;
        $db->requestedby = $db->requestedby;
        $db->engine = $request->requestType;
        $db->requestedcpu = $request->requestCpu;
        $db->requestedmemory = $request->requestMemory;
        $db->requestedDisk = $requestedDisk;
        $db->vmstatus = false;
        $db->requestedvip = "";
        $db->installed = "";
        $db->save();



        // $differences = array_diff($after, $before);
        // array_pop($differences);

        // $diff = implode(", ", $differences);

        // dd($diff);






        HistoryController::store(Auth::user()->id, "edited request for", $servicename, $description);



        return redirect('/dbrequest')->with('success', 'DB Successfully Updated');
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

        HistoryController::store(Auth::user()->id, "deleted request for", $servicename, "");

        return redirect('/dbrequest')->with('success', 'DB Successfully Deleted');
    }

    public function updateVip(Request $request, $servicename)
    {
        $dbrequest = Dbrequest::find($servicename);

        if ($request->virtualip == null) $request->virtualip = "";

        $dbrequest->requestedvip = $request->virtualip;

        $dbrequest->save();

        HistoryController::store(Auth::user()->id, "updated VIP for request", $servicename, "become " . $request->virtualip);

        return redirect('/dbrequest')->with('success', 'Successfully Store VIP');
    }

    public function updateVmStatus($servicename)
    {
        $dbrequest = Dbrequest::find($servicename);

        $dbrequest->vmstatus ? $dbrequest->vmstatus = false  : $dbrequest->vmstatus = true;

        $dbrequest->save();

        HistoryController::store(Auth::user()->id, "updated VM Status for request", $servicename, "becomes " . $dbrequest->vmstatus);

        return redirect('/dbrequest')->with('success', 'Successfully Updated VM Status');
    }

    public function cancelVmStatus($servicename)
    {
        $dbrequest = Dbrequest::find($servicename);

        $dbrequest->vmstatus = false;

        $dbrequest->save();

        HistoryController::store(Auth::user()->id, "canceled ready request", $servicename, "");


        return redirect('/dbrequest')->with('success', 'Successfully Canceled VM');
    }
    public function install(Request $request)
    {
        $dbrequest = Dbrequest::whereIn('servicename', $request->installDatabase);

        $dbrequest->update(['installed' => 'On Progress']);

        $listdatabase = $dbrequest->get();

        $listdatabase = implode(", ", $listdatabase);

        HistoryController::store(Auth::user()->id, "installed database for service", $listdatabase, "");


        return redirect('db/create')->with('success', 'Successfully Installed DB');
    }

    public function getInstalled()
    {
        //
        $dbs = Dbrequest::where('installed', '!=', "")->paginate(8);

        return view('db.dbinstance', ['dbs' => $dbs]);
    }

    public function authDb(Request $request)
    {
        $conn = pg_connect("host=" . $request->hostname . " port=5432 dbname=postgres user=" . $request->username . " password=" . $request->password);

        $config = pg_query($conn, "select  name, setting, unit, short_desc, extra_desc, context, pending_restart from pg_settings where context != 'internal' and context !='backend' order by category;");


        return view('db.viewconfig', ['config' => $config, 'dbcredentials' => $request]);
    }

    public function modifyConfig(Request $request)
    {
        $conn = pg_connect("host=" . $request->hostname . " port=5432 dbname=postgres user=" . $request->username . " password=" . $request->password);

        $changed_configuration = "Changed ";


        for ($i = 0; $i < sizeof($request->changedconfigvalue); $i++) {
            $conn = pg_connect("host=" . $request->hostname . " port=5432 dbname=postgres user=" . $request->username . " password=" . $request->password);
            pg_query($conn, "ALTER SYSTEM SET " . $request->changedconfigname[$i] . "='" . $request->changedconfigvalue[$i] . "'");

            $changed_configuration = $changed_configuration .  $request->changedconfigname[$i] . " become " .  $request->changedconfigvalue[$i] . ",";
        }

        $changed_configuration = substr($changed_configuration, 0, strlen($changed_configuration) - 2);

        HistoryController::store(Auth::user()->id, "installed database for service", $request->hostname, $changed_configuration);

        if ($request->counterRestart != '0') {

            $a = popen('"C:\Program Files\PostgreSQL\11\bin\pg_ctl" -D "C:\Program Files\PostgreSQL\11\data" restart', 'r');

            while ($b = fgets($a, 2048)) {
                if (strpos($b, 'server started') !== false) {
                    pclose($a);
                    break;
                }
            }
        } else {
            pg_query($conn, "select * from pg_reload_conf();");
            pg_query($conn, "select pg_sleep(3)");
        }

        return redirect('/');
    }
}
