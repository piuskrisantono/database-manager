
@extends('layouts.master')

@section('content')
<style>



    #content-container{
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-column-gap: 1vw;
        grid-row-gap: 1vw;
    }

    .db-choice {
    width: 48%;
    }

    .db-choice img {
    width: 150px;
    height: 150px;
    }

    .btn-version{
    width: 49%;
    }



    label:hover {
        cursor: pointer;
    }

    .content-hostname{
        display: grid;
        grid-template-columns: 1fr;
    }

    input[type=radio]{
        border-radius: 0;
    }


    .list-hostname {
        display: grid;
        justify-content: space-between;
        grid-template-columns: auto auto;
        align-items: center;
        padding: 5px;
        border: 1px lightgrey solid;
    }
    .list-hostname-header {
        border: none;
        padding: 10px 0;
    }

    .list-hostname-header h5 {
        font-weight: 600;
    }

    .step-tab {
        height: 50px;
        display: inline-block;
        text-align: center;
        vertical-align: middle;
        line-height: 50px;
        padding-left: 10px;
        padding-right: 10px;
    }

    .step-now {
        border-bottom: 5px solid #007bff;
    }

    td {
        padding: 0;
    }

    td > input {
        margin: 0;
    }




    .request-card {
        display: grid;
        grid-template-rows: 50px auto 50px;
        grid-row-gap: 5px 15px;
    }

    .request-card-header {
        display: grid;
        grid-template-columns: auto auto;
        justify-content: space-between;
        align-items: center;
        /* border-bottom: 2px lightgrey solid; */
        padding-left: 15px;
        padding-right: 15px;
    }

    /* .request-card-body {
        border-bottom: 2px lightgrey solid;
    } */


    thead {
        /* background-color: #2c3e50; */
        /* color: white; */
    }

    th{
      /* text-align: center; */
      vertical-align: middle;
    }


    #request-list > .content {
        padding: 0;
    }

    /* .request-card > .request-card-body {
        padding: 15px;
    } */

    .request-card > div {
        padding-left: 15px;
        padding-right: 15px;
    }

    .request-card-footer {
        padding-left: 15px;
        padding-right: 15px;
    }

    .table {
        margin-bottom: 0;
    }





