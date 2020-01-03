<div id="notif-div" class="flex-column align-items-center" style="position: absolute;z-index:10; min-width:100%;padding-left:250px; display:none">
@if(count($errors) > 0)
        <div class="alert alert-danger">
            {{$errors->first()}}
        </div>
@endif


@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif
</div>


<script>
    function tutup() {
        $('#notif-div').slideToggle();
    }

    $(document).ready(function(){
        $('#notif-div').show();
        setTimeout(tutup, 5000);
    })

</script>
