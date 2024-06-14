@extends('PublicArea.layouts.app')
@section('title')
Football-Today | Fixtures
@endsection
@section('content')

<?php
if(Session::has("fcm_token")){
    echo Session::get("fcm_token");
}
?>


<style>
    .bg-12{
        background: #F6F8FA;
    }

    .bg-gre{
        background: #DCF0E5;
    }

    .table-row{
        width: 100%;
        float: left;
        border: 1px solid #E1E1E1;
    }

    .table-row h2{
        font-size: 15px;
        color: #747476;
        font-weight: 500;
        text-transform: capitalize;
        margin: 0;
    }

    .font-number{
        font-weight: 700;
    }

    .table-12{
        margin-top: 35px;
    }

    .table-row table th{
        font-size: 15px;
  color: #747476;
  font-weight: 600;
    }

    .table-row table tr td:first-child,
    .table-row table tr td:last-child{
        font-weight: 700;
    }
</style>



<div class="row table-row m-0">
    <div class="col-md-12 bg-12 py-2 px-0">
       <div class="row m-0">
         <div class="col-md-6 col-left-x text-left">
           <h2><img width="20" class="mr-1" src="https://media-4.api-sports.io/football/teams/511.png" alt="">Beyern Munich</h2>
         </div>
         <div class="col-md-6 col-right-x text-right">
            <h2><img width="20" class="mr-1" src="https://media-4.api-sports.io/football/teams/490.png" alt="">Borussia Dortmund</h2>
         </div>
       </div>
    </div>
    <div class="col-md-12 text-center py-2">
        <h2>Played: <span class="font-number">10</span></h2>
    </div>
    <div class="col-md-12 text-center p-0 bg-12">
        <div class="row m-0">
            <div class="col-md-4 text-center bg-gre py-2">
              <h2>Wins<br><span class="font-number">8</span></h2>
            </div>
            <div class="col-md-4 text-center py-2">
                <h2>Draws<br><span class="font-number">1</span></h2>
            </div>
            <div class="col-md-4 text-center py-2">
                <h2>Wins<br><span class="font-number">1</span></h2>
            </div>
        </div>
    </div>

    <div class="col-md-12 p-0 table-12">
        <table class="table table-striped table-hover">
            <thead class="bg-12">
                <tr>
                    <th>Total</th>
                    <th>Per Match</th>
                    <th></th>
                    <th>Total</th>
                    <th>Per Macth</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bg-gre">31</td>
                    <td class="bg-gre">3.1</td>
                    <td>Goals</td>
                    <td>1.4</td>
                    <td>14</td>
                </tr>
                <tr>
                    <td class="bg-gre">14</td>
                    <td class="bg-gre">1.4</td>
                    <td>Goals Conected</td>
                    <td>3.1</td>
                    <td>31</td>
                </tr>
                <tr>
                    <td>19</td>
                    <td>1.9</td>
                    <td>Yellow Cards</td>
                    <td class="bg-gre">1.8</td>
                    <td class="bg-gre">18</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>0.1</td>
                    <td>Red Cards</td>
                    <td class="bg-gre">1.8</td>
                    <td class="bg-gre">18</td>
                </tr>
                <tr>
                    <td class="bg-gre">3</td>
                    <td class="bg-gre">0.3</td>
                    <td>Clean Sheets</td>
                    <td></td>
                    <td>0</td>
                </tr>
                <tr>
                    <td class="bg-gre">50</td>
                    <td class="bg-gre">5</td>
                    <td>Corners</td>
                    <td>2.4</td>
                    <td>24</td>
                </tr>
                <tr>
                    <td class="bg-gre">98</td>
                    <td class="bg-gre">9.8</td>
                    <td>Fouls</td>
                    <td>10.1</td>
                    <td>101</td>
                </tr>
                <tr>
                    <td>29</td>
                    <td>2.9</td>
                    <td>Offside</td>
                    <td class="bg-gre">2.0</td>
                    <td class="bg-gre">20</td>
                </tr>
                <tr>
                    <td class="bg-gre">146</td>
                    <td class="bg-gre">14.6</td>
                    <td>Shots</td>
                    <td>8.2</td>
                    <td>82</td>
                </tr>
                <tr>
                    <td class="bg-gre">63</td>
                    <td class="bg-gre">6.3</td>
                    <td>Shots on Goal</td>
                    <td>3.5</td>
                    <td>35</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>









