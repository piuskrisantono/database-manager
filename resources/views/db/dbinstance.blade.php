@extends('layouts.master')

@section('content')


<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://172.22.252.137:9100/metrics');

// curl_setopt($ch, CURL_RETURNTRANSFER, 1);

// curl_setopt($ch, CURL_OPT_HEADER, 0);

$output = curl_exec($ch);

if($output === FALSE){
    echo "cURL Error" . curl_error($ch);
}

curl_close($ch);

print_r($output);

?>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <form action="" class="form-update" method="POST">
      <div class="modal-header">

        <h5 class="modal-title">
            <output id="servicename"></output>
            <input class="form-control" type="text"  id="servicename-edit" name="servicename" style="display: none;">
        </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">


      <div class="row">
        <div class="col-6">


        <div class="d-block mb-3" style="width: 100%;"><i class="fa fa-arrow-circle-right" aria-hidden="true" style="margin-right: 5px"></i><strong>DB Details</strong>
            </div>
          <div class="form-group row">
              <label for="dbengine" class="col-sm-4 col-form-label">
                  DB Engine
              </label>
              <div class="col-sm-8">
                  <input class="form-control" type="text"  id="dbengine" name="dbengine" disabled>
              </div>
          </div>

          <div class="form-group row">
              <label for="hostname" class="col-sm-4 col-form-label">
                  Hostname
              </label>
              <div class="col-sm-8">
                  <input class="form-control" type="text"  id="hostname" name="hostname" disabled>
              </div>
          </div>

                  <input class="form-control" type="text"  id="superusername" name="superusername" hidden>

          <div class="form-group row">
              <label for="superuserpassword" class="col-sm-4 col-form-label">
                  Superuser Password
              </label>
              <div class="col-sm-8">
                  <input class="form-control" type="password"  id="superuserpassword" name="superuserpassword" disabled>
              </div>
          </div>



          <div class="d-block mb-3" style="width: 100%;"><i class="fa fa-arrow-circle-right" aria-hidden="true" style="margin-right: 5px"></i><strong>pgBackRest Repo</strong>
          </div>

          <button class="btn btn-primary pgbackrest-no mb-3">Install</button>

          <div class="form-group row pgbackrest-yes">
              <label for="backrestrepo" class="col-sm-4 col-form-label">
                  Repo
              </label>
              <div class="col-sm-8">
                  <input class="form-control" type="text"  id="backrestrepo" name="backrestrepo" disabled>
              </div>
          </div>



        </div>
        <div class="col-6">



        <div class="d-block mb-3" style="width: 100%;"><i class="fa fa-arrow-circle-right" aria-hidden="true" style="margin-right: 5px"></i><strong>Replication</strong>
          </div>

          <button class="btn btn-primary replica-no mb-3">Install</button>

          <div class="form-group row replica-yes">
              <label for="replica" class="col-sm-4 col-form-label">
                  Hostname
              </label>
              <div class="col-sm-8">
                  <input class="form-control" type="text"  id="replica" name="replica" disabled>
              </div>
          </div>
          <div class="form-group row replica-yes">
              <label for="replicausername" class="col-sm-4 col-form-label">
                  Replication Username
              </label>
              <div class="col-sm-8 replica-yes">
                  <input class="form-control" type="text"  id="replicausername" name="replicausername" disabled>
              </div>
          </div>
          <div class="form-group row replica-yes">
              <label for="replicauserpassword" class="col-sm-4 col-form-label">
                  Replication Password
              </label>
              <div class="col-sm-8 replica-yes">
                  <input class="form-control" type="password"  id="replicauserpassword" name="replicauserpassword" disabled>
              </div>
          </div>



          <div class="d-block mb-3" style="width: 100%;"><i class="fa fa-arrow-circle-right" aria-hidden="true" style="margin-right: 5px"></i><strong>Pgpool</strong>
          </div>

          <button class="btn btn-primary pgpool-no mb-3">Install</button>

          <div class="form-group row pgpool-yes">
              <label for="pgpoolmaster" class="col-sm-4 col-form-label">
                  Master Hostname
              </label>
              <div class="col-sm-8">
                  <input class="form-control" type="text"  id="pgpoolmaster" name="pgpoolmaster" disabled>
              </div>
          </div>
          <div class="form-group row pgpool-yes">
              <label for="pgpoolslave" class="col-sm-4 col-form-label">
                  Slave Hostname
              </label>
              <div class="col-sm-8">
                  <input class="form-control" type="text"  id="pgpoolslave" name="pgpoolslave" disabled>
              </div>
          </div>




        </div>
      </div>




      </div>

      <div class="modal-footer">
        <button onclick="updateDb()" type="button" id="update-db" class="btn btn-primary">Update</button>
        <button onclick="resetForm()"  data-dismiss="modal" type="button" id="reset-form" class="btn btn-primary" style="display: none;">Reset & Close</button>
        <input type="hidden" name="_method" value="PUT" />
        <button type="submit" id="save-changes" class="btn btn-success" style="display: none;">Save changes</button>
    </form>
    <form class="form-update" action="" method="POST">
        <input type="hidden" name="_method" value="DELETE" />
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>

      </div>



    </div>
  </div>
</div>







  <div class="modal fade" id="modallogin" tabindex="-1" role="dialog" aria-labelledby="modallogin" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <form action="/dbrequest/installed/authdb" method="POST">
        <div class="modal-body">

            <input type="hidden" name="hostname" id="hostnameauth">

            <div class="form-group row">
                <label for="username" class="col-md-3 col-form-label text-md-right">{{ __('Username') }}</label>
                <div class="col-sm-8">
                        <div class="input-group">
                                <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                        </div>


                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-8">
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
            </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Login</button>
        </div>

        </form>


      </div>
    </div>
  </div>





