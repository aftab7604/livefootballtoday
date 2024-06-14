<style>
    .standing-table img {
        width: 20px;
    }

    .msrd{
        background: #D63A4B;
  color: #fff;
        display: inline-block;
  padding: .25em .4em;
  font-size: 75%;
  font-weight: 700;
  line-height: 1;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: .25rem;
  transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .msblu{
        background: #299FB4;
  color: #fff;
        display: inline-block;
  padding: .25em .4em;
  font-size: 75%;
  font-weight: 700;
  line-height: 1;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: .25rem;
  transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    /* Styles for the standings table */
    :root {
        --font: "Raleway", sans-serif;
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
        --modale-background-overlay: rgba(0, 0, 0, 0.4);
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

    .standing-table thead {
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }

    .standing-table tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }

    .standing-table table {
        display: table;
        border-collapse: separate;
        box-sizing: border-box;
        text-indent: initial;
        border-spacing: 2px;
        border-color: gray;
    }

    .standing-table table,
    table td,
    table tr {
        border-top: 0px solid #dee2e6 !important;
    }

    .standing-table tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }

    .standing-table td {
        padding: var(--primary-padding) !important;
        font-size: var(--primary-font-size);
        letter-spacing: 0;
        line-height: var(--primary-line-height);
        vertical-align: middle;
        background: var(--background-color);
        color: var(--color-text);
        border-bottom: var(--border-bottom);
    }

    .standing-table .wg_width_20 {
        width: 20px;
    }

    .standing-table .wg_width_90 {
        width: 90px;
    }

    .standing-table .wg_bolder {
        font-weight: 700;
    }

    .standing-table .wg_bolder {
        font-weight: 700;
    }

    .standing-table .wg_text_center {
        text-align: center;
    }

    .standing-table .wg_nowrap {
        white-space: nowrap;
    }

    .standing-table .wg_logo {
        width: var(--teams-logo-size);
        vertical-align: middle;
    }

    .standing-table img {
        overflow-clip-margin: content-box;
        overflow: clip;
        width: 16px;
        height: 16px;
    }

    .standing-table td {
        display: table-cell;
        vertical-align: inherit;
    }

    .standing-table .wg_form {
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

    .standing-table .wg_form_lose {
        background: var(--color-red);
    }

    .standing-table .wg_form_win {
        background: var(--color-green);
    }

    .standing-table .wg_form_draw {
        background: var(--color-yellow);
    }

    .standing-table .wg_header {
        padding: var(--secondary-padding);
        font-size: var(--header-font-size);
        font-weight: 600;
        background: var(--background-color-header);
        color: var(--color-text-header);
        text-transform: var(--header-text-transform);
    }



    .standing-table .wg_tooltip {
        cursor: pointer;
    }

    .standing-table .wg_text_center {
        text-align: center;
    }

    .standing-table .wg_tooltip.wg_tooltip_left:before {
        left: initial;
        margin: initial;
        right: 100%;
        margin-right: 0;
    }

    .standing-table .wg_tooltip:before {
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

    .standing-table .wg_info {
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

    .standing-table .wg_flag {
        width: var(--flags-size);
        vertical-align: middle;
    }

    @media only screen and (max-width: 482px) {
        .standing-table .wg_hide_xs {
            display: none;
        }
    }

    @media only screen and (max-width: 320px) {
        .standing-table .wg_hide_xxs {
            display: none;
        }
    }

    /* end Styles for the standings table */

    .title-band {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
            url("https://football.bitbotlab.com/PublicArea/img/soccer-bg.png");
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
        --font: "Raleway", sans-serif;
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
        --modale-background-overlay: rgba(0, 0, 0, 0.4);
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

    table.wg-table,
    table.wg-table td,
    table.wg-table tr {
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
        .wg_hide_xs {
            display: none;
        }
    }

    @media only screen and (max-width: 320px) {
        .wg_hide_xxs {
            display: none;
        }
    }

    .player-stats {
        cursor: pointer;
    }

    /* end Styles for the standings table */

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
        font-size: 12px;
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
    .table-row table tr td:nth-child(4){
        font-weight: 700;
    }

    @media only screen and (min-width:200px) and (max-width:767px){
        .col-right-x {
            text-align: left !important;
            margin-top: 20px;
        }

        .table-row .col-md-6 img{
            width: 30px !important;
            height: 30px !important;
        }

        .table-row table{
            display: block;
            width: 100%;
            overflow-x: auto;
        }
    }
</style>




<div class="sub_view_btn">
    <div class="container">
        <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-summary-tab" data-toggle="tab"
                    href="#nav-summary{{ $fixture->id }}" role="tab" aria-controls="nav-summary"
                    aria-selected="true">summary</a>
                <a class="nav-item nav-link match-stats-tab" id="nav-stats-tab" data-toggle="tab" href="#nav-stats{{ $fixture->id }}"
                    role="tab" aria-controls="nav-stats" aria-selected="false" data-id="{{ $fixture->id }}">Team stats</a>
                <a class="nav-item nav-link player-stats-tab" id="nav-Player-tab" data-toggle="tab" href="#nav-Player{{ $fixture->id }}"
                    role="tab" aria-controls="nav-Player" aria-selected="false" data-id="{{ $fixture->id }}">Player stats</a>
            </div>
        </nav>
        <div class="tab-content py-3 px-sm-0" id="nav-tabContent">

            <!-- summary tab content -->
            <div class="tab-pane fade show active" id="nav-summary{{ $fixture->id }}" role="tabpanel"
                aria-labelledby="nav-summary-tab">

                {{-- recent form --}}
                <div class="mb-2">
                    <div class="card align-middle bg-dark text-white">
                        <h5 class="text-left p-2">Previous Fixtures</h5>
                    </div>
                    <div class="row my-3 text-left">
                        <div class="col-md-6 mb-2 pr-1">
                            <div class="card">
                                <div class="card-body p-0 table-responsive">
                                    <h6 class="card-title mb-0 px-3 py-2">{{ $teams->home->name }}</h6>
                                    <table class="table" style="width: 100%;">
                                        <tbody>
                                            @forelse ($form["home"] as $home_fixture)
                                                <tr class="thead-light">
                                                    <th colspan="5">
                                                        {{ \carbon\carbon::parse($home_fixture->fixture->timestamp)->setTimezone($timezone)->format('d/m/Y') }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="width: 15%">
                                                        <a class="no-underline"
                                                            href="{{ route('public.team.get', [
                                                                'nation' => str_replace(' ', '_', $league->country),
                                                                'id' => $home_fixture->teams->home->id,
                                                                'club' => str_replace(' ', '_', $home_fixture->teams->home->name),
                                                            ]) }}">
                                                            <img class="team-logo-h2h"
                                                                src="{{ $home_fixture->teams->home->logo }}"
                                                                alt="home">
                                                        </a>

                                                    </td>
                                                    <td class="text-left">
                                                        <a class="no-underline"
                                                            href="{{ route('public.team.get', [
                                                                'nation' => str_replace(' ', '_', $league->country),
                                                                'id' => $home_fixture->teams->home->id,
                                                                'club' => str_replace(' ', '_', $home_fixture->teams->home->name),
                                                            ]) }}">
                                                            {{ $home_fixture->teams->home->name }}
                                                        </a> 
                                                    </td>
                                                    <td style="white-space: nowrap; centered-links" align="center">
                                                        <p>{{ $home_fixture->goals->home }}-{{ $home_fixture->goals->away }}
                                                        </p>
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="no-underline"
                                                            href="{{ route('public.team.get', [
                                                                'nation' => str_replace(' ', '_', $league->country),
                                                                'id' => $home_fixture->teams->away->id,
                                                                'club' => str_replace(' ', '_', $home_fixture->teams->away->name),
                                                            ]) }}">
                                                            {{ $home_fixture->teams->away->name }}
                                                        </a>
                                                    </td>
                                                    <td class="text-right" style="width: 15%">
                                                        <a class="no-underline"
                                                            href="{{ route('public.team.get', [
                                                                'nation' => str_replace(' ', '_', $league->country),
                                                                'id' => $home_fixture->teams->away->id,
                                                                'club' => str_replace(' ', '_', $home_fixture->teams->away->name),
                                                            ]) }}">
                                                            <img class="team-logo-h2h"
                                                                src="{{ $home_fixture->teams->away->logo }}"
                                                                alt="home">
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        No data available
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 pl-1">
                            <div class="card">
                                <div class="card-body p-0 table-responsive">
                                    <h6 class="card-title mb-0 px-3 py-2">{{ $teams->away->name }}</h6>
                                    <table class="table mstblx" style="width: 100%;">
                                        <tbody>
                                            @forelse ($form["away"] as $away_fixture)
                                                <tr class="thead-light">
                                                    <th colspan="5">
                                                        {{ \carbon\carbon::parse($away_fixture->fixture->timestamp)->setTimezone($timezone)->format('d/m/Y') }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td class="text-left" style="width: 15%">
                                                        <a class="no-underline"
                                                            href="{{ route('public.team.get', [
                                                                'nation' => str_replace(' ', '_', $league->country),
                                                                'id' => $away_fixture->teams->home->id,
                                                                'club' => str_replace(' ', '_', $away_fixture->teams->home->name),
                                                            ]) }}">
                                                            <img class="team-logo-h2h"
                                                                src="{{ $away_fixture->teams->home->logo }}"
                                                                alt="home">
                                                        </a>
                                                    </td>
                                                    <td class="text-left">
                                                        <a class="no-underline"
                                                            href="{{ route('public.team.get', [
                                                                'nation' => str_replace(' ', '_', $league->country),
                                                                'id' => $away_fixture->teams->home->id,
                                                                'club' => str_replace(' ', '_', $away_fixture->teams->home->name),
                                                            ]) }}">
                                                            {{ $away_fixture->teams->home->name }}
                                                        </a>
                                                    </td>
                                                    <td style="white-space: nowrap; centered-links" align="center">
                                                        <p>{{ $away_fixture->goals->home }}-{{ $away_fixture->goals->away }}
                                                        </p>
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="no-underline"
                                                            href="{{ route('public.team.get', [
                                                                'nation' => str_replace(' ', '_', $league->country),
                                                                'id' => $away_fixture->teams->away->id,
                                                                'club' => str_replace(' ', '_', $away_fixture->teams->away->name),
                                                            ]) }}">
                                                            {{ $away_fixture->teams->away->name }}
                                                        </a>
                                                    </td>
                                                    <td class="text-right" style="width: 15%">
                                                        <a class="no-underline"
                                                            href="{{ route('public.team.get', [
                                                                'nation' => str_replace(' ', '_', $league->country),
                                                                'id' => $away_fixture->teams->away->id,
                                                                'club' => str_replace(' ', '_', $away_fixture->teams->away->name),
                                                            ]) }}">
                                                            <img class="team-logo-h2h"
                                                                src="{{ $away_fixture->teams->away->logo }}"
                                                                alt="home">
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        No data available
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end of recent form --}}
                <div id="headtohead-{{ $fixture->id }}">

                </div>
                <div id="standings-{{ $fixture->id }}"> 
                    

                </div>
            </div>

            <!-- Team stats tab content -->
            <div class="tab-pane fade" id="nav-stats{{ $fixture->id }}" role="tabpanel"
                aria-labelledby="nav-stats-tab">

                <div class="text-center my-3" id="fixture-spinner">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>

                    </div>
                </div>
            </div>

            <!-- Player tab content -->
            <div class="tab-pane fade" id="nav-Player{{ $fixture->id }}" role="tabpanel"
                aria-labelledby="nav-Player-tab">

                <div class="text-center my-3" id="nav-player-spinner">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                         <iframe scrolling='no' frameBorder='0' style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;' width='728' height='90' src="https://campaigns.williamhill.com/I.ashx?btag=a_197286b_343c_&affid=1741061&siteid=197286&adid=343&c=" ></iframe> 

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

