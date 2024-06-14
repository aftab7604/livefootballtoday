    <div class="card-body px-0">
        <style>
            .msbdyx tr td:nth-child(1){
                background: antiquewhite;
             }
             .msbdyx tr td:nth-child(2){
                 background: #fff;
             }
             .msbdyx tr td:nth-child(3){
                 background: #add3f5 !important;
             }
         </style>
        <!-- Team logos start -->
        <div class="team__vs_t">
            <div class="team1">
            <img src="{{$teams->home->logo}}" alt="team_logo" />
            </div>
            <div class="team_score">
            <div class="scr_highlight">
                @switch($fixture->status->short)
                @case("CANC")
                    <span>{{$fixture->status->short}}</span>
                @break
                @case("PST")
                    <span>{{$fixture->status->short}}</span>
                @break
                @case("TBD")
                    <span>{{$fixture->status->short}}</span>
                @break
                @case("NS")
                    <span>{{\carbon\carbon::parse($fixture->timestamp)->setTimezone($timezone)->format('H:i')}}</span>
                @break
                @default
                    <span>{{$goals->home}}</span>-<span>{{$goals->away}}</span>
                @endswitch

            </div>
            </div>
            <div class="team2">
            <img src="{{$teams->away->logo}}" alt="team_logo" />
            </div>
        </div>
        <!-- Team logos End -->

        <!-- Submenu button start -->
        <div class="sub_view_btn">
            <div class="container">
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link toggleable" id="nav-match-tab" data-toggle="tab" href="#nav-match{{$fixture->id}}" role="tab" aria-controls="nav-match" aria-selected="false">match Center</a>
                    <a class="nav-item nav-link toggleable" id="nav-lineups-tab" data-toggle="tab" href="#nav-lineups{{$fixture->id}}" role="tab" aria-controls="nav-lineups" aria-selected="false">lineups</a>
                </div>
            </nav>
            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                </div>
                <!-- match stats tab content -->
                <div class="expendable tab-pane fade" id="nav-match{{$fixture->id}}" role="tabpanel" aria-labelledby="nav-match-tab">
                    <p class="display-4 text-center"></p>

                    <div class="evnt_endpoint">

                        <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                @if (!empty($events))

                                @php
                                $home_goals = 0;
                                $away_goals = 0;
                                @endphp

                                @foreach ($events as $event)
                                @php
                                if (in_array($event->detail, ['Normal Goal', 'Own Goal', 'Penalty'])) {
                                if($event->team->id == $teams->home->id){
                                $home_goals++;
                                } else {
                                $away_goals++;
                                }
                                }
                                @endphp

                                @switch($event->type)

                                @case("Goal")
                                @if ($event->detail != "Missed Penalty")
                                <tr>
                                    @if ($event->team->id == $teams->home->id)
                                    <td class="text-left">
                                        <span style="display: inline-block">
                                            <i class="far fa-futbol text-success"></i>&nbsp;
                                            <span
                                                class="text-xs
                                    text-muted">{{$event->time->elapsed}}'</span>&nbsp;<strong>{{$home_goals}}-{{$away_goals}}</strong>&nbsp;{{$event->player->name}}&nbsp;
                                            <small class="text-xs text-muted">
                                                @if ($event->assist->name)
                                                Assit: {{$event->assist->name}}
                                                @endif
                                            </small>
                                        </span>
                                    </td>
                                    @else
                                    <td class="text-right">
                                        <span style="display: inline-block">
                                            <small class="text-xs text-muted">
                                                @if ($event->assist->name)
                                                Assit: {{$event->assist->name}}
                                                @endif
                                            </small>&nbsp;{{$event->player->name}}&nbsp;
                                            <strong>{{$home_goals}}-{{$away_goals}}</strong>&nbsp;
                                            <span class="text-xs text-muted">{{$event->time->elapsed}}'</span>&nbsp;
                                            <i class="far fa-futbol text-success"></i>
                                        </span>
                                    </td>
                                    @endif
                                </tr>
                                @endif
                                @break

                                @case("Card")
                                <tr>
                                    {{-- inside switch --}}
                                    @switch($event->detail)
                                    @case("Yellow Card")
                                    @if ($event->team->id == $teams->home->id)
                                    <td class="text-left">
                                        <span style="display: inline-block">
                                            <svg width="13" height="18">
                                                <rect width="300" height="100" style="fill:#ffc107" />
                                            </svg>&nbsp;
                                            <span class="text-xs text-muted">{{$event->time->elapsed}}'</span>&nbsp;
                                            {{$event->player->name}}
                                        </span>
                                    </td>
                                    @else
                                    <td class="text-right">
                                        <span style="display: inline-block">
                                            {{$event->player->name}}&nbsp;
                                            <span class="text-xs text-muted">{{$event->time->elapsed}}'</span>&nbsp;
                                            <svg width="13" height="18">
                                                <rect width="300" height="100" style="fill:#ffc107" />
                                            </svg>
                                        </span>
                                    </td>
                                    @endif
                                    @break
                                    @case("Red card")
                                    @if ($event->team->id == $teams->home->id)
                                    <td class="text-left">
                                        <span style="display: inline-block">
                                            <svg width="13" height="18">
                                                <rect width="300" height="100" style="fill:#dc3545" />
                                            </svg>&nbsp;
                                            <span class="text-xs text-muted">{{$event->time->elapsed}}'</span>&nbsp;
                                            {{$event->player->name}}
                                        </span>
                                    </td>
                                    @else
                                    <td class="text-right">
                                        <span style="display: inline-block">
                                            {{$event->player->name}}&nbsp;
                                            <span class="text-xs text-muted">{{$event->time->elapsed}}'</span>&nbsp;
                                            <svg width="13" height="18">
                                                <rect width="300" height="100" style="fill:#dc3545" />
                                            </svg>
                                        </span>
                                    </td>
                                    @endif
                                    @break
                                    @case("Second Yellow card")
                                    @if ($event->team->id == $teams->home->id)
                                    <td class="text-left">
                                        <span style="display: inline-block">
                                            <svg width="16" height="16" viewBox="180 180 680 680" fill="#404040"
                                                style="min-width: 16px; display: inline-block;">
                                                <title>2nd Yellow card (Red)</title>
                                                <path fill="#ecaa02" d="M243.2 275.2h428.8v588.8h-428.8v-588.8z">
                                                </path>
                                                <path fill="#a72018" d="M352 160h428.8v588.8h-428.8v-588.8z"></path>
                                            </svg>&nbsp;
                                            <span class="text-xs text-muted">{{$event->time->elapsed}}'</span>&nbsp;
                                            {{$event->player->name}}
                                        </span>
                                    </td>
                                    @else
                                    <td class="text-right">
                                        <span style="display: inline-block">
                                            {{$event->player->name}}&nbsp;
                                            <span class="text-xs text-muted">{{$event->time->elapsed}}'</span>&nbsp;
                                            <svg width="16" height="16" viewBox="180 180 680 680" fill="#404040"
                                                style="min-width: 16px; display: inline-block;">
                                                <title>2nd Yellow card (Red)</title>
                                                <path fill="#ecaa02" d="M243.2 275.2h428.8v588.8h-428.8v-588.8z">
                                                </path>
                                                <path fill="#a72018" d="M352 160h428.8v588.8h-428.8v-588.8z"></path>
                                            </svg>
                                        </span>
                                    </td>
                                    @endif
                                    @break
                                    @default
                                    @endswitch
                                    {{-- end inside switch --}}
                                </tr>
                                @break

                                @case("subst")
                                <tr>
                                    @if ($event->team->id == $teams->home->id)
                                    <td class="text-left">
                                        <span style="display: inline-block">
                                            <i class="fas fa-exchange-alt text-newinfo"></i>&nbsp;
                                            <span
                                                class="text-xs text-muted">{{$event->time->elapsed}}'</span>&nbsp;{{$event->player->name}}&nbsp;
                                            <small class="text-xs text-muted">Out: {{$event->assist->name}}</small>
                                        </span>
                                    </td>
                                    @else
                                    <td class="text-right">
                                        <span style="display: inline-block">
                                            <small class="text-xs text-muted">Out:
                                                {{$event->assist->name}}</small>&nbsp;{{$event->player->name}}&nbsp;
                                            <span class="text-xs text-muted">{{$event->time->elapsed}}'</span>&nbsp;
                                            <i class="fas fa-exchange-alt text-newinfo"></i>
                                        </span>
                                    </td>
                                    @endif
                                </tr>
                                @break

                                @default
                                @endswitch

                                @endforeach

                                @else
                                <tr>
                                    <td class="text-center" colspan="2">
                                        No data available
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>

                        </div>


                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background: #000;color:#fff;">
                                <th>
                                    {{$teams->home->name}}
                                </th>
                                <th></th>
                                <th>
                                    {{$teams->away->name}}
                                </th>
                            </thead>
                            <tbody class="msbdyx">
                                @if (!empty($match_statistics))
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[9]->value ? $match_statistics[0]->statistics[9]->value : '0%'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Posession</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[9]->value ? $match_statistics[1]->statistics[9]->value : '0%'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[13]->value ? $match_statistics[0]->statistics[13]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Total passes</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[13]->value ? $match_statistics[1]->statistics[13]->value : '0'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[2]->value ? $match_statistics[0]->statistics[2]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Total shots</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[2]->value ? $match_statistics[1]->statistics[2]->value : '0'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[0]->value ? $match_statistics[0]->statistics[0]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Shots on target</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[0]->value ? $match_statistics[1]->statistics[0]->value : '0'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[1]->value ? $match_statistics[0]->statistics[1]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Shots off target</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[1]->value ? $match_statistics[1]->statistics[1]->value : '0'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[7]->value ? $match_statistics[0]->statistics[7]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Corner kicks</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[7]->value ? $match_statistics[1]->statistics[7]->value : '0'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[8]->value ? $match_statistics[0]->statistics[8]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Offsides</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[8]->value ? $match_statistics[1]->statistics[8]->value :'0'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[6]->value ? $match_statistics[0]->statistics[6]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Fouls</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[6]->value ? $match_statistics[1]->statistics[6]->value : '0'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[10]->value ? $match_statistics[0]->statistics[10]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Yellow cards</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[10]->value ? $match_statistics[1]->statistics[10]->value : '0'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[11]->value ? $match_statistics[0]->statistics[11]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Red cards</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[11]->value ? $match_statistics[1]->statistics[11]->value : '0'}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-newinfo">
                                            {{$match_statistics[0]->statistics[12]->value ? $match_statistics[0]->statistics[12]->value : '0'}}
                                        </span>
                                    </td>
                                    <td class="text-center">Goalkeeper saves</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger">
                                            {{$match_statistics[1]->statistics[12]->value ? $match_statistics[1]->statistics[12]->value : '0'}}
                                        </span>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td class="text-center" colspan="3">
                                        No data available
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>

                        </div>


                    </div>
                </div>

                <!-- lineups tab content -->
                <div class="expendable tab-pane fade" id="nav-lineups{{$fixture->id}}" role="tabpanel" aria-labelledby="nav-lineups-tab">

                   {{-- Lineups --}}
                   <div class="mb-2">
                    <div class="card align-middle bg-dark text-white">
                        <h5 class="text-left p-2">Lineups</h5>
                    </div>
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table" style="width: 100%;">
                                <thead style="background: #1e0e52;color: #fff;">
                                    <th colspan="2" style="border-right: 28px solid rgb(96 96 96 / 28%);width:50%">
                                        {{$teams->home->name}} | {{!empty($lineups) ? $lineups[0]->formation : '-'}}
                                    </th>
                                    <th colspan="2" style="width:50%">
                                        {{$teams->away->name}} | {{!empty($lineups) ? $lineups[1]->formation : '-'}}
                                    </th>
                                </thead>
                                <tbody>
                                    @if (!empty($lineups))
                                    {{-- Starting XI --}}
                                    <tr class="thead-light">
                                        <th colspan="2" class="text-left"
                                            style="border-right: 28px solid rgb(96 96 96 / 28%);width:50%;background:#000;color:#fff;">Starting
                                            XI</th>
                                        <th colspan="2" class="text-left" style="background:#000;color:#fff;">Starting XI</th>
                                    </tr>
                                    @foreach ($lineups[0]?->startXI as $key => $startXI)
                                    <tr>
                                        <td style="background: antiquewhite;">{{$lineups[0]->startXI[$key]->player->number}}</td>
                                        <td class="text-left"
                                            style="border-right: 28px solid rgb(96 96 96 / 28%);width:50%;background: antiquewhite;">
                                            {{$lineups[0]->startXI[$key]->player->name}}
                                        </td>
                                        <td style="background: #add3f5;">{{$lineups[1]->startXI[$key]->player->number}}</td>
                                        <td class="text-left" style="background: #add3f5;">
                                            {{$lineups[1]->startXI[$key]->player->name}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    {{-- Substitutes --}}
                                    <tr class="thead-light">
                                        <th colspan="2" class="text-left"
                                            style="border-right: 28px solid rgb(96 96 96 / 28%);width:50%;background:#000;color:#fff;">
                                            Substitutes</th>
                                        <th colspan="2" class="text-left" style="background:#000;color:#fff;">Substitutes</th>
                                    </tr>
                                    @foreach ($lineups[0]->substitutes as $key => $subs)
                                    <tr>
                                        <td style="background: antiquewhite;">{{$lineups[0]->substitutes[$key]->player->number}}</td>
                                        <td class="text-left"
                                            style="border-right: 28px solid rgb(96 96 96 / 28%);width:50%;background: antiquewhite">
                                            {{$lineups[0]->substitutes[$key]->player->name}}
                                        </td>
                                        <td style="background: #add3f5;">
                                            @if (isset($lineups[1]->substitutes[$key]))
                                            {{$lineups[1]->substitutes[$key]->player->number}}
                                            @endif
                                        </td>
                                        <td class="text-left" style="background: #add3f5;">
                                            @if (isset($lineups[1]->substitutes[$key]))
                                            {{$lineups[1]->substitutes[$key]->player->name}}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="thead-light">
                                        <th colspan="2" class="text-left"
                                            style="border-right: 28px solid rgb(96 96 96 / 28%);width:50%;background:#000;color:#fff;">Coach
                                        </th>
                                        <th colspan="2" class="text-left" style="background:#000;color:#fff;">Coach</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-left"
                                            style="border-right: 28px solid rgb(96 96 96 / 28%);width:50%;background: antiquewhite">
                                            {{$lineups[0]->coach->name}}
                                        </td>
                                        <td colspan="2" class="text-left" style="background: #add3f5;">
                                            {{$lineups[1]->coach->name}}
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No data available
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- End of lineups --}}

                </div>

            </div>

            </div>
        </div>

        <!-- Submenu button end -->


        <!-- win probiblity start-->
        {{-- <p class="Progress_title text-center">Win probability</p>
        <div class="px-5">
            @php
                $predictions = json_decode(json_encode($predictions), true);
                $homePercentage = $predictions['predictions'][0]['predictions']['percent']['home'];
                $awayPercentage = $predictions['predictions'][0]['predictions']['percent']['away'];
            @endphp
            <div class="progress ">
            <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"><span class="progress-bar-text">{{ $homePercentage }}</span></div>
            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"><span class="progress-bar-text">{{ $awayPercentage }}</span></div>
            </div>
        </div> --}}
        <!-- win probiblity End -->



    </div>
    <div class="match__list_footer">
        <a href="#" class="match-preview-btn" data-id="{{ $fixture->id }}" type="button" data-toggle="collapse" data-target="#match_preivew{{ $fixture->id }}"> Match preview ❯ </a>
    </div>

    <div class="collapse" id="match_preivew{{ $fixture->id }}">
        <div class="text-center my-3" id="match-spinner">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>



<script>
predictionChart();
function predictionChart() {

const labels = ['Strength', 'Attacking Potential', 'Defensive Potential', 'Poisson Distribution',
    'Strength H2H',
    'Goals H2H', 'Wins the Game'
];

var home_data = @json($predictions['predictions_array']['home']);
var away_data = @json($predictions['predictions_array']['away']);

const data = {
    labels: labels,
    datasets: [{
            label: "{{ $predictions['predictions'][0]->teams->home->name }}",
            data: home_data,
            borderColor: '#12e5fa',
            backgroundColor: 'rgba(18, 229, 250, 0.5)',
        },
        {
            label: '{{ $predictions['predictions'][0]->teams->away->name }}',
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
    document.getElementById("predictionChart{{ $fixture->id }}"),
    config
);
}
</script>

