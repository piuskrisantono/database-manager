
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





</style>




    <div class="d-flex justify-content-between mx-3 mt-4 shadow-sm py-0 content" style="height: 50px; margin-bottom: 15px;">
        <div class="my-auto" style="font-size: 20px;">
              Install
        </div>

            <div class="my-auto">
                <div id="first" class="step-tab step-now"> Choose DBMS</div>
                <div id="second" class="step-tab">Choose Services</div>
            </div>

      </div>


      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false" style="min-width: 100%;">
            <div class="carousel-inner">
                <form action="/dbrequest/install" method="POST">
                    @csrf
                    <div class="carousel-item px-3 pb-3 active">
                          <div class="d-flex flex-column p-4 shadow-sm align-items-center content-box">

                              <div class="d-flex flex-row justify-content-between my-4">

                                        <div class="db-choice d-flex flex-column">
                                            <div class="d-flex flex-row justify-content-center mb-4">
                                                      <div style="width: 200px; height: 200px; border: solid lightgrey 2px; border-radius: 50%;background-color: white;">
                                                      <div  style="width: 100%; height: 100%;  border-radius: 50%;background-repeat: no-repeat; background-image: url({{ asset('img/postgres.png') }}); background-position: center; background-size: 50%;">
                                                      </div>
                                                      </div>
                                            </div>

                                            <h5 class="card-title">PostgreSQL</h5>
                                            <p class="card-text">A relational database management system (RDBMS) emphasizing extensibility and technical standards compliance.</p>
                                            <p class="mt-auto">Available Version</p>

                                            <div class="d-flex justify-content-between mt-auto">
                                                  <button href="#carouselExampleControls" data-slide="next" type="button" id="postgresql-10" class="btn btn-primary btn-version">10</button>
                                                  <button href="#carouselExampleControls" data-slide="next" type="button" id="postgresql-11" class="btn btn-primary btn-version">11</button>
                                            </div>
                                        </div>

                                        <div style="height:auto; min-width: 1px; background-color:lightgrey;">
                                        </div>

                                        <div class="db-choice d-flex flex-column">
                                            <div class="d-flex flex-row justify-content-center mb-4">
                                                    <div style="width: 200px; height: 200px; border: solid lightgrey 2px; border-radius: 50%;background-color: white;">
                                                    <div  style="width: 100%; height: 100%;  border-radius: 50%;background-repeat: no-repeat; background-image: url({{ asset('img/mongodb.png') }}); background-position: center; background-size: 50%;">
                                                    </div>
                                                    </div>
                                            </div>

                                            <h5 class="card-title">MongoDB</h5>
                                            <p class="card-text">A NoSQL document-oriented database program, MongoDB uses JSON-like documents with schemata.</p>
                                            <p class="mt-auto">Available Version</p>

                                            <div class="d-flex justify-content-between mt-auto">
                                                <button href="#carouselExampleControls" data-slide="next" type="button" id="mongodb-34" class="btn btn-primary btn-version">3.4</button>
                                                <button href="#carouselExampleControls" data-slide="next" type="button" id="mongodb-36" class="btn btn-primary btn-version">3.6</button>
                                            </div>
                                        </div>

                              </div>
                            <input id="version" type="text" name="version" value="" hidden>
                          </div>

                      </div>


                      <div class="carousel-item px-3">

                            <div id="content-container">


                                    <div class="content shadow-sm">
                                        <div class="list-hostname  list-hostname-header">
                                            <h5 >Available Hosts</h5>

                                        </div>
                                        <div id="list-before" style="display: grid; grid-template-columns: 1fr; border-radius:5px; border: 1px solid lightgrey; overflow:hidden;">

                                        </div>
                                    </div>

                                    <div class="content shadow-sm">
                                            <div class="list-hostname  list-hostname-header">
                                                <h5>To be Installed</h5>

                                            </div>
                                            <div id="list-after" style="border-radius:5px; border: 1px solid lightgrey; overflow:hidden;">

                                            </div>

                                    </div>
                                </div>

                              <div class="d-flex flex-row justify-content-center pt-4" id="box-button">
                                <div class="d-flex flex-row-reverse " style="width: 100%;">
                                    <button class="btn btn-lg btn-primary border shadow-sm" type="submit" id="install-button" name="deploy">Install</button>
                                    <button onclick="goBack()" type="button" href="#carouselExampleControls" class="btn btn-lg btn-light mx-2 border shadow-sm" data-slide="prev">Back</button>
                                </div>
                              </div>



                    </div>



                </form>

                </div>

              </div>











