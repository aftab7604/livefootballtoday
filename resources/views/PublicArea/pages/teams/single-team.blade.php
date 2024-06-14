@extends('PublicArea.layouts.app')
@section('title')
Live Football Today
@endsection
@section('content')

<div class="row mt-3">
    <div class="col-md-12">
        <div id="team_info" class="row">
            <div class="col-md-12 text-center my-2">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function () {
        getTeam();
    });

    function getTeam() {
        $.ajax({
            url: "{{ route('public.team.get.ajax', $id) }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            dataType: 'html',
            success: function (response) {
                $('#team_info').html(response);
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

    function setLeague(value) {
        document.cookie = "league=" + value + "; path=/team";
        $('#team-details').html(
            '<div class="col-md-12 text-center my-2">' +
            '<div class="spinner-border" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            '</div>' +
            '</div>'
        );
        getTeam();
    }

    function setSeason(value) {
        document.cookie = "season_team=" + value + "; path=/team";
        $('#team-details').html(
            '<div class="col-md-12 text-center my-2">' +
            '<div class="spinner-border" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            '</div>' +
            '</div>'
        );
        getTeam();
    }


    function setTransferDates(){
        var fromDate = $("#transfers_from_date").val();
        var toDate = $("#transfers_to_date").val();
       
        document.cookie = "transfers_from_date=" + fromDate + "; path=/team";
        document.cookie = "transfers_to_date=" + toDate + "; path=/team";
        $('#transfers-container').html(
            '<div class="col-md-12 text-center my-2">' +
            '<div class="spinner-border" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            '</div>' +
            '</div>'
        );
        getTeam();
    }

</script>

@endsection
@section('css')
<style>
    .title-band {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
        url("{{asset('PublicArea/img/soccer-bg.png')}}");
        background-size: cover;
        background-position: center;
    }

    .nav-pills .nav-link {
        color: #000;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #12e5fa;
    }

    #team_info {
        min-height: 75vh;
    }

    .team-logo {
        width: 7%;
    }

    .team-title {
        font-size: 1rem;
    }

    @media (max-width: 780.98px) {
        .team-logo {
            width: 15%;
        }

        .team-title {
            font-size: 0.9rem;
        }

        .select-col {
            width: 30%;
        }

        .stats-col {
            width: 50% !important;
        }
    }

    #fixture_list {
        /* overflow-y: scroll; */
        height: min-content;
        max-height: 100% !important; /* it was 700px*/
    }

    div ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    div ::-webkit-scrollbar-track {
        border-radius: 5px;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.25);
    }

    div ::-webkit-scrollbar-thumb {
        border-radius: 5px;
        background-color: #12e5fa;
    }

    div ::-webkit-scrollbar-thumb:hover {
        border-radius: 5px;
        background-color: #12e5fa;
    }

    .card-header {
        background-color: rgba(0, 0, 0, .6);
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

    .stats-col {
        text-align: left;
    }

    /* Styles for the standings table */
    :root {
        --font: "Raleway",sans-serif;
        --background-color: #fff;
        --background-color-header: #e9ecef;
        --color-text: #000;
        --color-text-header: #000;
        --color-green: #01d099;
        --color-red: #f64e60;
        --color-yellow: #ffa800;
        --primary-font-size: 11px;
        --secondary-font-size: 10px;
        --header-font-size: 11px;
        --header-text-transform: uppercase;
        --header-link-text-transform: none;
        --border-bottom: 0.5px solid var(--background-color-header);
        --primary-padding: 3px 3px;
        --primary-line-height: 13px;
        --secondary-padding: .3rem;
        --button-info-font-size: 9px;
        --button-info-line-height: 16px;
        --toolbar-font-size: var(--header-font-size);
        --modale-background-overlay: rgba(0,0,0,0.4);
        --modale-close-size: 28px;
        --modale-score-size: 36px;
        --modale-teams-size: 13px;
        --standings-team-form-font-size: 9px;
        --standings-team-form-line-height: 16px;
        --flags-size: 16px;
        --teams-logo-size: 16px;
        --teams-logo-modal-size: 90%;
        --teams-logo-block-modal-size: 85px;
        --teams-logo-block-radius-modal: 5px;
        --teams-logo-block-background-modal: var(--background-color-header);
    }
    .wg-table {
        font-family: var(--font);
        width: 100%;
        /* border-collapse: collapse; */
    }
    thead {
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }
    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    table {
        display: table;
        border-collapse: separate;
        box-sizing: border-box;
        text-indent: initial;
        border-spacing: 2px;
        border-color: gray;
    }
    table,table td, table tr{
        border-top: 0px solid #dee2e6 !important;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    td {
        padding: var(--primary-padding) !important; 
        font-size: var(--primary-font-size);
        letter-spacing: 0;
        line-height: var(--primary-line-height);
        vertical-align: middle;
        background: var(--background-color);
        color: var(--color-text);
        border-bottom: var(--border-bottom);
    }

    .wg_width_20 {
        width: 20px;
    }
    .wg_width_90 {
        width: 90px;
    }
    .wg_bolder {
        font-weight: 700;
    }
    .wg_bolder {
        font-weight: 700;
    }
    .wg_text_center {
        text-align: center;
    }
    .wg_nowrap {
        white-space: nowrap;
    }
    .wg_logo {
        width: var(--teams-logo-size);
        vertical-align: middle;
    }
    img {
        overflow-clip-margin: content-box;
        overflow: clip;
        width: 16px;
        height: 16px;
    }

    td {
        display: table-cell;
        vertical-align: inherit;
    }

    .wg_form {
        display: inline-block;
        /* margin: 1px; */
        width: 14px;
        height: 14px;
        line-height: var(--standings-team-form-line-height);
        font-size: var(--standings-team-form-font-size);
        text-align: center;
        position: relative;
        color: #fff;
    }
    .wg_form_lose {
        background: var(--color-red);
    }
    .wg_form_win {
        background: var(--color-green);
    }
    .wg_form_draw {
        background: var(--color-yellow);
    }

    .wg_header {
        padding: var(--secondary-padding);
        font-size: var(--header-font-size);
        font-weight: 600;
        background: var(--background-color-header);
        color: var(--color-text-header);
        text-transform: var(--header-text-transform);
    }

    .wg_tooltip {
        cursor: pointer;
    }

    .wg_text_center {
        text-align: center;
    }

    .wg_tooltip.wg_tooltip_left:before {
        left: initial;
        margin: initial;
        right: 100%;
        margin-right: 0;
    }

    .wg_tooltip:before {
        content: attr(data-text);
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 100%;
        margin-left: 0;
        min-width: 80px;
        max-width: 200px;
        width: auto;
        padding: 5px;
        border-radius: 3px;
        background: var(--color-text);
        color: var(--background-color);
        text-align: center;
        display: none;
        z-index: 99999;
    }
    .wg_info {
        display: inline-block;
        border-radius: 14px;
        margin: 1px;
        width: 14px;
        height: 14px;
        line-height: var(--button-info-line-height);
        font-size: var(--button-info-font-size);
        text-align: center;
        position: relative;
        color: #fff;
        background: var(--background-color-header);
    }
    .wg_flag {
        width: var(--flags-size);
        vertical-align: middle;
    }

    @media only screen and (max-width: 482px) {
        .wg_hide_xs{
            display: none;
        }
    }
    @media only screen and (max-width: 320px) {
        .wg_hide_xxs{
            display: none;
        }
    }
                
    /* end Styles for the standings table */

</style>
@endsection