<div class="py-4" style="margin: auto">

        <div class="d-flex justify-content-between mx-3 px-3 shadow-sm py-0 content-box" style="background-color: white; height: 50px; margin-bottom: 10px;">
                <div class="title-tab my-auto" style="font-size: 20px; overflow:hidden">
                    Instances
                </div>



                <form class="form-inline my-auto">
                    <button href="" class="btn btn-primary mx-2" type="button">Add Existing DB</button>
                    <input class="form-control mr-sm-2" type="search" placeholder="Search DB" aria-label="Search">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit" style="border-radius:50%"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>


        </div>

        <div class="content-box p-auto shadow-sm mx-3">
                <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Service Name</th>
                            <th scope="col">DBMS</th>
                            <th scope="col">Virtual IP</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @isset($dbs)
                              @foreach($dbs as $db)
                                  <tr>
                                      <td>{{$db->servicename}}</td>
                                      <td>{{$db->engine}}</td>
                                      <td>{{$db->requestedvip}}</td>
                                  <td style="color: {{($db->installed == 'Installed') ? '#2ecc71' : '#3498db'}};">{{$db->installed}}</td>
                                      <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"data-target="#exampleModalCenter">
                                          <i class="fa fa-edit" onclick="changePopup(
                                        '{{$db->servicename}}',
                                        '{{$db->dbengine}}',
                                        '{{$db->hostname}}',
                                        '{{$db->superusername}}',
                                        '{{$db->superuserpassword}}',
                                        '{{$db->replica}}',
                                        '{{$db->replicausername}}',
                                        '{{$db->replicauserpassword}}',
                                        // '{{$db->backrestrepo}}',
                                        '',
                                        '{{$db->pgpoolmaster}}',
                                        '{{$db->pgpoolslave}}'
                                         )" style="cursor: pointer;"></i>
                                        </button>

                                    <button type="button" onclick="popupLogin('{{$db->servicename}}')" class="btn btn btn-warning" data-toggle="modal" data-target="#modallogin">
                                        <i class="fa fa-cog " style="color:white;"></i>
                                    </button>
                                      {{-- <a href="/dbrequest/installed/{{$db->servicename}}"></a> --}}
                                    </td>

                                  </tr>
                              @endforeach
                            @endisset
                            @empty($dbs)
                              <tr><td colspan=4 style="text-align: center;">There is no database created, yet.</td></tr>
                            @endempty
                        </tbody>
                      </table>
        </div>
        <div class="d-flex flex-row-reverse mx-3">
                {{ $dbs->links() }}
        </div>


<div id="box"></div>




</div>

<script>


    function updateDb() {
        $("#update-db").hide();
        $("#reset-form").show();
        $("#save-changes").show();
        $("#servicename-edit").show();
        $("#servicename").hide();


        $('#dbengine').prop("disabled", false);
      $('#hostname').prop("disabled", false);
      $('#superusername').prop("disabled", false);
      $('#superuserpassword').prop("disabled", false);
      $('#replica').prop("disabled", false);
      $('#replicausername').prop("disabled", false);
      $('#replicauserpassword').prop("disabled", false);
      $('#backrestrepo').prop("disabled", false);
      $('#pgpoolmaster').prop("disabled", false);
      $('#pgpoolslave').prop("disabled", false);
    }


    function resetForm() {
        $("#update-db").show();
        $("#reset-form").hide();
        $("#save-changes").hide();
        $("#servicename-edit").hide();
        $("#servicename").show();


      $('#dbengine').prop("disabled", true);
      $('#hostname').prop("disabled", true);
      $('#superusername').prop("disabled", true);
      $('#superuserpassword').prop("disabled", true);
      $('#replica').prop("disabled", true);
      $('#replicausername').prop("disabled", true);
      $('#replicauserpassword').prop("disabled", true);
      $('#backrestrepo').prop("disabled", true);
      $('#pgpoolmaster').prop("disabled", true);
      $('#pgpoolslave').prop("disabled", true);
    }

    function popupLogin(a){
        $('#exampleModalLongTitle').text('Authenticate to ' + a);
        $('#hostnameauth').val(a);
    }

    function changePopup(a,b,c,d,e,f,g,h,i,j,k) {
      $('.form-update').attr("action", "/db/" + a);

      $('#servicename').val(a);
      $('#servicename-edit').val(a);
      $('#dbengine').val(b);
      $('#hostname').val(c);
      $('#superusername').val(d);
      $('#superuserpassword').val(e);
      $('#replica').val(f);
      $('#replicausername').val(g);
      $('#replicauserpassword').val(h);
      $('#backrestrepo').val(i);
      $('#pgpoolmaster').val(j);
      $('#pgpoolslave').val(k);

      if(f == "-"){
        $('.replica-yes').hide();
        $('.replica-no').show();
      }
      else{
        $('.replica-no').hide();
        $('.replica-yes').show();
      }

      if(i == "-"){
        $('.pgbackrest-yes').hide();
        $('.pgbackrest-no').show();
      }
      else{
        $('.pgbackrest-no').hide();
        $('.pgbackrest-yes').show();
      }

      if(j == "-"){
        $('.pgpool-yes').hide();
        $('.pgpool-no').show();
      }
      else{
        $('.pgpool-no').hide();
        $('.pgpool-yes').show();
      }
  }




$(document).ready(function(){


        $("#box").load("http://172.20.1.118:9100/metrics");

});





</script>

@endsection
