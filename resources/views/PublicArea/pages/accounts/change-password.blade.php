@extends('PublicArea.layouts.app')
@section('title')
Live Football Today | Change Password
@endsection
@section('content')
<?php
if(Session::has("fcm_token")){
    echo Session::get("fcm_token");
}

?>
{{--  plan code   --}}
<div class="account-container">
    <div class="container">
        <div class="row">
            @if($errors->any())
                <div class="alert alert-success" style="text-transform: capitalize;">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @if (session('success'))
                <div class="alert alert-success w-100 confirm_msgs" style="text-transform: capitalize;">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger w-100 confirm_msgs" style="text-transform: capitalize;">{{ session('error') }}</div>
                @endif
            @endif
            <div class="form">
                <div class="form-img">
                    <img src="{{url('PublicArea/img/logos.png')}}" alt="">
                </div>
                <div id="reset-password">  
                    <span style="color:#1e0e52">{{session('msgSession')}}</span>
                    <h1><strong>Update your password</strong></h1>
                    <form action="{{route('user.update.password')}}" method="post">
                        @csrf
                        <div class="field-wrap">
                            <label>
                                Old Password<span class="req">*</span>
                            </label>
                            <input type="password"required name="old_password" autocomplete="off"/>
                        </div>
                        <div class="field-wrap">
                            <label>
                                New Password<span class="req">*</span>
                            </label>
                            <input type="password"required name="new_password" minlength="4" maxlength="16" autocomplete="off"/>
                        </div>
                        <div class="field-wrap">
                            <label>
                                Confirm New Password<span class="req">*</span>
                            </label>
                            <input type="password"required name="confirm_new_password" minlength="4" maxlength="16" autocomplete="off"/>
                        </div>
                        
        
                        <button type="submit" class="button button-block"/>Update</button>
                    </form>
                </div> 
            </div> 
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('PublicArea/calendar/js/calendar.js')}}"></script>
<script>
$('.form').find('input, textarea').on('keyup blur focus', function (e) {
    var $this = $(this),
        label = $this.prev('label');
        if (e.type === 'keyup') {
              if ($this.val() === '') {
            label.removeClass('active highlight');
          } else {
            label.addClass('active highlight');
          }
      } else if (e.type === 'blur') {
          if( $this.val() === '' ) {
              label.removeClass('active highlight'); 
              } else {
              label.removeClass('highlight');   
              }   
      } else if (e.type === 'focus') {
        if( $this.val() === '' ) {
              label.removeClass('highlight'); 
              } 
        else if( $this.val() !== '' ) {
              label.addClass('highlight');
              }
      }
  });
  $('.tab a').on('click', function (e) {
    e.preventDefault();
    $(this).parent().addClass('active');
    $(this).parent().siblings().removeClass('active');
    target = $(this).attr('href');
    $('.tab-content > div').not(target).hide();
    $(target).fadeIn(600);
  });
  </script>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('PublicArea/calendar/css/style.css')}}">
<link rel="stylesheet" href="{{asset('PublicArea/calendar/css/theme.css')}}">
<style>

  .alert{
    width: 100%;
  }

  .alert ul{
    margin: 0;
    padding: 0;
  }
    .alert ul li{
      padding: 20px;
      transform: scale(1);
      list-style: none;
      font-family: Montserrat Alternates;
      font-size: 22px;
      font-weight: 700;
    }

    .form-img{
        width: 60%;
        height: auto;
        margin: 0 auto;
        padding-bottom: 20px;
    }
    .form-img img{
        width: 100%;
    }
    a {
        text-decoration: none;
        color: #eecc5b;
        transition: .5s ease;
    }
  /* Style for the Remember Me checkbox */
