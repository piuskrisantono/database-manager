@extends('layouts.master')

@section('content')

<style>
    .content-box {
        padding: 15px;
    }

    #form-content {
        grid-row-gap: 15px;
    }

    #form-content>div,
    #dbms-form {
        border: 1px solid lightgrey;
        padding-left: 15px;
        padding-right: 15px;
        border-radius: 5px;

    }

    .table td {
        padding: 0.3rem;
    }

    #disk-form>div {
        border: 1px lightgrey solid;
        border-radius: 5px;
    }
</style>



<div class="py-4" style="margin: auto">

    <div class="d-flex justify-content-between mx-3 px-3 shadow-sm py-0 content-box" style="background-color: white; height: 50px; margin-bottom: 10px;">
        <div class="title-tab my-auto" style="font-size: 20px; overflow:hidden">
            Edit Request
        </div>
        <div style="display:grid; align-items:center;">
            <a href="/dbrequest" class="btn btn-primary" style="width: 150px;">Cancel</a>
        </div>

    </div>

    <div class="content-box p-auto shadow-sm mx-3">
        <form action="/dbrequest/{{$dbrequest->servicename}}" method="POST">

            @csrf

            <input type="hidden" name="_method" value="PUT" />




            <input id="request-type" type="text" name="requestType" value="" hidden>



            <div id="form-content" style="display: grid; grid-template-columns: 1fr 1fr;grid-column-gap: 15px;">

                <div id="dbms-form" style="grid-column: 1/3; display: grid; grid-column-gap: 10px; grid-template-columns: 1fr 1fr 1fr; align-items:center; padding: 15px;">
                    <span>Database Management System</span>
                    <label class="btn btn-outline-primary my-auto"><input id="request-postgres" type="radio" name="request-dbms" name=""> PostgreSQL</label>
                    <label class="btn btn-outline-success my-auto"><input id="request-mongo" type="radio" name="request-dbms"> MongoDB</label>
                </div>

                <div>
                    <label for="service-name" class="col-form-label">Service Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="service-name" name="servicename" value="{{$dbrequest->servicename}}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="request-extension">db-XX.wallet.lokal</span>
                        </div>
                    </div>
                </div>

                <div>

                    <div class="my-2">Database VM Spec</div>


                    <div class="d-flex justify-content-between">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">CPU</label>
                            <div class="col-sm-5">
                                <select class="form-control"  id="exampleSelect1" name="requestCpu">
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="8">8</option>
                                    <option value="16">16</option>
                                    <option value="32">32</option>
                                    <option value="64">64</option>
                                </select>
                            </div>
                            <label for="inputPassword" class="col-sm-4 col-form-label">Cores</label>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Memory</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="exampleSelect1" name="requestMemory">
                                    <option value="4">4</option>
                                    <option value="8">8</option>
                                    <option value="16">16</option>
                                    <option value="32">32</option>
                                    <option value="64">64</option>
                                    <option value="128">128</option>
                                </select>

                            </div>
                            <label for="inputPassword" class="col-sm-3 col-form-label">GB</label>
                        </div>
                    </div>




                </div>

                <div>
                    <div class="my-3">To be Requested</div>
                    <ul id="request-list" class="list-group ">
                        <li class="list-group-item"><span id="db-primary-name"></span><span>db-01.wallet.lokal</span></li>
                        <li id="db-secondary" class="list-group-item"><span id="db-secondary-name"></span><span>db-02.wallet.lokal</span></li>
                        <li id="pgbouncer-primary" class="list-group-item"><span id="pgbouncer-primary-name"></span>pgbouncer-01.wallet.lokal</li>
                        <li id="pgbouncer-secondary" class="list-group-item"><span id="pgbouncer-secondary-name"></span>pgbouncer-02.wallet.lokal</li>
                        <li id="db-arbiter" class="list-group-item"><span id="db-arbiter-name"></span>arb-01.wallet.lokal</li>
                    </ul>
                </div>



                <div>
                    <div>
                        <div>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">Disk Partition</th>
                                        <th scope="col">Disk Size (GB)</th>


                                    </tr>
                                </thead>
                                <tbody id="listDisk">
                                    @php($disks = explode(', ',$dbrequest->requesteddisk))
                                    <tr id="firstDisk">
                                        <td><input id="firstDiskName" readonly type="text" class="form-control" name="requestedDiskName[]" value="/"></td>
                                        <td><input id="firstDiskSize" class="form-control" name="requestedDiskSize[]" value="{{$disks[0]}}"  type="number" step="5"></td>

                                    </tr>
                                    <tr id="secondDisk" style="display: none;">
                                        <td><input id="secondDiskName" readonly type="text" class="form-control" name="requestedDiskName[]"></td>
                                        <td><input id="secondDiskSize" class="form-control" name="requestedDiskSize[]" value="{{$disks[1]}}"  type="number" step="5" ></td>

                                    </tr>
                                    <tr id="thirdDisk" style="display: none;">
                                        <td><input id="thirdDiskName" readonly type="text" class="form-control" name="requestedDiskName[]"></td>
                                        <td><input id="thirdDiskSize"  class="form-control" name="requestedDiskSize[]" value="{{$disks[2]}}"  type="number" step="5" ></td>

                                    </tr>
                                    <tr id="fourthDisk" style="display: none;">
                                        <td><input id="fourthDiskName" readonly type="text" class="form-control" name="requestedDiskName[]"></td>
                                        <td><input id="fourthDiskSize" class="form-control" name="requestedDiskSize[]"  type="number" step="5" 
                                        @if($dbrequest->engine == "Postgres")
                                            value="{{$disks[3]}}"
                                        @endif
                                        ></td>

                                    </tr>
                                </tbody>
                            </table>
                            {{-- <div class="btn btn-success" id="addDisk" style="cursor: pointer;"><i class="fa fa-plus"></i> Add Disk</div> --}}
                        </div>



                    </div>

                </div>

            </div>






            <div class="d-flex flex-row-reverse mt-3">
                <button type="submit" class="btn btn-primary" style="width:150px;"><i class="fa fa-edit"></i> Save Request</button>
            </div>



        </form>
    </div>



