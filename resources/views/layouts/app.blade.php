<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Library App</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Library App">
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
    @yield('css_js')
</head>
<body>
    <header class="site-header" role="banner">
    <!-- NAVBAR
    =================-->
    <div class="navbar-wrapper">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Library App</a>
                </div> <!-- navbar header -->
                <div class="navbar-collapse collapse">
 
                      <ul class="nav navbar-nav navbar-right">
                        @yield('topMenu')
                          @foreach ($menu as $key => $value)      
                            @if(array_key_exists('rights',$value))    
                              @php
                                  $roleAssigned = explode("|",$value['rights']);
                              @endphp
                              @foreach($roleAssigned as $singleRolekey => $singleRoleValue)
                                @if($singleRoleValue == strtolower($role))
                                  <li class="dropdown @if(array_key_exists('active',$value)) active @endif">
                                    <a href="{{strtolower($value['slug'])}}" @if(array_key_exists('sub_menu',$value)) class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"    @endif> <i class="{{$value['icon-class']}}"></i> {{$key}} @if(array_key_exists('sub_menu',$value))&nbsp;<i class="fa fa-caret-down submenu-icon"></i>   @endif </a> 
                                    @if(array_key_exists('sub_menu',$value))
                                      <ul class="dropdown-menu" role="menu">
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
                         @yield('topMenuEnd')
                        @if(Session::has('user_role')):
                          <li>
                            <a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
                            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                                {{csrf_field()}}
                            </form>
                          </li>
                        @else:
                          <li><a href="/login">Login</a></li>
                          <li><a href="/register">Register</a></li>
                        @endif
                      </ul>
                    
                    
                </div>
            </div> <!-- Container -->
        </div>  <!-- navbar -->  
     
    </div> <!-- NAVBAR-WRAPPER -->
</header>

            @yield('slider')

            @yield('body')

<!-- FOOTER
====================================== -->
        <footer>
            <div class="container-fluid">
                <div class="col-sm-3">
                    <p><a href="#">Library App</a> </p>
                </div> <!-- end col -->
                <div class="col-sm-6">
                    <nav>
                        <ul class="list-unstyled list-inline">
                        </ul>
                    </nav>
                </div> <!-- end col -->
                <div class="col-sm-3">
                    <p style="float:right;">&copy; 2020 - <?php echo date('Y'); ?> Ahmed Haseeb</p>
                </div> <!-- end col -->
            </div><!-- container -->
        </footer> 

<!-- BOOTSTRAP CORE JAVASCRIPT
Placed at the end of the document so the pages load faster
====================================== -->

<!-- BOOTSTRAP JS AND Custom JS
================== -->
<script src="/js/app.js"></script>
<script src="/js/main.js"></script>
<script src="/dt/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>

<script>
  $(document).ready(function() {
        $('table').DataTable({
            "pageLength": 10
        }); 
    } );
</script>
@yield('footer')
</body>
</html>