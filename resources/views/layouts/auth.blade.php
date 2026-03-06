<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NBER </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

      <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">

    <link href="{{ asset('css/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

  <link href="{{ asset('css/style1.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/twitter-bootstrap_3.3.6_css_bootstrap.min.css')}}" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    <style>
		.no-padding{
			padding:0;
			margin:0;
		}
		
	</style>
</head>
<body id="app-layout" >
  
	
<!-- ======= Start logo nav ======= -->

<section id="topbar" class="d-flex align-items-center">
    <div class="container-fluid d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
       
       
      </div>
      <!-- <div class="contact-info d-flex align-items-center" id="block-searchform" role="search">  
        <i class="d-flex align-items-center ms-2"> <h2 class="search">Search</h2>   </i>  
            <div class="content container-inline">       
                <form action="" method="get" id="search-block-form" accept-charset="UTF-8" class="search-form search-block-form">
                    <div class="js-form-item form-item js-form-type-search form-type-search js-form-item-keys form-item-keys form-no-label">
                    <label for="edit-keys" class="visually-hidden">Search</label>
                    <input title="Enter the terms you wish to search for." type="search" id="edit-keys" name="keys" value="" size="15" maxlength="128" class="form-search">
                    </div>
                </form>
            </div>
        </div> -->
      <div class="social-links d-none d-md-flex align-items-center">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-youtube"></i></a>
      </div>
    </div>
  </section>
  <header id="header-new" class="d-flex align-items-center">
    <div class="container">
        <div class="row">

      <div class="logo">
        <!-- <h1><a href="index.html">Eterna</a></h1> -->
        <!-- Uncomment below if you prefer to use an image logo -->
      <div class="col-md-2 brand-logo-left">
        <a href="index.html" class="rci_logo">
            <img src="{{ asset('images/nber_logo.png') }}" alt="" class="img-fluid ms-4" style="width:140px;">
          
        </a>
    </div>
    <div class="col-md-6">
          <span><h3 style="font-weight: 900; padding-top: 30px; margin-left: -47px;">National Board of Examination in Rehabilitation<br>(NBER)</h3></span>
    </div>
    <div class="col-md-3 brand-logo-right" style="padding-top: 30px;">
       
        <a href="index.html" class="header-logo">
            <img src="{{ asset('images/img/logo-new.jpg') }}" alt="" class="img-fluid" style="width:250px;">

        </a>
       </div>
      </div>

     </div>

    </div>
  </header><!-- End logo nav -->


  <!-- ======= Header ======= -->
  <header id="header" class="">
    <div class="container-fluid  justify-content-between">
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="active" href="https://rehabcouncil.nic.in/">Home</a></li>
             <li><a class="active" href="https://rehabcouncil.nic.in/">Examinations</a></li>
        <li><a class="active" href="https://rehabcouncil.nic.in/">Certifications</a></li>
         <li><a class="active" href="https://rehabcouncil.nic.in/">Circulars</a></li>
           <li><a class="active" href="https://rehabcouncil.nic.in/">Dispatch</a></li>
         <li><a class="active" href="https://rehabcouncil.nic.in/">Result</a></li>
           <li><a href="https://rehabcouncil.nic.in/">Contact Us</a></li>
         
          <li><a href="https://rehabcouncil.nic.in/">Student Login</a></li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
          @include('common.errorandmsg')

        	@yield('content')
   
    

    <!-- JavaScripts -->
    <script src="{{asset('js/2.2.3/jquery.min.js')}}" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
