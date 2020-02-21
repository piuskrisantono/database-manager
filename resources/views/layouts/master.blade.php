<!DOCTYPE html>
<html>
<head>
    <title>Database Manager</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style type="text/css">

.sidenav {
  width: 250px;
  position: fixed;
  z-index: 5;
  left: 0;
  overflow-x: hidden;
  transition: 0.5s;
  background-color: #2c3e50;
  color: #ecf0f1;
  border-right: 1px solid lightgrey;
}


.sidenav > a {
  text-decoration: none;
  color: #ecf0f1;
  transition: padding 0.3s;
  display: grid;
  grid-template-columns: 30px 1fr;
    padding: 20px 20px 20px 30px;
    grid-column-gap: 15px;
    align-items: center;
}


.dropdown-inside {
    background-color: #253342;
    padding: 20px 20px 20px 50px;
}


#app {
  transition: padding-left .5s;
  padding-left: 250px;
}




@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}


.content-box {
  background-color: white;
  border-radius: 5px;
}

#app-content{
    transition: 0.5s;
}

a:hover {
    cursor: pointer;
}

#mySidenav .active, .sidenav > a:hover {
    color: white;
    border-right: 5px solid white;
    font-weight: 600;
    background-color: #34495e;
}

#no-hover:hover {
    border-right: none;
    font-weight: normal;
    color: #ecf0f1;
    background-color: #2c3e50;
    cursor: default;
}

.content{
        background-color: white;
        border-radius: 5px;
        min-height: 50px;
        padding: 15px;
        /* -webkit-box-shadow: 0 3px 5px 1px #ccc;
        -moz-box-shadow:    0 3px 5px 1px #ccc;
        box-shadow:         0 3px 5px 1px #ccc; */
    }

</style>



<body >
@include('layouts.messages')


 <div id="mySidenav" class="sidenav vh-100 shadow-sm">
        <div style="display: grid; justify-items: end; padding: 0 20px;">
             <span onclick="closeNav()" style="font-size: 30px; cursor: pointer;">&times;</span>
        </div>


      <div style="display: grid; grid-template-columns; 1fr; justify-content: center; align-items: center; width: 250px; grid-row-gap: 15px; margin-bottom: 20px;">

             <div style="display: grid; justify-content: center;">

                    <div  style="width: 8vw; height: 8vw;  border-radius: 4vw;background-repeat: no-repeat; background-image: url({{ asset('img/avatar/'.Auth::user()->avatar.'.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;">
                    </div>

             </div>

                <div>
                <h5 style="font-weight: 600">{{ Auth::user()->username }}</h5>
                </div>
      </div>

  <a href="/dbrequest/installed"  class="{{ (Request::getRequestUri() == '/dbrequest/installed') ? 'active' : '' }} {{ (Request::getRequestUri() == '/') ? 'active' : '' }}">
      <i class="fa fa-database" style="{{ (Request::getRequestUri() ==  '/dbrequest/installed') ? 'color: white;font-weight: 600' : '' }}"></i>
      <span style="{{ (Request::getRequestUri() == '/dbrequest/installed') ? 'color: white;font-weight: 600' : '' }}">Instances</span>
  </a>
  <a id="no-hover">
    <i class="fa fa-plus"></i>
    <span>Create</span>

  <a href="/dbrequest" class="{{ (Request::getRequestUri() =='/dbrequest') ? 'active' : '' }} dropdown-inside" style="padding-left:75px;">
    <i class="fa fa-envelope" style="{{ (Request::getRequestUri() =='/dbrequest') ? 'color: white;font-weight: 600' : '' }}"></i>
    <span style="{{ (Request::getRequestUri() =='/dbrequest') ? 'color: white;font-weight: 600' : '' }}">Request</span>
  </a>
</a>
<a href="/viewInstaller" class="{{ (Request::getRequestUri() =='/viewInstaller') ? 'active' : '' }} dropdown-inside" style="padding-left:75px;">
  <i class="fa fa-play" style="{{ (Request::getRequestUri() =='/viewInstaller') ? 'color: white;font-weight: 600' : '' }}"></i>
  <span style="{{ (Request::getRequestUri() =='/viewInstaller') ? 'color: white;font-weight: 600' : '' }}">Install</span>
</a>
  <a href="/user" class="{{ (Request::getRequestUri() =='/user') ? 'active' : '' }}">
    <i class="fa fa-user" style="{{ (Request::getRequestUri() =='/user') ? 'color: white;font-weight: 600' : '' }}"></i>
    <span style="{{ (Request::getRequestUri() =='/user') ? 'color: white;font-weight: 600' : '' }}">Manage Users</span>
  </a>
  <a href="/history" class="{{ (Request::getRequestUri() =='/history') ? 'active' : '' }}">
    <i class="fa fa-clock" style="{{ (Request::getRequestUri() =='/history') ? 'color: white;font-weight: 600' : '' }}"></i>
    <span style="{{ (Request::getRequestUri() =='/history') ? 'color: white;font-weight: 600' : '' }}">History</span>
  </a>
  <a
  onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
    <i class="fa fa-sign-out-alt"></i>
    <span>Sign-out</span>
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
</div>

<!-- Use any element to open the sidenav -->
<div class="py-4" style="z-index:3;position: fixed; margin-left: 100px;">
    <button type="button" class="btn btn-light my-3 shadow-sm" onclick="openNav()" style="background-color: white; height: 50px; width: 50px;">
        <div class="fas fa-tasks fa" style="font-size: 20px;"></div>
    </button>
</div>


<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->


<div id="app" style="min-height: 100vh; min-width: 100%; background-color: #ecf0f1;">
    <div id="app-content" class="pt-3" style="padding-left: 100px; padding-right:100px; width:100%;">
            @yield('content')
    </div>

</div>



</body>
</html>

<script type="text/javascript">

$(function () {
  $('[data-toggle="popover"]').popover({
  trigger: 'hover',
  placement: 'top',
  delay: { "show": 500, "hide": 200 },
  template: '<div style="font-size: 16px;" class="popover" role="tooltip"><div class="arrow"></div><div class="popover-body"></div></div>'
})
})

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("app").style.paddingLeft = "250px";
  document.getElementById("app-content").style.paddingLeft = "100px";
  document.getElementById("app-content").style.paddingRight = "100px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("app").style.paddingLeft = "0";
  document.getElementById("app-content").style.paddingLeft = "150px";
  document.getElementById("app-content").style.paddingRight = "150px";
}
</script>
