@extends('layouts.master')

@section('content')

<style>
    .fa-exclamation-triangle::after {
        position: absolute;
        content: "Changes require database to be restarted";
        background-color: white;
        font-size: 11pt;
        line-height: 16pt;
        border-radius: 5px;
        box-shadow: 0 1px #FFFFFF inset, 0 1px 3px rgba(34, 25, 25, 0.4);
        color: black;
        font-family: "Helvetica";
        font-weight: normal;
        display: none;
        padding: 5px;
        top: 100%;
    }
    .fa-exclamation-triangle:hover::after {
        display: inline-block;
    }
</style>



<div class="modal fade" id="modalRestart" tabindex="-1" role="dialog" aria-labelledby="modalRestart" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Restart Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <div class="modal-body">
            One or more configuration parameter needs database to be restarted, Do you want to restart <b>now</b>?
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="configform">Restart Now</button>
        </div>


      </div>
    </div>
  </div>




<div class="py-4" style="margin: auto">

        <div class="d-flex justify-content-between mx-3 px-3 shadow-sm py-0 content-box" style="background-color: white; height: 50px; margin-bottom: 10px;">
                <div class="title-tab my-auto" style="font-size: 20px; overflow:hidden">
                    Configuration of {{$dbcredentials->hostname}}
                </div>
        </div>
        <form id="configform" action="/dbrequest/installed/modify-config" method="POST">
        <input type="hidden" name="username" value="{{$dbcredentials->username}}">
        <input type="hidden" name="password" value="{{$dbcredentials->password}}">
        <input type="hidden" name="hostname" value="{{$dbcredentials->hostname}}">

        <div class="content-box p-auto shadow-sm mx-3">

            <div style="max-height: 70vh; overflow: auto;">
                <table class="table  overflow-auto">
                    <thead style="text-align: center;  position: -webkit-sticky;position: sticky;top: 0; background-color: white; ">
                        <tr>
                            <th>Config Name</th>
                            <th>Value</th>
                            <th>Description</th>
                        </tr>
                    </thead>

                    <tbody>
                        @while ($row = pg_fetch_row($config))
                        <tr>
                            <td>
                                {{$row[0]}}

                            </td>
                            <td style="width: 100%;">
                                <div style="display: grid; grid-template-columns: auto 45px 45px; grid-column-gap:5px">
                                    <input class="form-control" type="text" readonly value="{{$row[1] . $row[2]}}">
                                    <input type="hidden"  id="configname" value="{{$row[0]}}">
                                    <button type="button" class="configinput btn btn-primary" onclick="addRestart('{{$row[5]}}')"><i class="fa fa-edit"></i></button>
                                    <button  type="button" class="configdisable btn btn-warning" onclick="minRestart('{{$row[5]}}')" style="display:none;font-weight: bold;">&times;</button>
                                    @if($row[5] == 'postmaster')
                                     <i class="fa fa-2x fa-exclamation-triangle" style="cursor: pointer;position: relative; color: #f1c40f;"></i>
                                    @endif

                                </div>
                            </td>
                        <td>
                            {{$row[3]}} {{$row[4]}}
                        </td>

                        @endwhile



                    </tbody>


                </table>
            </div>



            <div class="px-3 d-flex flex-row-reverse" style="border-top: 1px solid lightgrey;height: 50px;">
                <button type="submit" class="shadow-sm btn btn-primary my-auto" id="buttonSubmitForm">Apply Changes</button>
            </div>
        </div>


        <input type="hidden" name="counterRestart" id="counterRestart">

    </form>



</div>

<script>

    function addRestart(context){
        if(context == 'postmaster'){
            $('#counterRestart').val(Number($('#counterRestart').val()) + 1);
            checkValue()
        }
    }

    function minRestart(context){
        if(context == 'postmaster'){
            $('#counterRestart').val(Number($('#counterRestart').val()) - 1);
            checkValue()
        }
    }

    function checkValue(){
        if($('#counterRestart').val() != '0'){
             $('#buttonSubmitForm').attr('type', 'button');
             $('#buttonSubmitForm').attr('data-toggle', 'modal');
             $('#buttonSubmitForm').attr('data-target', '#modalRestart');
        }
        else {
             $('#buttonSubmitForm').attr('type', 'submit');
             $('#buttonSubmitForm').attr('data-toggle', '');
             $('#buttonSubmitForm').attr('data-target', '');
        }
    }



    $('.configinput').click(function(){
        $(this).siblings(".form-control").attr('readonly', false);
        $(this).siblings(".form-control").attr('name', 'changedconfigvalue[]');
        $(this).siblings("#configname").attr('name', 'changedconfigname[]');
        $(this).siblings(".configdisable").css('display', 'inline-block');
        $(this).css('display', 'none');
    })
    $('.configdisable').click(function(){
        $(this).siblings(".form-control").attr('readonly', true);
        $(this).siblings(".form-control").attr('name', '');
        $(this).siblings("#configname").attr('name', '');
        $(this).siblings(".configinput").css('display', 'inline-block');
        $(this).css('display', 'none');
    })

    $(document).ready(function(){

        $('#counterRestart').val(0);

    });
</script>

@endsection
