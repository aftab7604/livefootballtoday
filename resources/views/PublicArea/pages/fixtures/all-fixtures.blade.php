@extends('PublicArea.layouts.app')
@section('title')
Live Football Today | Fixtures
@endsection
@section('content')

<?php
if(Session::has("fcm_token")){
    echo Session::get("fcm_token");
}
?>

<div class="row">
    <div class="col-xl-3 text-left mbdn ml-auto">
        <div class="card align-middle msDate text-white">
            <h5 class="text-center w-100 p-2 mb-0" style="font-size:20px;font-weight: 600;">Select Date</h5>
        </div>
        <div class="calendar-wrapper"></div>
    </div>
    <div class="col-xl-12 text-left">
        <div id="fixtures_list" class="mb-3">
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="{{asset('PublicArea/calendar/js/calendar.js')}}"></script>
<script>
    // var intervalId = window.setInterval(function () {
    //     getAllFixtures();
    // }, 300000);

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
                // console.log(response);
                $('#fixtures_list').html(response);
                
               
                    $(".probs-table").each(function(){

                        let id = $(this).data("id");
                        $.ajax({
                            url: "/probabilities/ajax/"+id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Accept': 'application/json'
                            },
                            type: 'GET',
                            success: function (response) {
                                let html = "";
                                console.log(response);
                                html += `<td class='match_live'>${response.u25_or_o25 == "O2.5" ? "Yes" : "No"}</td>`;
                                html += `<td class='match_live'>${response.homePercent}</td>`;
                                html += `<td class='match_live'>${response.drawPercent}</td>`;
                                html += `<td class='match_live'>${response.awayPercent}</td>`;
                                html += `<td class='match_live'>${response.btts_yes_or_no == "Yes" ? "Yes" : "No"}</td>`;
                                $("#prob-tr-"+id).html(html);

                                probFetched = true;
                            }
                        });
                    
                    });
           
                    // let ids = [];
                    // $(".probs-table").each(function(){
                    //     let id = $(this).data("id");
                    //     ids.push(id);
                    // });

                    // console.log(ids);
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
                        console.log(response);
                        $('#collapse'+id).html(response);
                        getMatchPreview(id);
                    }
                });

            }

        });

        // $(document).on("click", ".match-preview-btn", function(){

        //     const collapsed = $(this).hasClass('collapsed');
        //     if(collapsed == false){

        //         const id = $(this).data('id');

        //          getMatchPreview();

        //     }

        // });

        function getMatchPreview(id){
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
                    getHeadToHead(id);
                    getStandings(id);
                    getMatchStats(id);
                    getPlayerStats(id);
                }
            });
        }

        function getHeadToHead(id) {
            $.ajax({
                url: "/fixture/head-to-head/ajax/"+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'html',
                success: function (response) {
                    console.log(response);
                    $(`#headtohead-${id}`).html(response);
                }
            });
        }

        function getStandings(id) {
            $.ajax({
                url: "/fixture/standings/ajax/"+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'html',
                success: function (response) {
                    console.log(response);
                    $(`#standings-${id}`).html(response);
                }
            });
        }


        // $(document).on("click", ".match-stats-tab", function(){

        //     const collapsed = $(this).hasClass('collapsed');
        //     if(collapsed == false){
        //         const id = $(this).data('id');
        //         getMatchStats(id);
        //     }

        // });

        function getMatchStats(id){
            $.ajax({
                url: "/fixture/match-stats/ajax/"+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'html',
                success: function (response) {
                    // console.log(response);
                    $('#nav-stats'+id).html(response);

                }
            });
        }

        // $(document).on("click", ".player-stats-tab", function(){

        //     const collapsed = $(this).hasClass('collapsed');
        //     if(collapsed == false){
        //         const id = $(this).data('id');
        //         getPlayerStats();
        //     }

        // });

        function getPlayerStats(id){
            $.ajax({
                url: "/fixture/player-stats/ajax/"+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'html',
                success: function (response) {
                    // console.log(response);
                    $('#nav-Player'+id).html(response);

                }
            });
        }

    });

    var elements = document.querySelectorAll('iframe, img');
    for (var i = 0; i < elements.length; i++) {
      elements[i].style.width = '100% !important';
      elements[i].style.float = 'left !important';
      elements[i].style.height = '100% !important';
    }

    var geoURL = "//campaigns.williamhill.com/G.ashx";
    $('.calendar-wrapper').hide();
    $(document).ready(function () {
    $(document).on('click', '.msDate', function(e){
        $('.calendar-wrapper').fadeToggle(500);
    });
    
    $(document).on("click",".toggleable",function(){
        var id = $(this).attr("href");
        if($(id).hasClass("clicked")){
            if($(id).hasClass("show")){
                $(id).removeClass("show")
            }else{
                $(id).addClass("show")   
            }   
        }
        
        $(id).addClass("clicked");
    })
});

</script>
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('PublicArea/calendar/css/style.css')}}">
<link rel="stylesheet" href="{{asset('PublicArea/calendar/css/theme.css')}}">
<style>

    .msDate{
        cursor: pointer;
        background: #000;
        border-radius: 0;
        width: 100%;
        padding: 15px;
        margin-bottom: 1rem;
    }

    .calendar-wrapper{
        background: #fff;
        margin-bottom: 1rem !important;
    }

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

.calendar-wrapper .prev-button,
.calendar-wrapper .next-button,
.calendar-wrapper .today-button{
    background: #000;
  border: 1px solid #000 !important;
  color: #fff;
  padding: 0px 10px;
}

.label-container.month-container{
    float: left;
  width: 50%;
  text-align: center;
}

.calendar-wrapper .prev-button{
    float: left;
  width: 25%;
  margin-bottom: 15px;
}

.calendar-wrapper .next-button{
    float: left;
  width: 25%;
  margin-bottom: 15px;
}

.calendar-wrapper .today-button{
    margin-top: 15px;
}

.calendar-wrapper .buttons-container{
    float: left;
  width: 100%;
}

.calendar-wrapper .day{
    border: 1px solid #c5c5c5;
  background: #f6f6f6;
  font-weight: normal;
  color: #454545;
}

.calendar-wrapper .week{
    overflow: inherit;
}

@media only screen and (max-width:767px){

    .match_list.container .card {
      margin:10px !important;
    }

.mbdn{
    max-width: 325px;
    margin: 0 auto 2rem !important;
}
    .msDate, .calendar-wrapper{
        position: unset !important;
    }

    .msp iframe,.mbdn{
        padding: 0 15px !important;
    }

    .calendar-wrapper{
        display: block !important;
    }
}

@media only screen and (min-width:768px) and (max-width:1024px){

.mbdn{
    max-width: 400px;
    margin: 0 auto 2rem !important;
}
.msDate, .calendar-wrapper{
    position: unset !important;
}

.msp iframe,.mbdn{
    padding: 0 15px !important;
}

}

@media only screen and (min-width:768px) and (max-width:1150px){

    .mbdn{
    max-width: 400px;
    margin: 0 auto 2rem !important;
}
.msDate, .calendar-wrapper{
    position: unset !important;
}

}

.expendable.tab-pane.fade:not(.show){
    display:none;
}
</style>
@endsection