<script>

    function goBack(){
        $("#first").addClass("step-now");
        $("#second").removeClass("step-now");
    }







    window.onload = function(){
        const listAfter = document.querySelector('#list-after');
        const listBefore = document.querySelector('#list-before');



        class Item{
            constructor(itemName){
                this.itemBox = document.createElement('div');
                this.itemBox.classList.add('list-hostname');

                this.boxName = document.createElement('div');
                this.boxNameText = document.createTextNode(itemName);

                this.aButton = document.createElement('button');

                this.boxName.appendChild(this.boxNameText);
                this.itemBox.appendChild(this.boxName);
                this.itemBox.appendChild(this.aButton);



            }
        }


        class ItemBefore extends Item {
            constructor(itemName){
                super(itemName);


                this.aButton.classList.add('btn', 'btn-success');

                var aButtonText = document.createTextNode("Add");
                this.aButton.appendChild(aButtonText);

                listBefore.appendChild(this.itemBox);

                this.aButton.addEventListener('click', () => {
                    this.add(this.itemBox, itemName);
                    $('#install-button').prop('disabled', false);
                });

            }

            add(itemBox, itemName){
                listBefore.removeChild(itemBox);
                new ItemAfter(itemName);
            }
        }

        class ItemAfter extends Item {
            constructor(itemName){
                super(itemName);

                this.aButton.classList.add('btn', 'btn-danger');

                this.inputButton = document.createElement('input');
                this.itemBox.appendChild(this.inputButton);

                this.inputButton.setAttribute('name', 'installDatabase[]');
                this.inputButton.setAttribute('value', itemName);
                this.inputButton.setAttribute('type', 'hidden');

                var aButtonText = document.createTextNode("Remove");
                this.aButton.appendChild(aButtonText);


                listAfter.appendChild(this.itemBox);

                this.aButton.addEventListener('click', () => {
                    this.remove(this.itemBox, itemName);
                    if(!listAfter.firstChild) $('#install-button').prop('disabled', true);


                });
            }

            remove(itemBox, itemName){
                listAfter.removeChild(itemBox);
                new ItemBefore(itemName);
            }
        }

        function removeAllChild(){

            while (listAfter.firstChild) {
                listAfter.removeChild(listAfter.firstChild);
            }
            while (listBefore.firstChild) {
                listBefore.removeChild(listBefore.firstChild);
            }
            $('#install-button').prop('disabled', true);

        }


        function selectPostgres(){
            removeAllChild();
            @foreach ($dbs as $db)
                @if($db->engine == 'Postgres')
                    new ItemBefore('{{$db->servicename}}');
                @endif
            @endforeach
        }

        function selectMongo(){
            removeAllChild();
            @foreach ($dbs as $db)
                @if($db->engine == 'Mongo')
                    new ItemBefore('{{$db->servicename}}');
                @endif
            @endforeach
        }





        $("#postgresql-10").click(function(){
            $(".checklist-postgres").show();
            $("#version").val("10");
            $("#second").addClass("step-now");
            $("#first").removeClass("step-now");
            selectPostgres();
        });

        $("#postgresql-11").click(function(){
            $(".checklist-postgres").show();
            $("#version").val("11");
            $("#second").addClass("step-now");
            $("#first").removeClass("step-now");
            selectPostgres();
        });

        $('#mongodb-34').click(function(){
            $('.checklist-postgres').hide();
            $("#version").val("3.4");
            $("#second").addClass("step-now");
            $("#first").removeClass("step-now");
            selectMongo();
        });


        $('#mongodb-36').click(function(){
            $('.checklist-postgres').hide();
            $("#version").val("3.6");
            $("#second").addClass("step-now");
            $("#first").removeClass("step-now");
            selectMongo();
        });


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
            $('#request-type').val('postgres');
        })
        $('#request-mongo').click(function(){
            $('#pgbouncer-primary').hide();
            $('#pgbouncer-secondary').hide();
            $('#db-arbiter').show();
            $('#request-type').val('mongo');
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





