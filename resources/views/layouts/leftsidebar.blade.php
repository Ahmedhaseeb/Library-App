<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | School Management System</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="School Management System">
    <meta name="author" content="Ahmed Haseeb">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS
    ==================-->
    <link href="/dt/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="/css/app.css" rel="stylesheet" />
    <!-- Font-awesome -->
    <link href="/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- custom-css -->
    <link href="/css/custom.css" rel="stylesheet" />



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->        
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/js/app.js"></script>
    @yield('css_js')
</head>
<body>
    <div id="wrapper"  class="wrapper container">
        <header class="site-header" role="banner">
        <!-- NAVBAR
        =================-->
        <div class="navbar-wrapper">
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/">School Management System</a>
                    </div> <!-- navbar header -->
                    <div class="navbar-collapse collapse">
                        <ul id="userDetail" class="nav navbar-nav navbar-right">
                            <li><?php if(!Auth::guest()){
                                echo '<a href="#" class="">Welcome '.Auth::user()->name.'</a>';

                            } ?></li>

                            <li>
                                <a href="#" class="">@yield('employee_name')</a>
                            </li>
                            <li id='logout' data-title="Logout"><a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a></li>
                                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>

                        </ul>
                    </div>
                    <div class="navbar-collapse navbar-ex1-collapse collapse">
                        <ul class="nav navbar-nav side-nav">
                            <?php 
                                if( Session::has('role')){ $role = Session::get('role'); }
                                //$user = new App\Http\Controllers\userController;
                            
                            ?>
                            @yield('leftMenu')
                                @foreach ($menu as $key => $value)      
                                    @if(array_key_exists('rights',$value))
                                     
                                    @php
                                        $roleAssigned = explode("|",$value['rights']);
                                    @endphp
                                        @foreach($roleAssigned as $singleRolekey => $singleRoleValue)
                                            @if($singleRoleValue == strtolower($role))
                                                <li class="dropdown @if(array_key_exists('active',$value)) active open @endif">
                                                    <a href="{{strtolower($value['slug'])}}" @if(array_key_exists('sub_menu',$value)) class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"    @endif><i class="{{$value['icon-class']}}"></i> {{$key}} @if(array_key_exists('sub_menu',$value))  <i class="fa fa-caret-down submenu-icon"></i>   @endif </a> 
                                                    @if(array_key_exists('sub_menu',$value))
                                                        <ul class="dropdown-menu dm-akpk" role="menu">
                                                            @foreach ($value['sub_menu'] as $submenu_key => $submenu_value)
                                                                @if(array_key_exists('rights',$submenu_value))
                                                                    @php
                                                                        $submenuRoleAssigned = explode("|",$submenu_value['rights']);
                                                                    @endphp
                                                                        @foreach($submenuRoleAssigned as $submenuSingleRolekey => $submenuSingleRoleValue)
                                                                            @if($submenuSingleRoleValue == strtolower($role))
                                                                                <li @if(array_key_exists('active', $submenu_value)) class="active" @endif>
                                                                                    <a href="{{strtolower($submenu_value['slug'])}}">{{$submenu_key}}</a>
                                                                                </li> 
                                                                            @endif
                                                                        @endforeach 
                                                                @endif                             
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                             @yield('leftMenuEnd')
                        </ul>
                    </div>    
                </div> <!-- Container -->
            </div>  <!-- navbar -->  
         
        </div> <!-- NAVBAR-WRAPPER -->
    </header>
            

    <section id="main-content">
        <div class="container-fluid">
           
            @yield('body')
               
        </div>
    </section>







<!-- FOOTER
====================================== -->
    <footer>
        <div class="container-fluid">
            <div class="col-sm-3">
                <p><a href="#">School Management System</a> </p>
            </div> <!-- end col -->
            <div class="col-sm-6">
                <nav>
                    <ul class="list-unstyled list-inline">
                        
                    </ul>
                </nav>
            </div> <!-- end col -->
            <div class="col-sm-3">
                <p style="float:right;">&copy; 2016 - <?php echo date('Y'); ?> Ahmed Haseeb</p>
            </div> <!-- end col -->
        </div><!-- container -->
    </footer> 
@if(!(Session::has('role')))
<!-- MODAL
====================================== -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">                       
                        Login   <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div> <!-- modal-header -->
                    
                    <div class="modal-body">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">

                                        <div class="panel-body">
                                            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                                {{ csrf_field() }}

                                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                                    <div class="col-md-6">
                                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                    <label for="password" class="col-md-4 control-label">Password</label>

                                                    <div class="col-md-6">
                                                        <input id="password" type="password" class="form-control" name="password" required>

                                                        @if ($errors->has('password'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-4">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-8 col-md-offset-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            Login
                                                        </button>

                                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                                            Forgot Your Password?
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- modal-body -->
                </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->

        </div> <!-- modal -->

@endif

<div class="modal fade" id="optin-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope"></i> Subscribe to our Mailing List</h4>
            </div> <!-- modal-header -->
            
            <div class="modal-body">
                <p>Simply enter your name and email! As a thank you for joining us, we're going to give you one of the our best-selling courses, <em>for free!</em> </p>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label class="sr-only" for="subscribe-name">Your first name</label>
                        <input type ="text" class="form-control" id="subscribe-name" placeholder="Your first name">
                    </div> <!-- form-group -->
                    <div class="form-group">
                        <label class="sr-only" for="subscribe-name"> and your email</label>
                        <input type ="text" class="form-control" id="subscribe-email" placeholder="and your email">
                    </div> <!-- form-group -->
                    <input type="submit" class="btn btn-danger" value="Subscribe!">
                </form>

            </div> <!-- modal-body -->
        </div> <!-- modal-content -->
    </div> <!-- modal-dialog -->

</div> <!-- modal -->

<!-- BOOTSTRAP CORE JAVASCRIPT
Placed at the end of the document so the pages load faster
====================================== -->

<!-- BOOTSTRAP JS AND Custom JS
================== -->
<script src="/js/main.js"></script>
<script src="/dt/js/jquery.dataTables.min.js"></script>
<script src="/scrollbar/dist/jquery.nicescroll.min.js"></script>
<style>
	.nicescroll-rails{
		left:228px;
	}
</style>
<script>
    $(document).ready(
    function() {
        $(".side-nav").niceScroll({
            cursorcolor:        "#ccc",
            cursorborderradius: "0", 
            cursorwidth:        "12px",
            cursorborder:       "0px solid #000",
            scrollspeed:        60,
            autohidemode:       false,
            background:         '#ddd',
            hidecursordelay:    400,
            cursorfixedheight:  false,
            cursorminheight:    20,
            enablekeyboard:     true,
            horizrailenabled:   true,
            bouncescroll:       false,
            smoothscroll:       true,
            iframeautoresize:   true,
            touchbehavior:      false,
            zindex: 1035
        });
       
         /*
            $("body").niceScroll({
                cursorcolor:        "#ccc",
                cursorborderradius: "0", 
                cursorwidth:        "12px",
                cursorborder:       "0px solid #000",
                scrollspeed:        60,
                autohidemode:       false,
                background:         '#ddd',
                hidecursordelay:    400,
                cursorfixedheight:  false,
                cursorminheight:    20,
                enablekeyboard:     true,
                horizrailenabled:   true,
                bouncescroll:       false,
                smoothscroll:       true,
                iframeautoresize:   true,
                touchbehavior:      false,
                zindex: 1035
            });
        */
    }
);
    $(document).ready(function() {
        $('table').DataTable({
            "pageLength": 10
        }); 
    } );

</script>
@yield('footer')
</div>
</body>
</html>

