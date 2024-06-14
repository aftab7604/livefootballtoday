<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
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
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LHJQBS3DG2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-LHJQBS3DG2');

    </script>
    
    
    @php
    $hasPurchasedPlan = session('has_purchased_plan', false);
    @endphp
    @if (!$hasPurchasedPlan)
        <script data-ad-client="ca-pub-6504405400600762" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    @endif

    {{-- @include('PublicArea.includes.css') --}}
    @yield('css')
</head>

<body>

    {{-- @include('PublicArea.includes.main-nav') --}}
    <div class="cs_page">
        <header class="main__header">
            <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo__main" href="#">Football<br>today</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                menu <span class="navbar-toggler-icon"></span>
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
                    {{--  <li class="nav-item nav-cus">
                        <a class="nav-link active" href="{{url('plan')}}">Membership</a>
                    </li>  --}}
                    @if (Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.index')}}">Admin</a>
                    </li>
                    @endif
                </ul>
                <form action="{{route('public.search.all')}}"  method="GET" class="form-inline my-2 my-lg-0">
                    <input name="search" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" value="{{isset($search) && $search ? $search :''}}">
                    <button class="btn btn__main my-2 my-sm-0" type="submit">Search</button>
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
                        @php
                            $hasPurchasedPlan = session('has_purchased_plan', false);
                            @endphp
                            @if (!$hasPurchasedPlan)
                        <iframe scrolling='no' frameBorder='0'
                            style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;' width='160'
                            height='600'
                            src="https://track.10bet.com/I.ashx?btag=a_55784b_5945c_&affid=1681602&siteid=55784&adid=5945&c="></iframe>
                        <div class="my-2"></div>
                        <a target="_blank"
                            href="http://WLIncomeAccess.adsrv.eacdn.com/C.ashx?btag=a_39356b_18233c_&affid=7007172&siteid=39356&adid=18233&c=">
                            <img style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;'
                                width='160' height='600' src="{{asset('PublicArea/img/ad1.jpeg')}}">
                        </a>
                        <div class="my-2"></div>
                        <a target="_blank" href="https://www.begambleaware.org">
                            <img style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;'
                                width='100%' src="{{asset('PublicArea/img/ad2.jpeg')}}">
                        </a>
                        <div class="my-2"></div>
                        <iframe scrolling='no' frameBorder='0'
                            style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;' width='160'
                            height='600'
                            src="https://campaigns.williamhill.com/I.ashx?btag=a_197287b_328c_&affid=1741062&siteid=197287&adid=328&c="></iframe>
                        <div class="my-2"></div>
                        <a target="_blank" href="https://go.fansbetaffiliates.com/visit/?bta=655372&nci=5402">
                            <img style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;'
                                width='100%' src="{{asset('PublicArea/img/ad3.jpg')}}">
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
                        @php
                            $hasPurchasedPlan = session('has_purchased_plan', false);
                            @endphp
                            @if (!$hasPurchasedPlan)
                        <iframe scrolling='no' frameBorder='0'
                            style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;' width='160'
                            height='600'
                            src="https://track.10bet.com/I.ashx?btag=a_55784b_5944c_&affid=1681602&siteid=55784&adid=5944&c="></iframe>
                        <div class="my-2"></div>
                        <a target="_blank"
                            href="http://WLIncomeAccess.adsrv.eacdn.com/C.ashx?btag=a_39356b_18233c_&affid=7007172&siteid=39356&adid=18233&c=">
                            <img style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;'
                                width='160' height='600' src="{{asset('PublicArea/img/ad1.jpeg')}}">
                        </a>
                        <div class="my-2"></div>
                        <a target="_blank" href="https://www.begambleaware.org">
                            <img style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;'
                                width='100%' src="{{asset('PublicArea/img/ad2.jpeg')}}">
                        </a>
                        <div class="my-2"></div>
                        <iframe scrolling='no' frameBorder='0'
                            style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;' width='160'
                            height='600'
                            src="https://campaigns.williamhill.com/I.ashx?btag=a_197287b_328c_&affid=1741062&siteid=197287&adid=328&c="></iframe>
                        <div class="my-2"></div>
                        <a target="_blank" href="https://go.fansbetaffiliates.com/visit/?bta=655372&nci=5402">
                            <img style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;'
                                width='100%' src="{{asset('PublicArea/img/ad3.jpg')}}">
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
                <h2>Football <br> today</h2>
                <p>Know the past to know the<br> future, Bet today to win<br> tomorrow.</p>
            </div>
        </div>
        </footer>
    </div>

    @include('PublicArea.includes.js')

</body>

</html>
