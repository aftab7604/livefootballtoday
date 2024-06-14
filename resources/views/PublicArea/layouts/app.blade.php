<?php
if (session('paymentDetailSession')) {
    $userPlanObject = session('paymentDetailSession');
    $userObject = session('userSession');
    $userId = $userObject->id;
    //print_r($userPlanObject);
    if ($userPlanObject && isset($userPlanObject[0]->user_id)) {
        if ($userId == $userPlanObject[0]->user_id) {
        $hasPurchasedPlanss = $userPlanObject[0]->user_id;
        }else{
            $hasPurchasedPlanss = '';
        }
    }else{
        $hasPurchasedPlanss = '';
    }
}else{
    $hasPurchasedPlanss = '';
}

?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    
<meta mame="allow-ads" value="{{$hasPurchasedPlanss}}">
@if ($hasPurchasedPlanss == '') 
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LL18QY1T1H"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LL18QY1T1H');
</script>
@endif
<meta name="google-site-verification" content="76V_pCroNrzQWRC_ktFgn_a96U5iB1diuCMugFEVh1Q" />
@if ($hasPurchasedPlanss == '') 
 <meta name="google-adsense-account" content="ca-pub-6504405400600762"><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
@endif
     
<meta name="csrf-token" content="{{ csrf_token() }}">
    
 <style>
 
 .heading-mobile
 {
     margin-left:6em!important;
 }
 
 @media (min-width: 320px) and (max-width: 767px) {
  
   .heading-mobile
 {
     margin-left:inherit!important;
 }
  
}
 </style>
    
    <?php
$uri = $_SERVER['REQUEST_URI'];
if($uri=='/' || $uri=='/index.php')
{
	?>
<title>Football Match Live Scores & Predictions | Live Football Today</title>
<meta name="description" content="Stay updated with online football updates, match predictions, results, European & international scores, and club profiles, at Live Football Today. Explore now!">
	<?php
}
	elseif($uri == "/leagues")
	{
	?>
	<title>Football Tables and League | Champions League Matches | Live Football Today</title>
	<meta name="description" content="Football Tables and Leagues, Champions League Matches, and more at Live Football Today. Dive into stats for devoted fans, aspiring analysts, and fantasy football enthusiasts.">
	<?php
	}
