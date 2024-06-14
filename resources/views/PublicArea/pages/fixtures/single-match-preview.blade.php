@extends('PublicArea.layouts.app')
@section('title')
Football-Today
@endsection
@section('content')


<div class="row mt-3">
    <div class="col-md-12">
        <div id="fixture_info" class="row">
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
    var intervalId = window.setInterval(function () {
        getFixture();
    }, 300000);

    $(document).ready(function () {
        getFixture();
    });

    function getFixture() {
        $.ajax({
            url: "{{ route('public.fixture.match-preview.get.ajax', $id) }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            dataType: 'html',
            success: function (response) {
                $('#fixture_info').html(response);
                predictionChart();
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

    function predictionChart() {
        const labels = ['Strength', 'Attacking Potential', 'Defensive Potential', 'Poisson Distribution',
            'Strength H2H',
            'Goals H2H', 'Wins the Game'
        ];

        var home_data = @php echo json_encode($predictions_array['home']);
        @endphp;
        var away_data = @php echo json_encode($predictions_array['away']);
        @endphp;

        const data = {
            labels: labels,
            datasets: [{
                    label: "{{$predictions[0]->teams->home->name}}",
                    data: home_data,
                    borderColor: '#12e5fa',
                    backgroundColor: 'rgba(18, 229, 250, 0.5)',
                },
                {
                    label: '{{$predictions[0]->teams->away->name}}',
                    data: away_data,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.5)',
                }
            ]
        };

        const config = {
            type: 'radar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: false,
                        text: ''
                    }
                }
            },
        };

        var predictionChartDiagram = new Chart(
            document.getElementById('predictionChart'),
            config
        );
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

    #fixture_info {
        min-height: 75vh;
    }

    .team-logo {
        width: 40%;
    }

    .team-logo-h2h {
        width: 100%;
    }

    .team-logo-standing {
        width: 7%;
    }

    .scorer-name {
        min-width: 7rem;
    }

    .h2h_table td,
    .h2h_table th {
        vertical-align: middle !important;
        font-size: 1.3rem;
    }

    @media (max-width: 780.98px) {
        .team-logo {
            width: 100%;
        }

        .team-logo-standing {
            width: 15%;
        }

        .mobile-resp {
            max-width: 30%;
        }

        .team-text {
            font-size: 1rem;
        }

        .score-text {
            font-size: 1rem;
        }

        .time-text {
            font-size: 1.2rem;
        }

        .stats-table td,
        .stats-table th {
            padding: 0.35rem !important;
        }

        .h2h_table td,
        .h2h_table th {
            vertical-align: middle !important;
            font-size: 0.8rem;
        }
    }

    .player_link {
        text-decoration: none;
        color: #000;
    }

    .player_link:hover {
        text-decoration: none;
        color: #000;
    }

    .table td,
    .table th {
        padding: .75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
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
    .wg-table thead {
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }
    .wg-table tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    table.wg-table {
        display: table;
        border-collapse: separate;
        box-sizing: border-box;
        text-indent: initial;
        border-spacing: 2px;
        border-color: gray;
    }
    table.wg-table,table.wg-table td, table.wg-table tr{
        border-top: 0px solid #dee2e6 !important;
    }
    .wg-table tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    .wg-table td {
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
    .wg-table img {
        overflow-clip-margin: content-box;
        overflow: clip;
        width: 16px;
        height: 16px;
    }

    .wg-tabletd {
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
