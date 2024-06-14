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
    form.ms_form input.form-control:focus{
  border-color: #03070b !important;
  box-shadow: 0 0 0 .1rem rgba(4, 6, 9, 0.99) !important;
}
.ms_btn{
    background: #000 !important;
    border-color: #03070b !important;
    box-shadow: 0 0 0 .1rem rgba(4, 6, 9, 0.99) !important;
    text-white;
    width: 150px;
    font-size:17px;
    font-weight:600;
}
@media only screen and (max-width:767px){
 .ms_btn,.ms_btn_main{
    width: 100%;
    max-width: 100%;
    flex:100%;
    margin-top:8px;
 }   
}
</style>
<div class="row mt-3">
    <form method="post" class="ms_form w-100" id="fixturesForm" action="">
        <div class="col-md-12 mt-3 mb-5">
            <div class="row w-100 m-0">
                <div class="col-md-4">
                    <input type="text" name="favourit-leagues" class="form-control" placeholder="Search your favourit leagues...">
                </div>
                <div class="col-md-2 text-left ms_btn_main">
                    <input type="submit" value="Filter" class="btn ms_btn text-white">
                </div>
            </div>
        </div>
    </form>
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

$(document).ready(function () {
    $('#fixturesForm').submit(function (event) {
        // Prevent the default form submission
        event.preventDefault();
        // Get the input value
        var searchValue = $('input[name="favourit-leagues"]').val();
        // Call the function to get all fixtures with the search value
        getAllFilterFixtures(searchValue);
    });
});

function getAllFilterFixtures(searchValue) {
    $.ajax({
        url: "{{ route('public.fixtures.filter.ajax') }}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        dataType: 'html',
        data: { search: searchValue },
        success: function (response) {
            console.log(response);
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
        }
    });
}



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
