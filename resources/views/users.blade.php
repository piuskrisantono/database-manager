
@extends('layouts.master')

@section('content')

<style>
    #img-grid > div{
        opacity: 50%;
        position: relative;
    }


    #img-grid > div:hover{
        opacity: 100%;
    }

    .count-div {
         height: 120px;
         padding: 0 15px;
        /* display: grid; */
        /* grid-template-rows: 1fr 2fr; */
        /* align-items: center; */

        /* grid-row-gap: 5px;  */
        text-align: center;
    }

    /* .count-div > h1 {
        font-size: 50px;
    } */

    /* #img-grid > div:after{
        position: absolute;
        content: "";
        background-color: #28a745;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        right: 0;
    } */

</style>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered" role="document">

          <div class="modal-content">

                <form  class="form-update" action=""  method="POST">
                        {{ csrf_field() }}
            <div class="modal-body d-flex flex-column justify-content-center align-items-center">

                    <div style="width: 100%; position: relative;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: relative; right:0;">
                                    <span aria-hidden="true">&times;</span>
                            </button>
                    </div>



                    <div id="popup-picture"  style="height: 200px; width: 200px; border-radius: 50%;background-repeat: no-repeat; background-image: url({{ asset('img/avatar/X.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;">
                    </div>

                    <h3 class="my-3" id="username"></h3>
                    <input id="avatarid" name="avatarid" hidden>
                    <div id="img-grid" class="my-3" style="display: grid; grid-template-rows: auto; grid-template-columns: repeat(4, 1fr); grid-column-gap: 10px;">

                            <div id="img-1" onclick="changePicture('1')"  style="height: 30px; width:30px; border-radius: 4vw;background-repeat: no-repeat; background-image: url({{ asset('img/avatar/1.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;  cursor: pointer;">
                            </div>
                            <div id="img-2" onclick="changePicture('2')"  style="height: 30px; width:30px; border-radius: 4vw;background-repeat: no-repeat; background-image: url({{ asset('img/avatar/2.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;  cursor: pointer;">
                            </div>
                            <div id="img-3" onclick="changePicture('3')"  style="height: 30px; width:30px; border-radius: 4vw;background-repeat: no-repeat; background-image: url({{ asset('img/avatar/3.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;  cursor: pointer;">
                            </div>
                            <div id="img-4" onclick="changePicture('4')"  style="height: 30px; width:30px; border-radius: 4vw;background-repeat: no-repeat; background-image: url({{ asset('img/avatar/4.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;  cursor: pointer;">
                            </div>
                    </div>
                    <div class="form-group" style="width: 150px;">
                            <select class="form-control" id="role" name="role">
                              <option value="1">DBA</option>
                              <option value="2">DevOps</option>
                              <option value="3">Nobody</option>
                            </select>
                    </div>



            </div>

            <div class="modal-footer" style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 10px;">
              <input type="hidden" name="_method" value="PUT" />
              <button  type="submit"  class="btn btn-primary">Save</button>
            </form>
          <form   class="form-update" action="" method="POST">
              <input type="hidden" name="_method" value="DELETE" />
              <button type="submit" style="width:100%;"  class="btn btn-danger">Delete</button>
          </form>

            </div>



          </div>
        </div>
    </div>

<div class="d-flex justify-content-between mx-3 mt-4 shadow-sm py-0 content" style="height: 50px; margin-bottom: 15px;">
    <div class="my-auto" style="font-size: 20px;">
          <span class="pageTitle"> Manage Users</span>
    </div>

    <form class="form-inline my-auto">
        <input class="form-control mr-sm-2" type="search" placeholder="Search User" aria-label="Search">
        <button class="btn btn-primary my-2 my-sm-0" type="submit" style="border-radius:50%"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
  </div>


  <div class="mx-3" style="display: grid; grid-template-columns: auto 120px 120px; grid-column-gap: 15px;">

  <div class="shadow-sm py-0 content">
    <table class="table">
        <thead>
          <tr>
            <th scope="col" style="width: 50px;"></th>
            <th scope="col">Username</th>
            <th scope="col">Role</th>
            <th scope="col">Modify</th>
          </tr>
        </thead>
        <tbody>
                @php
                    $dbaCount = 0; $devopsCount = 0;
                @endphp
            @foreach($users as $user)
                <tr>
                    <td style="width: 50px;">
                        <div  style="height: 30px; width:30px; border-radius: 4vw;background-repeat: no-repeat; background-image: url({{ asset('img/avatar/'.$user->avatar.'.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;">
                        </div>
                    </td>
                    <td>{{$user->username}}</td>
                    <td>

                        @if($user->role_id == '1')
                            DBA
                            @php $dbaCount++;
                            @endphp
                        @elseif($user->role_id == '2')
                            DevOps
                            @php $devopsCount++;
                            @endphp
                        @else
                            Nobody
                        @endif
                    </td>
                    <td>
                        <div class="btn btn-primary" onclick="changePopup(
                            '<?php echo $user->id;?>',
                            '<?php echo $user->username;?>',
                            '<?php echo $user->role_id;?>',
                            '<?php echo $user->avatar;?>'
                            )"  data-toggle="modal" data-target="#exampleModalCenter">
                                <i class="fa fa-edit" >
                               </i>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
  </div>



    <div class="content count-div">
            <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">DBA</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                    <h3>{{$dbaCount}}</h3>
                            </td>
                        </tr>
                    </tbody>
            </table>
    </div>
    <div class="content count-div">
            <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">DevOps</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                    <h3>{{$devopsCount}}</h3>
                            </td>
                        </tr>
                    </tbody>
            </table>

    </div>

</div>


<script>

    function changePicture(id){
        var pictureLink = $('#popup-picture').css("background-image").substring( 0,  $('#popup-picture').css("background-image").length - 7);
            var pictureLink = pictureLink + id + ".png";
        $('#popup-picture').css("background-image", pictureLink);
        $('#avatarid').val(id);
    }

    // function changeFormAction(id){
    //     var actionId =   $("#form-update").attr('action').substring( 0,  $("#form-update").attr('action').length - 1);
    //     var actionId = actionId + id;
    //     $("#form-update").attr('action', actionId);
    // }

    function changePopup(a,b,c,d) {
        $('.form-update').attr('action' , 'http://127.0.0.1:8000/user/'+a)

        changePicture(d);

        $('#username').text(b);

        $('#img-'.d).css("opacity", "100%");

        $('#role').val(c);

     }


     $(document).ready(function(){

     });


</script>

@endsection
