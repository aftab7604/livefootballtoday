              

@if (count($leagues) > 0)

<style>
    .match_list.container{
        background: #fff;
        padding: 0 0 1rem;
        margin-bottom: 2rem;
        border-radius: 16px;
    }
    .match_list.container a.msbgtitle{
        background: #707070;
        float: left;
        width: 100%;
        border-radius: 16px 16px 0 0;
        padding: 10px 2rem;
        margin-bottom: 2rem;
        font-size: 18px;
        font-weight: 700;
        color: #fff;
    }
    .match_list.container a.msbgtitle p{
        margin: 0;
        display: flex;
        align-items: center;
    }
    .match_list.container a.msbgtitle img{
        width: 60px;
        height: 60px;
    }
    .match_list.container .card{
        margin: 0 2rem;
    }
    .match_list.container{
        max-width: 100% !important;
    }
  </style>

@foreach ($leagues as $key => $league)

<div class="match_list container">
    <?php
    if (session('paymentDetailSession')) {
        $userPlanObject = session('paymentDetailSession');
        $userObject = session('userSession');
        $userId = $userObject->id;
        //print_r($userPlanObject);
        if ($userPlanObject && isset($userPlanObject[0]->user_id)) {
            if ($userId == $userPlanObject[0]->user_id) {
            $hasPurchasedPlanss = $userPlanObject[0]->user_id;
            }else{
                $hasPurchasedPlanss = '';
            }
        }else{
            $hasPurchasedPlanss = '';
        }
    }else{
        $hasPurchasedPlanss = '';
    } 
    
    ?> 
    @if ($hasPurchasedPlanss == '') 
   
                                  
    </iframe>
    @endif
   <a class="msbgtitle" href="{{route('public.league.get', ['nation' => str_replace(' ','_', $fixtures[$key][0]->league->country),
                                'league_name' => str_replace(' ','_', $fixtures[$key][0]->league->name)])}}">
                                <p class="match__title"> {{$fixtures[$key][0]->league->country}} - {{$fixtures[$key][0]->league->name}}  <img src="{{$fixtures[$key][0]->league->logo}}"></p> <a/> 
                                
                                
                                 
   @if (session('success'))
    {{-- <div class="alert alert-success w-100 confirm_msgs">{{ session('success') }} --}}
 </div>