</div>
@endsection

<script>
    window.onload = function() {


        $('#pgbouncer-primary').hide();
        $('#pgbouncer-secondary').hide();
        $('#db-arbiter').hide();


        $('#request-postgres').click(function(){
            $('#pgbouncer-primary').show();
            $('#pgbouncer-secondary').show();
            $('#db-arbiter').hide();
            $('#request-type').val('Postgres');
            $('#secondDisk').css('display', 'table-row');
            $('#secondDiskName').val('/db');
            // $('#secondDiskSize').val('50');
            $('#thirdDisk').css('display', 'table-row');
            $('#thirdDiskName').val('/archive_log');
            // $('#thirdDiskSize').val('50');
            $('#fourthDisk').css('display', 'table-row');
            $('#fourthDiskName').val('/pg_log');
            // $('#fourthDiskSize').val('10');
        })
        $('#request-mongo').click(function(){
            $('#pgbouncer-primary').hide();
            $('#pgbouncer-secondary').hide();
            $('#db-arbiter').show();
            $('#request-type').val('Mongo');
            $('#secondDisk').css('display', 'table-row');
            $('#secondDiskName').val('/data');
            // $('#secondDiskSize').val('50');
            $('#thirdDisk').css('display', 'table-row');
            $('#thirdDiskName').val('/logs');
            // $('#thirdDiskSize').val('10');
            $('#fourthDisk').css('display', 'none');

        })

        $('#service-name').on('input', function() {
            $('#db-primary-name').text($('#service-name').val());
            $('#db-secondary-name').text($('#service-name').val());
            $('#pgbouncer-primary-name').text($('#service-name').val());
            $('#pgbouncer-secondary-name').text($('#service-name').val());
            $('#db-arbiter-name').text($('#service-name').val());
        })

        "{{$dbrequest->engine}}" === "Postgres" ? $('#request-postgres').trigger("click") : $('#request-mongo').trigger("click");
        $('select[name="requestCpu"]').find('option[value="{{$dbrequest->requestedcpu}}"]').attr("selected",true);
        $('select[name="requestMemory"]').find('option[value="{{$dbrequest->requestedmemory}}"]').attr("selected",true);
    }
</script>