<div class="row mt-3">

    <div class="col-xl-8 text-left">
        <div id="fixtures_list" class="my-3">
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 text-left">
        <div class="card align-middle bg-dark text-white">
            <h5 class="text-left p-2">Date Picker</h5>
        </div>
        <div class="calendar-wrapper"></div>
    </div>

</div>


@endsection

@section('js')
<script src="{{asset('PublicArea/calendar/js/calendar.js')}}"></script>
<script>
    var intervalId = window.setInterval(function () {
        getAllFixtures();
    }, 300000);

    $(document).ready(function () {
        getAllFixtures();

        var config =
            `function selectDate(date) {
                $('.calendar-wrapper').updateCalendarOptions({
                date: date
                });
                dateSelect(date);
            }

            var defaultConfig = {
                weekDayLength: 1,
                date: new Date(),
                onClickDate: selectDate,
                showYearDropdown: true,
                startOnMonday: false,
            };

            $('.calendar-wrapper').calendar(defaultConfig);`;

        eval(config);
    });

    function getAllFixtures() {
        $.ajax({
            url: "{{ route('public.fixtures.ajax') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            dataType: 'html',
            success: function (response) {
                console.log(response);
                $('#fixtures_list').html(response);
            }
        });
    }

    function dateSelect(date) {
        var selectedDate = moment(date).format('YYYY-MM-DD')
        document.cookie = "date=" + selectedDate;

        $('#fixtures_list').html(
            '<div class="text-center">' +
            '<div class="spinner-border" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            '</div>' +
            '</div>'
        );
        getAllFixtures();
    }

    $(document).ready(function(){

        $(document).on("click", ".matchbtn", function(){
           
            const collapsed = $(this).hasClass('collapsed');
            if(collapsed == false){

                const id = $(this).data('id');

                $.ajax({
                    url: "/fixture/ajax/"+id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    dataType: 'html',
                    success: function (response) {
                        $('#collapse'+id).html(response);
                    }
                });

            }

        });

        $(document).on("click", ".match-preview-btn", function(){
           
            const collapsed = $(this).hasClass('collapsed');
            if(collapsed == false){

                const id = $(this).data('id');

                $.ajax({
                    url: "/fixture/match-preview/ajax/"+id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    dataType: 'html',
                    success: function (response) {
                        console.log(response);
                        $('#match_preivew'+id).html(response);
                    }
                });

            }

        });

    });
</script>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('PublicArea/calendar/css/style.css')}}">
<link rel="stylesheet" href="{{asset('PublicArea/calendar/css/theme.css')}}">
<style>
    #fixtures_list {
        min-height: 65vh;
    }

    .card-header {
        background-color: rgba(0, 0, 0, .8);
    }

    .btn-link {
        color: #fff;
        text-decoration: none !important;
    }

    .btn-link:hover {
        color: #fff;
        text-decoration: none !important;
    }

    tr.match {
        border-top: 1px solid #d3d3d3;
    }

    .matches_new td.minute {
        width: 58px;
        text-align: center;
    }

    table.matches_new th,
    table.matches_new td {
        padding: 3px 5px;
    }

    .minute.novis .match-card.match-current-minute {
        background-color: transparent !important;
        margin-right: 4px;
    }

    .minute.visible .match-card.match-current-minute {
        background-color: #12e5fa;
    }

    .minute.visible-2 .match-card.match-current-minute {
        background-color: rgba(0, 0, 0, .8);
    }

    .match .match-card {
        padding: 0 5px;
        background: #4a4a4a;
        color: #fff;
        text-align: center;
        min-width: 48px;
        line-height: 23px;
        font-size: 12px;
        display: inline-block;
    }

    td.team-a {
        text-align: right;
    }

    td.team {
        width: 50%;
        max-width: 50px;
        overflow: hidden;
        overflow-x: hidden;
        overflow-y: hidden;
        text-overflow: ellipsis;
    }

    td.score-time {
        width: 45px;
        white-space: nowrap;
        text-align: center;
        background: #dadada;
        font-weight: bold;
    }

    table.matches_new th,
    table.matches_new td {
        padding: 3px 5px;
    }

    td>a {
        text-decoration: none !important;
        color: #000;
    }

    td>a:hover {
        text-decoration: none !important;
        color: #000;
    }

    .calendar-wrapper {
        width: 100%;
        max-width: 400px;
        margin: auto;
        border: 1px solid #eee;
        padding: 10px;
    }

    .btn-xs {
        padding: 0.25rem 0.25rem;
        font-size: .675rem;
        line-height: 1;
        border-radius: 0.2rem;
    }

</style>
@endsection