</style>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Request a Virtual Machine</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  action="/dbrequest" method="POST">
            @csrf

                <div class="my-2">Database Management System</div>
              <div style="display: grid; grid-column-gap: 10px; grid-template-columns: 1fr 1fr;">
                    <label class="btn btn-outline-primary"><input id="request-postgres" type="radio" name="request-dbms" name=""> PostgreSQL</label>
                    <label class="btn btn-outline-success"><input  id="request-mongo" type="radio" name="request-dbms"> MongoDB</label>
                    <input id="request-type" type="text" name="requestType" value="" hidden>
              </div>
              <label for="service-name" class="col-form-label">Service Name</label>
            <div class="input-group">
              <input type="text" class="form-control" id="service-name" name="serviceName">
              <div class="input-group-append">
                    <span class="input-group-text" id="request-extension">db-XX.wallet.lokal</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 3fr 2fr; margin-top:15px; grid-column-gap: 15px;">

                    <div style="grid-row: 1/3">
                        <div class="my-2">To be Requested</div>
                        <ul id="request-list" class="list-group ">
                                <li class="list-group-item"><span id="db-primary-name"></span><span>db-01.wallet.lokal</span></li>
                                <li id="db-secondary" class="list-group-item"><span id="db-secondary-name"></span><span>db-02.wallet.lokal</span></li>
                                <li id="pgbouncer-primary" class="list-group-item"><span id="pgbouncer-primary-name"></span>pgbouncer-01.wallet.lokal</li>
                                <li id="pgbouncer-secondary" class="list-group-item"><span id="pgbouncer-secondary-name"></span>pgbouncer-02.wallet.lokal</li>
                                <li id="db-arbiter" class="list-group-item"><span id="db-arbiter-name"></span>arb-01.wallet.lokal</li>
                        </ul>
                    </div>

                    <div>

                            <div class="my-2">Database VM Spec</div>


                                <div>
                                        <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">CPU</label>
                                                <div class="col-sm-4">
                                                        <select  class="form-control" id="exampleSelect1" name="requestCpu">
                                                                <option>2</option>
                                                                <option>4</option>
                                                                <option>8</option>
                                                                <option>16</option>
                                                                <option>32</option>
                                                                <option>64</option>
                                                              </select>
                                                </div>
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Cores</label>
                                        </div>
                                </div>
                                <div>
                                        <div class="form-group row">
                                                <label for="inputPassword" class="col-sm-4 col-form-label">Memory</label>
                                                <div class="col-sm-4">
                                                <select class="form-control"  id="exampleSelect1" name="requestMemory">
                                                        <option>4</option>
                                                        <option>8</option>
                                                        <option>16</option>
                                                        <option>32</option>
                                                        <option>64</option>
                                                        <option>128</option>
                                                </select>

                                            </div>
                                            <label for="inputPassword" class="col-sm-4 col-form-label">GB</label>
                                    </div>
                                </div>

                    </div>
            </div>

            <div class="my-2">Disk Partition</div>
            <div style="display: grid; grid-template-columns: 3fr 2fr;grid-column-gap: 15px;">
                <div>
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">Partition Name</th>
                            <th scope="col">Partition Size (GB)</th>
                            {{-- <th scope="col">Action</th> --}}

                          </tr>
                        </thead>
                        <tbody id="listDisk">
                          <tr id="firstDisk">
                            <td><input id="firstDiskName" readonly type="text" class="form-control"  name="requestedDiskName[]"></td>
                            <td><input id="firstDiskSize" type="text" class="form-control" name="requestedDiskSize[]"></td>

                          </tr>
                          <tr id="secondDisk" style="display: none;">
                            <td><input id="secondDiskName" readonly type="text" class="form-control"  name="requestedDiskName[]"></td>
                            <td><input id="secondDiskSize" type="text" class="form-control" name="requestedDiskSize[]"></td>

                          </tr>
                          <tr id="thirdDisk" style="display: none;">
                            <td><input id="thirdDiskName" readonly type="text" class="form-control"  name="requestedDiskName[]"></td>
                            <td><input id="thirdDiskSize" type="text" class="form-control" name="requestedDiskSize[]"></td>

                          </tr>
                          <tr id="fourthDisk" style="display: none;">
                            <td><input id="fourthDiskName" readonly type="text" class="form-control"  name="requestedDiskName[]"></td>
                            <td><input id="fourthDiskSize" type="text" class="form-control" name="requestedDiskSize[]"></td>

                          </tr>
                        </tbody>
                      </table>
                      {{-- <div class="btn btn-success" id="addDisk" style="cursor: pointer;"><i class="fa fa-plus"></i> Add Disk</div> --}}
                    </div>



            </div>




        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Send Request</button>
        </div>
    </form>
      </div>
    </div>
  </div>


    <div class="d-flex justify-content-between mx-3 mt-4 shadow-sm py-0 content" style="height: 50px; margin-bottom: 15px;">
        <div class="my-auto" style="font-size: 20px;">
             Request
        </div>

            <div class="my-auto">
                <button id="button-modal-show" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="width: 150px;">
                    Request a VM
                </button>

            </div>

      </div>

      <div class="mx-3 py-3" style="margin-bottom: 15px;">
        <div style="display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; grid-column-gap: 10px; margin-bottom: 10px;">
            <div style="height: 2px; width: 100%; background-color: lightgrey">
            </div>
             <span style="font-size: 16px;">Ready</span>
             <div style="height: 2px; width: 100%; background-color: lightgrey">
             </div>
         </div>

       <div style="width: 100%; display: grid; grid-template-columns: repeat(4, 1fr);grid-row-gap: 15px;grid-column-gap: 15px;">
            @foreach($dbs as $db)
            @if($db->requestedvip != null && $db->requestedvip != "" && $db->vmstatus != false)

                <div class="content px-3 py-1" style="display: flex; align-items: center; width: 250px; border-radius: 5px;">
                    <div class="mr-3">
                        <div style="width: 50px; height: 50px;border-radius: 50%;background-color: lightgrey;">
                            <div  style="width:50px; height: 50px;  border-radius: 50%;background-repeat: no-repeat; background-image: url({{ asset('img/postgres.png') }}); background-position: center; background-size: 50%;">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <span style="font-size: 16px;font-weight: bold">{{$db->servicename}}</span>
                            <form action="/dbrequest/cancelrequestready/{{$db->servicename}}" method="POST">
                                <input type="hidden" name="_method" value="PUT" />
                                <button class="cancel-button btn btn-info py-1 px-2" style="color: white;" type="submit">Cancel</button>
                            </form>
                    </div>
                </div>

            @endif
            @endforeach
       </div>

      </div>



            <div class="px-3 pb-3" id="request-list" style="display: grid; grid-template-columns: 1fr; grid-row-gap: 15px;">


                        <div style="display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; grid-column-gap: 10px;">
                               <div style="height: 2px; width: 100%; background-color: lightgrey">
                               </div>
                                <span style="font-size: 16px;">Active</span>
                                <div style="height: 2px; width: 100%; background-color: lightgrey">
                                </div>
                            </div>
                @foreach($dbs as $db)
                @if($db->requestedvip == null || $db->requestedvip == "" || $db->vmstatus == false)
                <div class="request-card content-box shadow-sm" >
                    <div class="request-card-header">
                        <div class="profile d-flex flex-row">
                                <div style="margin-right: 10px;height: 30px; width:30px; border-radius: 4vw;background-repeat: no-repeat; background-image: url({{ asset('img/avatar/'.$db->user->avatar.'.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;">
                                </div>
                                <div>{{$db->user->username}}
                                </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 5px;width: 150px;">

                            <form action="/dbrequest/{{$db->servicename}}/edit" method="GET" >

                                <button type="submit" class="btn btn-primary" style="width: 100%;">
                                    <i class="fa fa-edit"></i>
                                </button>
                        </form>

                            <form action="/dbrequest/{{$db->servicename}}" method="POST" >
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                                            <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                          </div>



                    </div>
                    <div class="request-card-body">
                        <div>
                            <table class="table table-bordered ">
                                <thead class="thead-light">
                                  <tr >
                                    <th>Hostname</th>
                                    <th>CPU</th>
                                    <th>RAM</th>
                                    <th>Disk</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        <td>
                                            {{$db->servicename}}db-01.wallet.lokal
                                        </td>
                                        <td>
                                            {{$db->requestedcpu}} Cores
                                        </td>
                                        <td>
                                            {{$db->requestedmemory}} GB
                                        </td>
                                        <td rowspan="2" style="border-left: 1px solid lightgrey;">
                                                    {{-- <ul>
                                                            @php
                                                            $disks = str_replace('"', '',$db->requesteddisk);
                                                            $disks = str_replace('\\', '', $disks);
                                                            $disks = explode(', ',$disks);
                                                            @endphp
                                                            @for($count = 0; $count < sizeof($disks); $count+=2)
                                                            <li>{{$disks[$count]}}: {{$disks[$count+1]}} GB</li>
                                                            @endfor

                                                        </ul> --}}
                                                        @php($disks = explode(', ',$db->requesteddisk))
                                                        <ul>
                                                        @if($db->engine == 'Postgres')
                                                            <li>/: {{$disks[0]}} GB</li>
                                                            <li>/db: {{$disks[1]}} GB</li>
                                                            <li>/archive_log: {{$disks[2]}} GB</li>
                                                            <li>/pg_log: {{$disks[3]}} GB</li>

                                                        @else
                                                            <li>/: {{$disks[0]}} GB</li>
                                                            <li>/db: {{$disks[1]}} GB</li>
                                                            <li>/logs: {{$disks[2]}} GB</li>
                                                        @endif
                                                        </ul>

                                        </td>
                                    </tr>
                                    <tr>
                                                <td>
                                                    {{$db->servicename}}db-02.wallet.lokal
                                                </td>
                                                <td>
                                                    {{$db->requestedcpu}} Cores
                                                </td>
                                                <td>
                                                    {{$db->requestedmemory}} GB
                                                </td>

                                    </tr>
                                    @if($db->engine == 'Postgres')
                                        <tr>
                                            <td>
                                                {{$db->servicename}}pgbouncer-01.wallet.lokal
                                            </td>
                                            <td>
                                                2 Cores
                                            </td>
                                            <td>
                                                4 GB
                                            </td>
                                            <td rowspan="2" style="border-left: 1px solid lightgrey;">
                                                    <ul>
                                                        <li>/: 20 GB</li>
                                                    </ul>

                                            </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                    {{$db->servicename}}pgbouncer-02.wallet.lokal
                                                </td>
                                                <td>
                                                    2 Cores
                                                </td>
                                                <td>
                                                    4 GB
                                                </td>
                                            </tr>
                                        @else
                                        <tr>
                                                <td>
                                                    {{$db->servicename}}arb-01.wallet.lokal
                                                </td>
                                                <td>
                                                    2 Cores
                                                </td>
                                                <td>
                                                    4 GB
                                                </td>
                                                <td rowspan="2" style="border-left: 1px solid lightgrey;">
                                                        <ul>
                                                            <li>/: 20 GB</li>
                                                        </ul>

                                                </td>
                                            </tr>
                                        @endif
                                </tbody>
                            </table>
                        </div>


                    </div>
                    <div class="request-card-footer" style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 15px;">
                        <div class="py-auto">
                                <form action="/dbrequest/updatevip/{{$db->servicename}}" method="POST">
                                    @csrf
                            <div class="input-group" style="margin-top: 6.75px;">


                                    <input type="text" name="virtualip" class="form-control my-auto" id="" value="{{$db->requestedvip}}" required placeholder="Virtual IP">
                                    <input type="hidden" name="_method" value="PUT" />
                                        <div class="input-group-append">
                                            @if($db->requestedvip == "")
                                                <button type="submit" class="btn btn-outline-secondary my-auto">Submit VIP</button>
                                            @else
                                                <button class="btn btn-primary my-auto">Update VIP</button>
                                            @endif

                                        </div>
                            </div>
                             </form>
                        </div>
                        <form action="/dbrequest/updatevmstatus/{{$db->servicename}}" method="POST" style="display: grid; align-items: center">
                            <input type="hidden" name="_method" value="PUT" />
                            @csrf
                        @if($db->vmstatus == false)
                            <button id="vm-not-ready" class="btn btn-outline-secondary my-auto">
                                <input  class="form-check-input" type="checkbox">
                                 VMs are not Ready
                            </button>
                        @else
                            <button id="vm-ready" class="btn btn-primary my-auto">
                                    <input class="form-check-input" type="checkbox" checked>
                                VMs are Ready
                            </button>
                        @endif
                        </form>
                    </div>

                  </div>
                  @endif
                @endforeach

            </div>