.remember-me {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}
.remember-me input {
    margin-right: 10px;
}
.remember-me label {
    margin-left: 20px;
    cursor: pointer;
    pointer-events: unset;
}
/* Styling the checkbox appearance */
.remember-me input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #eecc5b; /* Checkbox border color */
    border-radius: 4px;
    outline: none;
    cursor: pointer;
}
.remember-me input[type="checkbox"]:checked {
    background-color: #eecc5b; /* Background color when checked */
    border: 2px solid #eecc5b; /* Border color when checked */
}
    .form {
        background: #1e0e52!Important;
        padding: 20px 40px 40px;
        width: 100%;
        max-width: 70%;
        margin: 40px auto;
        border-radius: 4px;
        box-shadow: 0 4px 10px 4px rgba(19, 35, 47, 0.3);
    }
    .tab-group {
        list-style: none;
        padding: 0;
        margin: 0 0 40px 0;
    }
    .tab-group:after {
        content: "";
        display: table;
        clear: both;
    }
    .tab-group li a {
        padding: 20px;
        transform: scale(1);
        color: #fff;
        font-family: Montserrat Alternates;
        font-size: 22px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        float: left;
        width: 50%;
        text-align: center;
        cursor: pointer;
        transition: .5s ease;
        text-decoration: none !important;
        background: #938A6E40;
    }
    .tab-group li a:hover {
        background: #eec94f;
        color: #000;
    }
    .tab-group .active a {
        background: #eecc5b;
        color: #000;
    }
    .tab-content > div:last-child {
        display: none;
    }
    h1 {
        text-align: center;
        color: #ffffff;
        font-weight: 300;
        margin: 0 0 40px;
          font-size: 20px;
          background: #b50505;
          padding: 20px;

    }
    h1 strong{
        font-weight:800;
    }
    label {
        position: absolute;
        transform: translateY(6px);
        left: 13px;
        color: rgba(255, 255, 255, 0.5);
        transition: all 0.25s ease;
        -webkit-backface-visibility: hidden;
        pointer-events: none;
        font-size: 22px;
    }
    label .req {
        margin: 2px;
        color: #eecc5b;
    }
    label.active {
        transform: translateY(50px);
        left: 2px;
        font-size: 14px;
    }
    label.active .req {
        opacity: 0;
    }
    label.highlight {
        color: #ffffff;
    }
    input,
    textarea {
        font-size: 22px;
        display: block;
        width: 100%;
        height: 100%;
        padding: 5px 10px;
        background: none;
        background-image: none;
        border: 1px solid #fff;
        border-top: none;
        border-left: none;
        border-right: none;
        color: #ffffff;
        border-radius: 0;
        transition: border-color .25s ease, box-shadow .25s ease;
    }
    input::placeholder,
textarea::placeholder {
    font-size: 16px; /* Adjust the font size as needed */
    color: rgba(255, 255, 255, 0.5); /* Placeholder text color */
}
    input:focus,
    textarea:focus {
        outline: 0;
        border-color: #eec94f;
    }
    textarea {
        border: 2px solid #fff;
        resize: vertical;
    }
    .field-wrap {
        position: relative;
        margin-bottom: 40px;
    }
    .top-row:after {
        content: "";
        display: table;
        clear: both;
    }
    .top-row > div {
        float: left;
        width: 48%;
        margin-right: 4%;
    }
    .top-row > div:last-child {
        margin: 0;
    }
    .button {
        text-transform: uppercase;
        padding: 20px;
        border-radius: 10px;
        color: #000;
        font-family: Montserrat Alternates;
        font-size: 22px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        text-align: center;
        cursor: pointer;
        transition: .5s ease;
        background: #eecc5b;
        border: 1px solid #eecc5b;
    }
    .button:hover,
    .button:focus {
        background: #eec94f;
    }
    .button-block {
        display: block;
        width: 100%;
    }
    .forgot {
        margin-top: -20px;
        text-align: right;
    }
    @media only screen and (max-width:600px){
    .field-wrap{
      width:100% !important;
      margin-bottom: 40px !important;
    }
  }
    </style>
@endsection
