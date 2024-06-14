@extends('PublicArea.layouts.app')
@section('title')
Live Football Today | Paypal
@endsection
@section('content')
    <?php
    if (Session::has('fcm_token')) {
        echo Session::get('fcm_token');
    }
    ?>
    <script src="https://js.stripe.com/v3/"></script>
    {{-- <body> --}}
    <?php
    // Check if the button is clicked
    if (isset($_POST['policyButton'])) {
        // Handle policy button click logic here
        echo 'Policy button clicked!';
        // You can redirect to the policy page or perform any other action
    }
    ?>
    <!-- Button trigger modal -->
    <p class="modal-p modalp">
        By clicking the button, you agree to our <a data-toggle="modal" data-target="#exampleModal"
            style="color: #007bff;
    text-decoration: none;">policy</a>.
    </p>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Our Policy</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-p">
                        Effective Date: <?php echo date('Y-m-d'); ?>
                        Thank you for choosing to become a member of <a href="livefootballtoday.co.uk"
                            target="_blank">livefootballtoday.co.uk</a> To ensure a seamless and secure experience,</p>
                    <h6> please review our payment policy outlined below:</h6>
                    <h3>Membership Fees:</h3>
                    <p class="modal-p">Membership fees are £10.00 a year or £1.00 a month and are subject to change with
                        prior notice.
                        The membership period begins upon successful payment and extends for a year or month from the date
                        of payment, depending which plan you have chosen.</p>
                    <h3>Payment Methods:</h3>
                    <p class="modal-p">We accept payments through debit/credit cards. If you can’t do this, contact us to
                        see if we can offer an alternative to you.
                        All transactions are processed securely.</p>
                    <h3>Automatic Renewal:</h3>
                    <p class="modal-p">Memberships are set to automatically renew
                        You will be notified before the automatic renewal, allowing you to cancel if you want to. Please
                        cancel the membership if you don’t want automatic renewal.</p>
                    <h3>Cancellation and Refunds:</h3>
                    <p class="modal-p">You may cancel your membership at any time by accessing your account settings.
                        Refunds are not provided if you cancel early.<br>
                        If cancellation is initiated after an automatic renewal please get in touch so we can review your
                        account to see if you are entitled to a refund.</p>
                    <h3>Billing Disputes:</h3>
                    <p class="modal-p">If you believe there has been an error in billing, please contact our customer
                        support within 5 days of the transaction for resolution.</p>
                    <h3>Failed Payments:</h3>
                    <p class="modal-p"> the event of a failed payment, we will attempt to notify you to update your payment
                        information.<br>
                        Failure to update payment details within 24 hours may result in the suspension or termination of
                        your membership.</p>
                    <h3>Changes to Payment Policy:</h3>
                    <p class="modal-p">We reserve the right to modify this payment policy at any time. Changes will be
                        communicated through the website or via email.</p>
                    <h3>Contact Information:</h3>
                    <p class="modal-p">For any inquiries regarding payments or membership, please contact our customer
                        support at <a href="mailto:support@livefootballtoday.co.uk">support@livefootballtoday.co.uk</a></p>
                    <p class="modal-p">By proceeding with your membership, you acknowledge that you have read, understood,
                        and agreed to the terms outlined in this payment policy. Thank you for being a valued member of our
                        community! Enjoy the ads free experience along with the other benefits that members have access too
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--  <button type="button" class="btn btn-primary" id="agreeBtn">I Agree to the Policy</button>  --}}
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="payment-method">
        <div class="container">
            <div class="col-md-7 m-auto card_div">
                <div class="form-img">
                    <img src="{{ url('PublicArea/img/logo.png') }}" alt="">
                </div>
                <h2 class="payment_text">Pay with paypal</h2>

                <form id="payment-form" action="" method="POST">
                    <div id="error-message">
                        <!-- Display error message to your customers here -->
                    </div>
                    @csrf
                    
                    <div class="col-md-12 field-wrap">
                        <div class="checkboxes__row">
                            <div class="checkboxes__item">
                                <label class="checkbox style-e">
                                    <input type="radio" name="plan_packge" value="monthly" />
                                    <div class="checkbox__checkmark"></div>
                                    <div class="checkbox__body">Plan buy for a month?
                                        (£{{ $membershipprice->monthly_price }})</div>
                                </label>
                            </div>
                            <div class="checkboxes__item">
                                <label class="checkbox style-e">
                                    <input type="radio" name="plan_packge" value="yearly" checked="checked" />
                                    <div class="checkbox__checkmark"></div>
                                    <div class="checkbox__body">Plan buy for a Year? (£{{ $membershipprice->yearly_price }})
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="checkboxx">
                            <input id="checkboxx" type="checkbox" name="policy" value="1" checked="checked" />
                            I Agree to the Policy
                        </label>
                    </div>
                    <div class="payment_button">
                        <button type="submit" id="paySubmit">Buy Plan</button>
                    </div>
                </form>

                <script>
                    const stripe = Stripe('<?php echo $stripeConfig; ?>');
                    const client_secret = '<?php echo $client_secret; ?>';
       
                    
                    // const elements = stripe.elements();

                    // const cardNumber = elements.create('cardNumber');
                    // const cardExpiry = elements.create('cardExpiry');
                    // const cardCvc = elements.create('cardCvc');

                    // // Mount card elements on their respective containers
                    // cardNumber.mount('#card-number');
                    // cardExpiry.mount('#card-expiry');
                    // cardCvc.mount('#card-cvc');
                    // const payForm = document.getElementById('payment-form');
                    // const errorMessage = document.getElementById('error-message');
                    // const paySubmit = document.getElementById("paySubmit");

                    paySubmit.addEventListener("click", async (event) => {
                        event.preventDefault(); // Prevent default form submission
                        // errorMessage.innerHTML = '';
                        // Create a token when the form is submitted
                        try {
                            // Redirects away from the client
                            const error = await stripe.confirmPayPalPayment(client_secret,{
                                return_url: "{{route('paypal.response')}}",
                              }
                            );
                            
                            if (error) {
                              console.log(error)
                            }else{
                                
                            }
                           
                        } catch (error) {
                            errorMessage.innerHTML = '<div class="alert alert-danger">' + error +
                                '</div>';
                            console.error('Error:', error);
                        }
                    });
                </script>

                {{-- @endif --}}

            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('PublicArea/calendar/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('PublicArea/calendar/css/theme.css') }}">
    <style>
        /* STYLE E */

        .checkbox.style-e {
            display: inline-block;
            position: relative;
            padding-left: 50px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .checkbox.style-e input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkbox.style-e input:checked~.checkbox__checkmark {
            background-color: #f7cb15;
        }

        .checkbox.style-e input:checked~.checkbox__checkmark:after {
            left: 21px;
        }

        .checkbox.style-e:hover input~.checkbox__checkmark {
            background-color: #eee;
        }

        .checkbox.style-e:hover input:checked~.checkbox__checkmark {
            background-color: #f7cb15;
        }

        .checkbox.style-e .checkbox__checkmark {
            position: absolute;
            top: 9px;
            left: 0;
            height: 22px;
            width: 40px;
            background-color: #eee;
            transition: background-color 0.25s ease;
            border-radius: 11px;
        }

        .checkbox.style-e .checkbox__checkmark:after {
            content: "";
            position: absolute;
            left: 3px;
            top: 3px;
            width: 16px;
            height: 16px;
            display: block;
            background-color: #fff;
            border-radius: 50%;
            transition: left 0.25s ease;
        }

        .checkbox.style-e .checkbox__body {
            line-height: 1.4;
            transition: color 0.25s ease;
            text-align: left !important;
            width: 100%;
            font-size: 22px;
            transform: translateY(6px);
            color: red;
        }


        form {
            padding: 0 16px;
        }

        .form-control {
            padding: 30px .75rem;
        }

        .form-img {
            width: 60%;
            height: auto;
            margin: 0 auto;
            padding-bottom: 20px;
            display: none;
        }

        .form-img img {
            width: 100%;
        }

        .card_div {
            color: #fff;
            background: #1e0e52;
            font-family: 'Signika Negative', sans-serif;
            text-align: center;
            padding: 10px 0 70px;
            border-radius: 25px;
            margin-bottom: 40px !important;
        }

        .card_div h2 {
            font-size: 38px;
            font-weight: 700;
            line-height: 50px;
            margin-bottom: 40px;
            margin-top: 20px;

            padding: 20px;
        }

        .alert{
            padding: 20px;
            transform: scale(1);
            list-style: none;
            font-family: Montserrat Alternates;
            font-size: 22px;
            font-weight: 700;
        }

        li{
            list-style: none !important;
        }

        .card_div #paySubmit,
        #agreeBtn {
            background: #FFD23F;
            color: #000;
            font-size: 23px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 20px 50px;
            border-radius: 50px;
            display: inline-block;
            transition: all 0.3s ease;
            border: 1px solid #FFD23F;
            margin-top: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        .card_div #paySubmit:hover,
        #agreeBtn:hover {
            text-shadow: 3px 3px 3px rgba(0, 0, 0, 0.5);
        }

        iframe {
            height: auto !important;
        }

        .ElementsApp input {
            font-size: 20px !important;
        }

        label {
            text-align: left !important;
            width: 100%;
            font-size: 22px;
            transform: translateY(6px);
            color: rgba(255, 255, 255, 0.5);
        }

        .field-wrap {
            position: relative;
            margin-bottom: 30px;
        }

        .__PrivateStripeElement {
            top: -8px;
        }

        .CardNumberField .CardBrandIcon-container.is-hidden+.CardNumberField-input-wrapper {
            font-size: 20px !important;
        }

        .modalp {
            padding: 0 20px;
        }

        .modal-p {
            font-size: 25px;
            word-wrap: break-word;
        }

        .modal-p a {
            cursor: pointer;
        }

        .modal-body {
            text-align: left;
            padding: 1rem 3rem;
        }

        .checkboxx {
            background: #C50A0A;
            color: #fff;
            padding: 10px;
            cursor: pointer;
        }

        .checkboxx input {
            cursor: pointer;
            width: 20px;
            height: 20px;
        }

        @media only screen and (max-width:767px) {
            .modal-body {
                padding: 1rem;
                font-size: 22px;
                word-wrap: break-word;
            }

            .modal-body h3 {
                margin-top: 27px;
                font-size: 24px;
                font-weight: 600;
            }

            .checkbox.style-e .checkbox__body {
                font-size: 15px;
            }

            .checkboxx {
                background: #C50A0A;
                color: #fff;
                font-size: 20px;
                padding: 10px;
            }
        }
    </style>
@endsection