else
{
    ?>
       <title>@yield('title')</title>
        <meta name="description" content="@yield('meta_desc')">
    <?php
}
?>
    <link rel="canonical" href="{{ url()->current() }}" />
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('favicons/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('favicons/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('favicons/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('favicons/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('favicons/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('favicons/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('favicons/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('favicons/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicons/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('favicons/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('favicons/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('favicons/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('favicons/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    {{-- Keywords metatag --}}
    <meta name="keywords" content="Live football, Football scores, Football results, live football scores, todays scores, todays football
        scores, Yesturdays football scores, Tomorrow fixtures, tomorrow football fixtures, todays football fixtures,
        football fixtures, Football tables, football standings, Stats, team stats, players stats, EPL Results, football
        teams, football clubs, live soccer, Football today, todays football, latest football scores, tonights football,
        premier league result, premier league fixtures, Championship fixtures, Championship scores, league 1 fixtures,
        league 1 scores, league 2 fixtures, league 2 scores, Ligue 1 fixtures, ligue 1 scores, ligue 2 fixtures, ligue 2
        scores, budesliga scores, budesliga fixtures, Liga BBVA scores, Liga BBVA fixtures, Serie A scores, Serie A
        fixtures, Serie B scores, Serie B Fixtures, Eredivisie scores, Eredivisie fixtures, MLS Scores, MLS Fixtures,
        Scottish Premier league scores, Scottish premier league fixtures, Belgium first division scores, Belgium first
        divisions fixtures, Swiss super league scores, Swiss super league fixtures" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    @if ($hasPurchasedPlanss == '') 
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762" crossorigin="anonymous"></script>
    @endif
    @if ($hasPurchasedPlanss == '') 
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-LHJQBS3DG2');

    </script>
    @endif
 
    @if ($hasPurchasedPlanss == '') 
        <script data-ad-client="ca-pub-6504405400600762" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    @endif

    {{-- @include('PublicArea.includes.css') --}}
    @yield('css')
    <style>

        .evnt_endpoint table tbody tr td.text-left{
            background: aliceblue;
            font-size:18px;
        }

        .evnt_endpoint table tbody tr td.text-right{
            background: #f3dad3;
            font-size:18px; 
            border-bottom: 1px solid #fff;
        }

        body{
            background-color: #EBEBEB !important;
        }
    .logo__main{
        transform: scale(1.2);
    }
         @media only screen and (max-width:992px){
            li a.bg-danger{
                width: max-content;
                padding: 10px !important;
                margin-bottom: 20px;
                margin-left: 0 !important;
            }

            #navbarSupportedContent{
                border: 1px solid #8a5afc06;
                background: #fff !important;
                box-shadow: 0px -4px 15px 0px rgba(0,0,0,0.15);
                margin-top: 1rem;
                margin-bottom: 1rem;
                padding: 15px 0;
            }
            
            #navbarSupportedContent li.nav-item a{
                border-bottom: 1px solid #e5e6eb !important;
                padding:17px !important;
            }

            #navbarSupportedContent li.nav-item a:hover{
            background: gainsboro !important;
            }

            #navbarSupportedContent li.nav-item a.btn-danger{
                margin: 0 !important;
                background: transparent;
                color: #000 !important;
                text-align: left !important;
            }

            form.form-inline{
                margin-top: 2rem !important;
                padding: 0 20px;
            }

            .main__header nav {
            padding: 0 !important;
            }

        }

        .probs-table{
            width: 100%;
            background: #000;
            color: #fff;
            font-size: 13px;
        }

        .main__header{
            border: 1px solid #8a5afc06;
            background: #fff !important;
            box-shadow: 0px 10px 15px 0px rgba(0,0,0,0.15);
        }

        .main__header nav{
            padding: 0.3rem 1rem !important;
        }

        .main__header .nav-item a{
            color: #000 !important;
        }

        .main__header .nav-item a{
            border-bottom: 3px solid #fff;
        }

        .main__header .nav-item a:hover{
            border-bottom: 3px solid #bd2130;
        }

        .main__header .nav-item a.btn.btn-danger{
            color: #fff !important;
            border: none !important; 
        }

        input:focus,a:focus,button:focus,
        input:focus-visible,a:focus-visible,button:focus-visible{
            box-shadow: none !important;
            outline: none !important;
        }

        @media only screen and (min-width:767px){
            
            .matchbtn{
                display: flex;
                align-items: center;
            }

            .probs-table{
                max-width: 200px;
            }

            .probs-table th, .probs-table td{
                padding: 0px 12px;
            }
 
        } 

        @media only screen and (max-width:767px){

            .evnt_endpoint table tbody tr td.text-left{
            font-size: 15px !important;
        }

        .evnt_endpoint table tbody tr td.text-right{
            font-size: 15px !important; 
        }
        form.form-inline input{
                width: 100% !important;
                margin-bottom: 1rem;
            }

            form.form-inline button{
                width: 100%;
            }

            .main__header nav {
  padding: 0.3rem 1rem 2rem !important;
}

    }

        @media only screen and (min-width:993px) and (max-width:1150px){

            .main__header nav {
  padding:7px 0 !important;
}

.logo__main{
    font-size: 14px !important;
  margin-right: 25px !important;
  padding: 30px 20px !important;
}

.main__header .nav-item a{
    font-size: 14px !important; 
}
        }
    </style>
</head>

<body>

    {{-- @include('PublicArea.includes.main-nav') --}}
    <div class="cs_page">
        <header class="main__header">
            <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo__main" href="{{url('/')}}">Live Football Today</a>
            <button class="navbar-toggler text-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fas fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('public.fixtures')}}">Fixtures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('public.leagues')}}">Leagues</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('public.articles.all')}}">Articles</a>
                    </li>
                    
                    @if (!session('userSession')) 
                        <li class="nav-item nav-cus">
                            <a class="nav-link active btn btn-danger px-4 ml-3" href="{{url('user-account')}}">Login</a>
                        </li>
                    @else
                        <li class="nav-item nav-cus">
                            <a class="nav-link active btn btn-danger px-4 ml-3" href="{{url('user-logout')}}">Logout</a>
                        </li>
                     @endif
                    @if (Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.index')}}">Admin</a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav ml-auto">
                     @php
                        $hasPurchasedPlan = session('has_purchased_plan', false);
                        $hasPurchasedPlaned = session('has_purchased_planed_user', false);
                    @endphp
                    {{-- @if($hasPurchasedPlan || $hasPurchasedPlaned)
                    <li class="nav-item float-right">
                        <a class="nav-link btn btn-danger px-4 mr-2" href="{{url('card-detail')}}">Profile</a>
                    </li>
                    @endif  --}}
                    @if(session('userSession'))
                    <li class="nav-item float-right">
                        <a class="nav-link btn btn-danger px-4 mr-2" href="{{url('user-profile')}}">Profile</a>
                    </li>
                    @endif
                </ul>
                <form action="{{route('public.search.all')}}"  method="GET" class="form-inline my-2 my-lg-0">
                    <input name="search" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" value="{{isset($search) && $search ? $search :''}}">
                    <button class="btn btn__main my-2 my-sm-0 px-4" type="submit" style="font-weight: 700;font-size: 18px;">Search</button>
                </form>
            </div>
            </nav>
        </header>

        <section>
            <div class="container-fluid text-center mt-2">
                <div class="row content">
                    <div class="col-lg-2 sidenav d-none d-lg-block">
                        {{-- <p><a href="#">Link</a></p>
                        <p><a href="#">Link</a></p>
                        <p><a href="#">Link</a></p> --}}
                            @if ($hasPurchasedPlanss == '')
                            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebars -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="2333597170"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6185228187"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
                        
                        
                        </a>
                        @endif
                    </div>
                    <div class="col-md-12 col-lg-8 mx-0 px-0">
                        {{-- @include('PublicArea.includes.nav') --}}
                        @yield('content')
                    </div>
                    <div class="col-lg-2 sidenav d-none d-lg-block">
                        {{-- <div class="well">
                            <p>ADS</p>
                        </div>
                        <div class="well">
                            <p>ADS</p>
                        </div> --}}
                            @if ($hasPurchasedPlanss == '')
                       <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebars -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="2333597170"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6185228187"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- sidebar 2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="6939906659"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
                        
                       
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        
        
                                                        
                                


        {{-- @include('PublicArea.includes.footer') --}}
        <footer>
        <div class="container">
            <div class="social__media">
                <div class="icon_text_social">
                    <div class="icon-social">
                    <a href="#"><img src="{{ asset('assets/images/facebook.png') }}" alt="Facebook" /></a>
                    </div>
                    <p>Facebook</p>
                </div>
                <div class="icon_text_social">
                    <div class="icon-social">
                    <a href="#"><img src="{{ asset('assets/images/instagram.png') }}" alt="Instagram" /></a>
                    </div>
                    <p>Instagram</p>
                </div>
                <div class="icon_text_social">
                    <div class="icon-social">
                    <a href="#"><img src="{{ asset('assets/images/twitter.png') }}" alt="twitter" /></a>
                    </div>
                    <p>X</p>
                </div>
                <div class="icon_text_social">
                    <div class="icon-social">
                    <a href="#"><img src="{{ asset('assets/images/share.png') }}" alt="share" /></a>
                    </div>
                    <p>Email</p>
                </div>
            </div>
            <div class="footer_text">
                <h2>LiveFootballToday
                <p>Whether<br> you are a dedicated fan, aspiring analyst, or a fantasy football enthusiast,<br> we have the stats for you.</p>
                We offer ads free mode for just £1 a month or £10.00 a year with access to premium articles and betting tips.
            </div>
        </div>
        </footer>
    </div>

    @include('PublicArea.includes.js')

</body>

</html>
