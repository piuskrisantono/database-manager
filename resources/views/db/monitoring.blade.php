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
	var current_cpu;
	var current_memory;
	function getData(){
			        $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
		    var request = $.ajax({
		        url: "/getData",
		        type: "post",
		        data: { servicename: '{{$servicename}}'},
			dataType: 'json',
			async: false,
			headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			}
			
		    });
		
		    // Callback handler that will be called on success
		    request.done(function (response, textStatus, jqXHR){
		        // Log a message to the console
		        console.log("Hooray, it worked!" + response.cpu + response.memory);
			current_cpu = response.cpu;
			current_memory = response.memory;
		    });

		    // Callback handler that will be called on failure
		    request.fail(function (jqXHR, textStatus, errorThrown){
		        // Log the error to the console
		        console.error(
		            "The following error occurred: "+
		            textStatus, errorThrown
		        );
    		});
	}


    setInterval(function(){
	getData();
	var newNow = new Date();
	var new_three_minutes_ago = new Date();
	new_three_minutes_ago.setSeconds(three_minutes_ago.getSeconds() - 180);
	
            
	   Plotly.relayout('chart-cpu', {
                xaxis: {
                    range: [new_three_minutes_ago, newNow]
                }
            });

            Plotly.relayout('chart-memory', {
                xaxis: {
                    range: [new_three_minutes_ago, newNow]
                }
            });
	
        Plotly.extendTraces('chart-cpu', {y: [[current_cpu]], x: [[newNow]]}, [0]);

        Plotly.extendTraces('chart-memory', {y: [[current_memory]], x: [[newNow]]}, [0]);
	

    }, 6000);

</script>


<div class="py-4" style="margin: auto">

        <div class="d-flex justify-content-between mx-3 px-3 shadow-sm py-0 content-box" style="background-color: white; height: 50px; margin-bottom: 10px;">
                <div class="title-tab my-auto" style="font-size: 20px; overflow:hidden">
                    Performance Monitor of {{$servicename}}
                </div>
        </div>

        <div class="mx-3" style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 15px; grid-row-gap: 15px;">


            <div  class="content-box p-auto shadow-sm " >
		<div id="chart-cpu-container">
                	<div id="chart-cpu" style="margin: 0px; padding: 0px;"></div>
		</div>
                <script>
                        var now = new Date();
                        var three_minutes_ago = new Date();
			three_minutes_ago.setSeconds(now.getSeconds() - 180); // timestamp
                        three_minutes_ago = new Date(three_minutes_ago); // Date object
			var timer = new Date(three_minutes_ago);

			var array_time = [];

	               @while ($row = pg_fetch_row($stat))
			array_time.push(timer);
			timer.setSeconds(timer.getSeconds() + 6); // timestamp
                        timer = new Date(timer); // Date object
                       @endwhile

                    var layout = {
                        title: 'CPU Usage',
  			yaxis: {
			    range: [0, 1],
			    autorange: false
  			},
                        xaxis: {
                                range: [ three_minutes_ago, now],
                                autorange: false
                        }
                    };

                    Plotly.plot('chart-cpu', [{
			
                        @php
                                pg_result_seek($stat, 0);
                        @endphp
			y: [
				@while($row = pg_fetch_row($stat))
					{{$row[1]}},
				
				@endwhile
			],

			@php
				pg_result_seek($stat, 0);
			@endphp
                        x: array_time,
                        type: 'line',
                        line: {color: '#3498db'}
                    }], layout, {displayModeBar: false, responsive: true});
		
		
                </script>


            </div>



            <div class="content-box p-auto shadow-sm">

                <div id="chart-memory" style="margin: 0px; padding: 0px;"></div>

                <script>
                    var layout = {
                        title: 'Memory Usage',
			yaxis: {
                            range: [0, 1],
                            autorange: false
                        },
	                @php
                                pg_result_seek($stat, 0);
                        @endphp
			xaxis: {
				range: [ three_minutes_ago, now],
				autorange: false
			}
                    };

                    Plotly.plot('chart-memory', [{
			 @php
                                pg_result_seek($stat, 0);
                        @endphp
                        y: [
				@while($row = pg_fetch_row($stat))
                                        {{$row[2]}},

                                @endwhile
			],
			 @php
                                pg_result_seek($stat, 0);
                        @endphp
                        x: array_time,
                        type: 'line',
                        line: {color: '#3498db'}
                    }], layout, {displayModeBar: false, responsive: true});


                </script>


            </div>


        </div>





</div>


<script>
/*
$(document).ready(function() {


	setInterval(function(){
    
	   $("#chart-cpu-container" ).load("testing");

	}, 3000);


});
*/
</script>


@endsection
