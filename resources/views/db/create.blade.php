@extends('layouts.master')

@section('content')

<style>
    .content-box{
        padding: 15px;
    }
</style>



<div class="py-4" style="margin: auto">

        <div class="d-flex justify-content-between mx-3 px-3 shadow-sm py-0 content-box" style="background-color: white; height: 50px; margin-bottom: 10px;">
                <div class="title-tab my-auto" style="font-size: 20px; overflow:hidden">
                    Create Request
                </div>
        </div>

        <div class="content-box p-auto shadow-sm mx-3">
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






                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Send Request</button>

          </form>
        </div>



</div>
@endsection

<script>

window.onload = function(){

$('#firstDiskName').val('/');
$('#firstDiskSize').val('20');



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

        $('#request-postgres').trigger('click');
}

</script>
