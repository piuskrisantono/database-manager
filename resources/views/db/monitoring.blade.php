@extends('layouts.master')

@section('content')

<script src="{{ asset('js/plotly-latest.min.js') }}"></script>


<style>

    .content-box{
        border-radius: 5px;
        margin: 0px;
        padding: 0px;
    }

</style>

<script>
    var counter = 0;


    var time = new Date().toLocaleTimeString();;


    function getData(){
        return Math.random();
    }


    setInterval(function(){
        var time = new Date().toLocaleTimeString();;
        Plotly.extendTraces('chart-cpu', {y: [[getData()]], x: [[time]]}, [0] );

        Plotly.extendTraces('chart-memory', {y: [[getData()]] , x: [[time]]},  [0]);

        Plotly.extendTraces('chart-connections', {y: [[getData()]], x: [[time]]},  [0]);

        Plotly.extendTraces('chart-locking', {y: [[0]], x: [[time]]},  [0]);

        counter++;

        if(counter > 30){
            Plotly.relayout('chart-cpu', {
                xaxis: {
                    range: [counter-30, counter]
                }
            });

            Plotly.relayout('chart-memory', {
                xaxis: {
                    range: [counter-30, counter]
                }
            });

            Plotly.relayout('chart-locking', {
                xaxis: {
                    range: [counter-30, counter]
                }
            });

            Plotly.relayout('chart-connections', {
                xaxis: {
                    range: [counter-30, counter]
                }
            });
        }
    }, 1000);

</script>

<div class="py-4" style="margin: auto">

        <div class="d-flex justify-content-between mx-3 px-3 shadow-sm py-0 content-box" style="background-color: white; height: 50px; margin-bottom: 10px;">
                <div class="title-tab my-auto" style="font-size: 20px; overflow:hidden">
                    Performance Monitor of {{$servicename}}
                </div>
        </div>

        <div class="mx-3" style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 15px; grid-row-gap: 15px;">


            <div class="content-box p-auto shadow-sm " >

                <div id="chart-cpu" style="margin: 0px; padding: 0px;"></div>

                <script>

                    var layout = {
                        title: 'CPU Usage'
                    };

                    Plotly.plot('chart-cpu', [{
                        y: [getData()],
                        x: [time],
                        type: 'line',
                        line: {color: '#3498db'}
                    }], layout, {displayModeBar: false, responsive: true});
                </script>


            </div>



            <div class="content-box p-auto shadow-sm">

                <div id="chart-memory" style="margin: 0px; padding: 0px;"></div>

                <script>


                    var layout = {
                        title: 'Memory Usage'
                    };

                    Plotly.plot('chart-memory', [{
                        y: [getData()],
                        x: [time],
                        type: 'line',
                        line: {color: '#3498db'}
                    }], layout, {displayModeBar: false, responsive: true});


                </script>


            </div>

            <div class="content-box p-auto shadow-sm">

                <div id="chart-connections" style="margin: 0px; padding: 0px;"></div>

                <script>

                    var layout = {
                        title: 'Connections Usage'
                    };

                    Plotly.plot('chart-connections', [{
                        y: [getData()],
                        x: [time],
                        type: 'line',
                        line: {color: '#3498db'}
                    }], layout, {displayModeBar: false, responsive: true});

                </script>


            </div>

            <div class="content-box p-auto shadow-sm" >

                <div id="chart-locking" style="margin: 0px; padding: 0px;"></div>

                <script>


                    var layout = {
                        title: 'Number of Locking Queries'
                    };

                    Plotly.plot('chart-locking', [{
                        y: [0],
                        x: [time],
                        type: 'line',
                        line: {color: '#3498db'}
                    }], layout, {displayModeBar: false, responsive: true});


                </script>


            </div>


        </div>





</div>





@endsection