<script>


    window.onload = function(){

        $('#firstDiskName').val('/');
        $('#firstDiskSize').val('20');




        // class Disk{
        //     constructor(){
        //         this.diskRow = document.createElement('tr');
        //         this.diskData =  document.createElement('td');
        //         this.diskData2 = document.createElement('td');
        //         this.diskData3 = document.createElement('td');

        //         this.diskInput1 = document.createElement('input');
        //         this.diskInput1.classList.add('form-control');
        //         this.diskInput1.setAttribute('name', 'requestedDiskName[]');
        //         this.diskInput2 = document.createElement('input');
        //         this.diskInput2.classList.add('form-control');
        //         this.diskInput2.setAttribute('name', 'requestedDiskSize[]');

        //         this.buttonClose = document.createElement('button');
        //         this.buttonCloseText = document.createElement('i');
        //         this.buttonCloseText.classList.add('fa', 'fa-trash');
        //         this.buttonClose.classList.add('btn', 'btn-danger');
        //         this.buttonClose.style.cursor = "pointer";
        //         this.buttonClose.appendChild(this.buttonCloseText);

        //         this.diskData.appendChild(this.diskInput1);
        //         this.diskData2.appendChild(this.diskInput2);
        //         this.diskRow.appendChild(this.diskData);
        //         this.diskRow.appendChild(this.diskData2);

        //         this.diskData3.appendChild(this.buttonClose);

        //         this.diskRow.appendChild(this.diskData3);


        //         listDisk.appendChild(this.diskRow);

        //         this.buttonClose.addEventListener('click', () => this.remove(this.diskRow));
        //     }
        //     remove(diskRow){
        //         listDisk.removeChild(diskRow);
        //     }
        // }


        // $('#addDisk').click(function(){
        //     new Disk();
        // })



        $('#button-modal-show').click(function(){
            $('#request-postgres').prop('checked', false);
            $('#request-mongo').prop('checked', false);
            $('#service-name').val("");
            $('#db-primary-name').text("");
            $('#db-secondary-name').text("");
            $('#pgbouncer-primary-name').text("");
            $('#pgbouncer-secondary-name').text("");
            $('#db-arbiter-name').text("");
        })

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
            $('#secondDiskSize').val('50');
            $('#thirdDisk').css('display', 'table-row');
            $('#thirdDiskName').val('/archive_log');
            $('#thirdDiskSize').val('50');
            $('#fourthDisk').css('display', 'table-row');
            $('#fourthDiskName').val('/pg_log');
            $('#fourthDiskSize').val('10');
        })
        $('#request-mongo').click(function(){
            $('#pgbouncer-primary').hide();
            $('#pgbouncer-secondary').hide();
            $('#db-arbiter').show();
            $('#request-type').val('Mongo');
            $('#secondDisk').css('display', 'table-row');
            $('#secondDiskName').val('/data');
            $('#secondDiskSize').val('50');
            $('#thirdDisk').css('display', 'table-row');
            $('#thirdDiskName').val('/logs');
            $('#thirdDiskSize').val('10');
            $('#fourthDisk').css('display', 'none');

        })

        $('#service-name').on('input', function(){
            $('#db-primary-name').text($('#service-name').val());
            $('#db-secondary-name').text($('#service-name').val());
            $('#pgbouncer-primary-name').text($('#service-name').val());
            $('#pgbouncer-secondary-name').text($('#service-name').val());
            $('#db-arbiter-name').text($('#service-name').val());
        })


    }

</script>





@endsection





