@extends('PublicArea.layouts.app')
@section('title')
Live Football Today | Profile
@endsection
@section('content')
    <?php
    if (Session::has('fcm_token')) {
        echo Session::get('fcm_token');
    }
    ?>
    {{--  plan code   --}}
    <div class="plan-container">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success w-100 confirm_msgs">{{ session('success') }}</div>
            @endif
            @if (session('failure'))
            <div class="alert alert-danger w-100 confirm_msgs">{{ session('failure') }}</div>
        @endif
            <div class="row justify-content-center">
                <div class="plan-head">
                    <h2>Your Card Details<br>Here...</h2>
                    <p></p>
                </div>
                <div class="col-md-12 col-sm-12 d-flex pricingTable">
                    <div class="w-100">
                        <div class="pricingTable-header">
                            <div class="price-value">
                                @if(isset($paymentDetails[0]))
                                    <h3 class="title mb-3"><strong>Card Name: </strong>{{ isset($paymentDetails[0]->card_name) ? $paymentDetails[0]->card_name : 'Free membership' }}
                                    </h3>
                                    <h5><span class="amount"><strong>Name: </strong><span style="text-transform: capitalize;color: #c0c5c9 !important;">{{ $paymentDetails[0]->first_name }} {{ $paymentDetails[0]->last_name }}</span></span></h5>
                                    <h5><span class="amount"><strong>Email: </strong><span style="text-transform: lowercase;color: #c0c5c9 !important;">{{ $paymentDetails[0]->email }}</span></span></h5>
                                    <h5><span class="amount"><strong>Package Duration: </strong><span style="text-transform: capitalize;color: #c0c5c9 !important;">{{ $paymentDetails[0]->plan_package }}</span></span></h5>
                                    <div class="pricingTable-signup">
                                        <p>Are you want to cancel Membership? Click Here</p>
                                        <a href="{{ url('/cancel-membership')}}/{{ $paymentDetails[0]->id }}">Delete</a>
                                    </div>
                                @else
                                    <p>No payment details found!</p>
                                    <p><strong style="color: #eed71a;">NOTE: </strong>Please purchase the membership for ads free, betting tips and to view our articles.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('PublicArea/calendar/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('PublicArea/calendar/css/theme.css') }}">
    <style>

        .alert{
            padding: 20px;
            transform: scale(1);
            list-style: none;
            font-family: Montserrat Alternates;
            font-size: 22px;
            font-weight: 700;
        }
        .plan-head {
            width: 100%;
            text-align: center;
            float: left;
            margin-top: 50px;
        }

        .plan-head h2 {
            font-size: 44px;
            font-weight: 700;
            padding: 10px 0;
        }

        .plan-head p {
            font-size: 25px;
            font-weight: 500;
            margin-bottom: 40px;
        }

        a {
            text-decoration: none !important;
        }

        li{
            list-style: none !important;
        }

        .pricingTable {
            color: #fff;
            box-shadow: 1px 1px 2px 1px #1e0e52;
            font-family: 'Signika Negative', sans-serif;
            text-align: left;
            padding: 40px 65px;
            background: #1e0e52;
            margin-bottom: 50px;
        }

        .pricingTable .pricing-content p{
            margin: 0 !important;
        }

        .pricingTable .pricingTable-header {
            margin: 0 0 20px;
        }

        .pricingTable .price-value {
            margin: 0 0 15px;
        }

        .pricingTable_main{
            width: 100%;
            float: left;
        }

        .pricingTable .price-value .amount {
            font-size: 28px;
            font-weight: 400 !important;
            line-height: 50px;
        }

        .pricingTable .price-value .duration {
            font-size: 20px;
            font-weight: 400;
            text-transform: capitalize;
        }

        .pricingTable .title {
            background: #FFD23F;
            color: #000;
            font-size: 28px;
            font-weight: 500 !important;
            text-transform: uppercase;
            padding: 15px;
            text-transform: uppercase;
            margin: 0;
            width: 100%;
            float: left;
        }

        .pricingTable .pricing-content {
            text-align: left;
            padding: 0;
            margin: 0 0 20px;
            list-style: none;
            display: inline-block;
        }

        .pricingTable .pricing-content li {
            font-size: 18px;
            font-weight: 500;
            line-height: 40px;
            letter-spacing: .5px;
            padding: 0 15px 0 25px;
            margin: 0 0 5px;
            position: relative;
        }

        .pricingTable .pricing-content li:last-child {
            margin: 0;
        }

        .pricingTable .pricing-content li:before {
            content: "\f00c";
            color: #2a8317;
            font-family: "Font Awesome 5 Free";
            font-size: 16px;
            font-weight: 900;
            text-align: center;
            position: absolute;
            top: 1px;
            left: 0;
        }

        .pricingTable .pricing-content li.disable:before {
            content: "\f00d";
            color: #f32e30;
        }

        .pricingTable .pricingTable-signup a {
            background: red;
            color: #fff;
            font-size: 23px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 7px 20px 5px;
            border-radius: 50px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .pricingTable-signup p{
            font-size: 20px;
           color: red;
        }

        .pricingTable .pricingTable-signup a:hover {
            text-shadow: 3px 3px 3px rgba(0, 0, 0, 0.5);
        }

        .pricingTable.green .title,
        .pricingTable.green .pricingTable-signup a {
            background: #FFD23F;
            color: #000;
        }

        .pricingTable.blue .title,
        .pricingTable.blue .pricingTable-signup a {
            background: #FFD23F;
            color: #000;
        }

        @media only screen and (max-width: 1300px) {
            .pricingTable {
                margin: 0 0 40px;
            }

            .col-md-4 {
                max-width: 100%;
                flex: 100%;
            }
        }
    </style>
@endsection

<script>
    setTimeout(function() {
        $('.confirm_msgs').fadeOut();
    }, 5000);
    </script>