@endif
@if (session('failure'))
<div class="alert alert-danger w-100 confirm_msgs">{{ session('failure') }}</div>
@endif

    <div class="matchloop mb-4">
        @foreach ($fixtures[$key] as $fixture)
            <div class="card mb-2">
                <div class="card-header p-0" id="heading{{$fixture->fixture->id}}">
                    <h5 class="mb-0">
                        <button class="btn btn__match_list matchbtn" data-id="{{ $fixture->fixture->id }}" data-toggle="collapse" data-target="#collapse{{$fixture->fixture->id}}"
                        aria-expanded="true" aria-controls="collapse{{$fixture->fixture->id}}">
                            <div class="mx-1">
                                @switch($fixture->fixture->status->short)
                                    @case("CANC")
                                    
                                    <td class="minute novis">
                                        <div class="match-card match-current-minute">&nbsp;</div>
                                    </td>
                                    @break
                                    @case("NS")
                                    <td class="minute novis">
                                        <div class="match-card match-current-minute">&nbsp;</div>
                                    </td>
                                    @break
                                    @case("PST")
                                    <td class="minute novis">
                                        <div class="match-card match-current-minute">&nbsp;</div>
                                    </td>
                                    @break
                                    @case("TBD")
                                    <td class="minute novis">
                                        <div class="match-card match-current-minute">&nbsp;</div>
                                    </td>
                                    @break
                                    @case("1H")
                                    <td class="minute visible">
                                        <div class="match-card match-current-minute">{{$fixture->fixture->status->elapsed}}'</div>
                                    </td>
                                    @break
                                    @case("2H")
                                    <td class="minute visible">
                                        <div class="match-card match-current-minute">{{$fixture->fixture->status->elapsed}}'</div>
                                    </td>
                                    @break
                                    @case("ET")
                                    <td class="minute visible">
                                        <div class="match-card match-current-minute">{{$fixture->fixture->status->elapsed}}'</div>
                                    </td>
                                    @break
                                    @case("HT")
                                    <td class="minute visible">
                                        <div class="match-card match-current-minute">{{$fixture->fixture->status->short}}</div>
                                    </td>
                                    @break
                                    @default
                                    <td class="minute visible-2">
                                        <div class="match-card match-current-minute">{{$fixture->fixture->status->short}}</div>
                                    </td>
                                    @endswitch

                                <div class="d-flex align-items-center">
                                    <span>
                                        <img width="20" class="mr-1" src="{{$fixture->teams->home->logo}}" alt="">{{$fixture->teams->home->name}}
                                    </span>
                                    <span class="mx-2">vs</span>
                                    <span>
                                        <img width="20" class="mr-1" src="{{$fixture->teams->away->logo}}" alt="">{{$fixture->teams->away->name}}
                                    </span>
                                </div>
                                @switch($fixture->fixture->status->short)
                                @case("CANC")
                                <div class="schedule match_live">{{$fixture->fixture->status->short}}</div>
                                @break
                                @case("PST")
                                <div class="schedule match_live">{{$fixture->fixture->status->short}}</div>
                                @break
                                @case("TBD")
                                <div class="schedule match_live">{{$fixture->fixture->status->short}}</div>
                                @break
                                @case("NS")
                                <div class="schedule match_live">{{\carbon\carbon::parse($fixture->fixture->timestamp)->setTimezone($timezone)->format('H:i')}}</div>
                                @break
                                @default
                                <div class="schedule match_live">{{$fixture->goals->home}} - {{$fixture->goals->away}}</div>
                                @endswitch

                            </div>
                            <table class="probs-table pt-{{ $fixture->fixture->id }}" data-id="{{ $fixture->fixture->id }}">
                                <thead>
                                    {{-- <tr>
                                        <th colspan="3">Result Prob</th>
                                        <th colspan="2">U/O 2.5 Prob</th>
                                        <th colspan="2">BTTS Prob</th>
                                    </tr> --}}
                                    <tr>
                                        <th>O2.5</th>
                                        <th>1</th>
                                        <th>X</th>
                                        <th>2</th>
                                        <th>BTTS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="prob-tr-{{ $fixture->fixture->id }}">
                                        <td class="match_live">0</td>
                                        <td class="match_live">0</td>
                                        <td class="match_live">0</td>
                                        <td class="match_live">0</td>
                                        <td class="match_live">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </button>
                    </h5>
                </div>

                <div id="collapse{{$fixture->fixture->id}}" class="collapse" aria-labelledby="heading{{$fixture->fixture->id}}">
                    <div class="text-center my-3" id="fixture-spinner">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    {{-- <div class="card-body px-0">
                        
                        <!-- Team logos start -->
                        <div class="team__vs_t">
                            <div class="team1">
                            <img src="{{$fixture->teams->home->logo}}" alt="team_logo" />
                            </div>
                            <div class="team_score">
                            <div class="scr_highlight">
                                @switch($fixture->fixture->status->short)
                                @case("CANC")
                                    <span>{{$fixture->fixture->status->short}}</span>
                                @break
                                @case("PST")
                                    <span>{{$fixture->fixture->status->short}}</span>
                                @break
                                @case("TBD")
                                    <span>{{$fixture->fixture->status->short}}</span>
                                @break
                                @case("NS")
                                    <span>{{\carbon\carbon::parse($fixture->fixture->timestamp)->setTimezone($timezone)->format('H:i')}}</span>
                                @break
                                @default
                                    <span>{{$fixture->goals->home}}</span>-<span>{{$fixture->goals->away}}</span>
                                @endswitch

                            </div>
                            </div>
                            <div class="team2">
                            <img src="{{$fixture->teams->away->logo}}" alt="team_logo" />
                            </div>
                        </div>
                        <!-- Team logos End -->

                        <!-- Submenu button start -->
                        <div class="sub_view_btn">
                            <div class="container">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-overview-tab" data-toggle="tab" href="#nav-overview{{$fixture->fixture->id}}" role="tab" aria-controls="nav-overview" aria-selected="true">overview</a>
                                    <a class="nav-item nav-link" id="nav-match-tab" data-toggle="tab" href="#nav-match{{$fixture->fixture->id}}" role="tab" aria-controls="nav-match" aria-selected="false">match Center</a>
                                    <a class="nav-item nav-link" id="nav-lineups-tab" data-toggle="tab" href="#nav-lineups{{$fixture->fixture->id}}" role="tab" aria-controls="nav-lineups" aria-selected="false">lineups</a>
                                </div>
                            </nav>
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                
                                <!-- overview tab content -->
                                <div class="tab-pane fade show active" id="nav-overview{{$fixture->fixture->id}}" role="tabpanel" aria-labelledby="nav-overview-tab"> 
                                    Graph

                                </div>

                                <!-- match stats tab content -->
                                <div class="tab-pane fade" id="nav-match{{$fixture->fixture->id}}" role="tabpanel" aria-labelledby="nav-match-tab">
                                    <p class="display-4 text-center">Events endpoint</p>

                                    <div class="evnt_endpoint">

                                        <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>10’ Goal 1-0 watkins</td>
                                                    <td>16 Goal 1-1 Brown</td>
                                                </tr>
                                                <tr>
                                                    <td>87’ yellow card kamara </td>
                                                    <td>90’ yellow card Lewis</td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        </div>


                                        <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>60</td>
                                                    <td>possession</td>
                                                    <td>40</td>
                                                </tr>
                                                <tr>
                                                    <td>500</td>
                                                    <td>Passes</td>
                                                    <td>336</td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>shots</td>
                                                    <td>8</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>shots on target</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>shots off target</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>corners</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>offside</td>
                                                    <td>6</td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>fouls</td>
                                                    <td>6</td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        </div>


                                    </div>
                                </div>

                                <!-- lineups tab content -->
                                <div class="tab-pane fade" id="nav-lineups{{$fixture->fixture->id}}" role="tabpanel" aria-labelledby="nav-lineups-tab">

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td><b>Team A</b></td>
                                                <td><b>Team B</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Gk</td>
                                                <td>Gk</td>
                                            </tr>
                                            <tr>
                                                <td>rb</td>
                                                <td>rb</td>
                                            </tr>
                                            <tr>
                                                <td>cb</td>
                                                <td>cb</td>
                                            </tr>
                                            <tr>
                                                <td>lb</td>
                                                <td>lb</td>
                                            </tr>


                                        </tbody>
                                        </table>

                                    </div>

                                </div>

                            </div>

                            </div>
                        </div>

                        <!-- Submenu button end -->


                        <!-- win probiblity start-->
                        <p class="Progress_title text-center">Win probability </p>
                        <div class="px-5">
                            <div class="progress ">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"><span class="progress-bar-text">70%</span></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"><span class="progress-bar-text">30%</span></div>
                            </div>
                        </div>
                        <!-- win probiblity End -->



                    </div>
                    <div class="match__list_footer">
                        <a href="#" class="match-preview-btn" data-id="{{ $fixture->fixture->id }}" type="button" data-toggle="collapse" data-target="#match_preivew{{ $fixture->fixture->id }}"> Match preview ❯ </a>
                    </div>

                    <div class="collapse" id="match_preivew{{ $fixture->fixture->id }}">

                        <div class="sub_view_btn">
                            <div class="container">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-summary-tab" data-toggle="tab" href="#nav-summary{{ $fixture->fixture->id }}" role="tab" aria-controls="nav-summary" aria-selected="true">summary</a>
                                    <a class="nav-item nav-link" id="nav-stats-tab" data-toggle="tab" href="#nav-stats{{ $fixture->fixture->id }}" role="tab" aria-controls="nav-stats" aria-selected="false">Team stats</a>
                                    <a class="nav-item nav-link" id="nav-Player-tab" data-toggle="tab" href="#nav-Player{{ $fixture->fixture->id }}" role="tab" aria-controls="nav-Player" aria-selected="false">Player stats</a>
                                </div>
                            </nav>
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">

                                <!-- summary tab content -->
                                <div class="tab-pane fade show active" id="nav-summary{{ $fixture->fixture->id }}" role="tabpanel" aria-labelledby="nav-summary-tab">

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td><b>Team A</b></td>
                                                <td><b>Team B</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>team a 1-0 team c</td>
                                                <td>Team B 2-0 Team E</td>
                                            </tr>
                                            <tr>
                                                <td>Team D 2-2 Team A </td>
                                                <td>Team F 4-2 Team B</td>
                                            </tr>

                                        </tbody>
                                        </table>
                                    </div>

                                    <p class="display-4 text-center mt-2">Head 2 Head</p>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td class="text-left"><b>Team A</b></td>
                                                <td class="text-center"><b>2-2</b></td>
                                                <td class="text-right"><b>Team B</b></td>
                                            </tr>
                                        </thead>

                                        </table>
                                    </div>

                                    <p class="display-4 text-center mt-2">injuires</p>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td><b>Team A</b></td>
                                                <td><b>Team B</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>H. Lozano</td>
                                                <td>G. Martinelli</td>
                                            </tr>
                                            <tr>
                                                <td>J. Teze</td>
                                                <td></td>
                                            </tr>

                                        </tbody>

                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><b>Team A</b></td>
                                                <td>6666</td>
                                            </tr>
                                            <tr>
                                                <td><b>Team B</b></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><b>Team C</b></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><b>Team D</b></td>
                                                <td></td>
                                            </tr>
                                        </tbody>

                                        </table>
                                    </div>


                                </div>

                                <!-- Team stats tab content -->
                                <div class="tab-pane fade" id="nav-stats{{ $fixture->fixture->id }}" role="tabpanel" aria-labelledby="nav-stats-tab">

                                    Team stats

                                </div>

                                <!-- Player tab content -->
                                <div class="tab-pane fade" id="nav-Player{{ $fixture->fixture->id }}" role="tabpanel" aria-labelledby="nav-Player-tab">

                                    Player Tab

                                </div>

                            </div>

                            </div>
                        </div>

                    </div> --}}

                </div>
            </div>
        @endforeach
        
                        
                  
    </div>
  
 </div>

@endforeach
@else
    <p style="color: red;">No search leagues found.</p>
@endif
<script>
    var iframe = document.getElementsByTagName('iframe')[0];
    if (iframe) {
      iframe.setAttribute('style', 'width: 100% !important; float: left !important;');
    }
  </script>