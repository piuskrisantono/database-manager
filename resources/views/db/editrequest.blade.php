
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
      text-align: center;
      vertical-align: middle;
    }


    /* .request-card > .request-card-body {
        padding: 15px;
    } */

    .request-card-footer {
        padding-left: 15px;
        padding-right: 15px;
    }

    .table {
        margin-bottom: 0;
    }



</style>




    <div class="d-flex justify-content-between mx-3 mt-4 shadow-sm py-0 content" style="height: 50px; margin-bottom: 15px;">
        <div class="my-auto" style="font-size: 20px;">
             Edit Request
        </div>

            <div class="my-auto">
            <a href="/dbrequest" id="button-modal-show" class="btn btn-primary" style="width: 150px;">
                    Cancel
            </a>

            </div>

      </div>

    <form  action="/dbrequest/{{$dbrequest->servicename}}" method="POST">
        <input type="hidden" name="_method" value="PUT" />
        @csrf

            <div class="px-3" style="display: grid; grid-template-columns: 1fr; grid-row-gap: 15px; margin-bottom: 15px;">
                <div class="content shadow-sm">


                                <div class="my-2">Database Management System</div>
                              <div style="display: grid; grid-column-gap: 10px; grid-template-columns: 1fr 1fr;">
                                    <label class="btn btn-outline-primary"><input id="request-postgres" type="radio" name="request-dbms" name=""> PostgreSQL</label>
                                    <label class="btn btn-outline-success"><input  id="request-mongo" type="radio" name="request-dbms"> MongoDB</label>
                                    <input id="request-type" type="text" name="requestType" value="" hidden>
                              </div>
                              <label for="service-name" class="col-form-label">Service Name</label>
                            <div class="input-group">
                            <input type="text" class="form-control" id="service-name" name="serviceName" value="{{$dbrequest->servicename}}">
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
                                                                        <select  class="form-control" name="requestCpu" placeholder="{{$dbrequest->requestedcpu}}">
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
                                                </div>
                                                <div>
                                                        <div class="form-group row">
                                                                <label for="inputPassword" class="col-sm-4 col-form-label">Memory</label>
                                                                <div class="col-sm-4">
                                                                <select class="form-control"  id="exampleSelect1" name="requestMemory" value="{{$dbrequest->requestedmemory}}">
                                                                        <option value="4">4</option>
                                                                        <option value="8">8</option>
                                                                        <option value="16">16</option>
                                                                        <option value="32">32</option>
                                                                        <option value="64">64</option>
                                                                        <option value="128">128</option>
                                                                </select>

                                                            </div>
                                                            <label for="inputPassword" class="col-sm-4 col-form-label">GB</label>
                                                    </div>
                                                </div>

                                    </div>
                            </div>
                            <br>

                            <div style="display: grid; grid-template-columns: 3fr 2fr;grid-column-gap: 15px;">
                                <div>
                                    <div class="my-2">New Disk Partition</div>
                                    <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th scope="col">Partition Name</th>
                                            <th scope="col">Partition Size (GB)</th>

                                          </tr>
                                        </thead>
                                        <tbody id="listDisk">
                                            @php($disks = explode(', ',$dbrequest->requesteddisk))

                                          <tr id="firstDisk">
                                            <td><input id="firstDiskName" readonly type="text" class="form-control" value="/" name="requestedDiskName[]"></td>
                                            <td><input id="firstDiskSize" type="text" class="form-control" name="requestedDiskSize[]" value="{{$disks[0]}}"></td>

                                          </tr>
                                          <tr id="secondDisk" style="display: none;">
                                            <td><input id="secondDiskName" readonly type="text" class="form-control"  name="requestedDiskName[]"></td>
                                            <td><input id="secondDiskSize" type="text" class="form-control" name="requestedDiskSize[]" value="{{$disks[1]}}"></td>

                                          </tr>
                                          <tr id="thirdDisk" style="display: none;">
                                            <td><input id="thirdDiskName" readonly type="text" class="form-control"  name="requestedDiskName[]"></td>
                                            <td><input id="thirdDiskSize" type="text" class="form-control" name="requestedDiskSize[]" value="{{$disks[2]}}"></td>

                                          </tr>
                                          <tr id="fourthDisk" style="display: none;">
                                            <td><input id="fourthDiskName" readonly type="text" class="form-control"  name="requestedDiskName[]"></td>
                                            <td><input id="fourthDiskSize" type="text" class="form-control" name="requestedDiskSize[]"
                                                @if($dbrequest->engine == "Postgres")
                                                value="{{$disks[3]}}"
                                                @endif
                                                ></td>

                                          </tr>
                                        </tbody>
                                      </table>
                                      {{-- <div class="btn btn-success" id="addDisk" style="cursor: pointer;"><i class="fa fa-plus"></i> Add Disk</div>
                                    </div> --}}


                            </div>




                </div>
                <div class="px-3" style="display: flex; justify-content: flex-end; ">
                    <button class="btn btn-primary" type="submit" style="width: 150px;">Save</button>
                </div>
            </div>

        </form>
<script>


    window.onload = function(){




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
        //         this.diskInput2.setAttribute('name', 'requestedDiskSize[]');
        //         this.diskInput2.classList.add('form-control');

        //         this.buttonClose = document.createElement('div');
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

        $('#service-name').on('input', function(){
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





@endsection





