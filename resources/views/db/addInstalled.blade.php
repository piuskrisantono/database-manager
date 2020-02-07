@extends('layouts.master')

@section('content')

<style>
    .content-box{
        padding: 15px;
    }

    #form-content {
        grid-row-gap: 15px;
    }
    #form-content > div, #dbms-form {
        border: 1px solid lightgrey;
        padding: 15px;
        border-radius: 5px;
    }
</style>



<div class="py-4" style="margin: auto">

        <div class="d-flex justify-content-between mx-3 px-3 shadow-sm py-0 content-box" style="background-color: white; height: 50px; margin-bottom: 10px;">
                <div class="title-tab my-auto" style="font-size: 20px; overflow:hidden">
                    Add Existing Database
                </div>
                <div style="display:grid; align-items:center;">
                    <a href="/" class="btn btn-primary" style="width: 150px;">Cancel</a>
                </div>

        </div>

        <div class="content-box p-auto shadow-sm mx-3">
                <form  action="/adddatabase" method="POST">
                  @csrf








                  <div id= "form-content" style="display: grid; grid-template-columns: 1fr 1fr;grid-column-gap: 15px;">

                    <div id="dbms-form" style="grid-column: 1/3; display: grid; grid-column-gap: 10px; grid-template-columns: auto 1fr 1fr 1fr 1fr; align-items:center; padding: 15px;">
                        <span>Database Management System</span>
                        <label class="btn btn-outline-primary my-auto"><input id="postgres10" type="radio"> PostgreSQL 10</label>
                        <label class="btn btn-outline-primary my-auto"><input id="postgres11" type="radio"> PostgreSQL 11</label>
                        <label class="btn btn-outline-success my-auto"><input  id="mongo34" type="radio"> MongoDB 3.4</label>
                        <label class="btn btn-outline-success my-auto"><input  id="mongo36" type="radio"> MongoDB 3.6</label>
                        <input id="request-type" type="text" name="version" value="" hidden>
                    </div>

                        <div>
                            <label for="service-name" >Service Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="service-name" name="servicename">
                                <div class="input-group-append">
                                        <span class="input-group-text" id="request-extension">db-XX.wallet.lokal</span>
                                </div>
                            </div>
                        </div>


                        <div>
                            <label for="service-name" >Virtual IP</label>
                                <div class="input-group">
                                <input type="text" class="form-control" id="service-name" name="requestedvip">
                            </div>
                        </div>




                  </div>






                  <div class="d-flex flex-row-reverse mt-3">
                    <button type="submit" class="btn btn-primary" style="width:150px;"><i class="fa fa-plus"></i> Add Database</button>
                  </div>



          </form>
        </div>



</div>
@endsection

<script>

window.onload = function(){


         $('#postgres10').click(function(){
            $('#request-type').val('PostgreSQL 10');
        })
        $('#postgres11').click(function(){
            $('#request-type').val('PostgreSQL 11');
        })
        $('#mongo34').click(function(){
            $('#request-type').val('MongoDB 3.4');
        })
        $('#mongo36').click(function(){
            $('#request-type').val('MongoDB 3.6');
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
