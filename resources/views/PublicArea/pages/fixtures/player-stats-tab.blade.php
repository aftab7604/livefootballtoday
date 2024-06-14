<div class="row">
    {{-- Top home --}}
    
    <div class="col-md-6 mb-2">
        <div class="card align-middle bg-dark text-white">
            <h5 class="text-left p-2">
                <img src="{{ $teams->home->logo }}" alt="team-logo" class="img img-fluid"
                    style="width:30px; height:30px;">
                {{ $teams->home->name }}
            </h5>
        </div>
        
        <div class="card">
            <div class="card-body table-responsive" id="accordionExample">

                {{--  --}}
                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-goals-total"
                        data-toggle="collapse"
                        data-target="#collapse-top-goals-total{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-goals-total">
                        Top Goals Total
                    </div>

                    <div id="collapse-top-goals-total{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-goals-total" data-parent="#accordionExample">
                        <div class="card-body">
                            @forelse ($players['home']['top_goals_total'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle" width="70">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->goals->total }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-goals-assists"
                        data-toggle="collapse"
                        data-target="#collapse-top-goals-assists{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-goals-assists">
                        Top Goals Assists
                    </div>

                    <div id="collapse-top-goals-assists{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-goals-assists" data-parent="#accordionExample">
                        <div class="card-body">
                            @forelse ($players['home']['top_goals_assists'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle" width="70">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->goals->assists }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-shots-total"
                        data-toggle="collapse"
                        data-target="#collapse-top-shots-total{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-shots-total">
                        Top Shots Total
                    </div>

                    <div id="collapse-top-shots-total{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-shots-total" data-parent="#accordionExample">
                        <div class="card-body">
                            @forelse ($players['home']['top_shots_total'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle" width="70">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->shots->total }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-shots-on"
                        data-toggle="collapse"
                        data-target="#collapse-top-shots-on{{ $fixture->id }}" aria-expanded="true"
                        aria-controls="collapse-top-shots-on">
                        Top Shots On
                    </div>

                    <div id="collapse-top-shots-on{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-shots-on" data-parent="#accordionExample">
                        <div class="card-body">
                            @forelse ($players['home']['top_shots_on'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->shots->on }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-games-rating"
                        data-toggle="collapse"
                        data-target="#collapse-top-games-rating{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-games-rating">
                        Top Games Rating
                    </div>

                    <div id="collapse-top-games-rating{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-games-rating" data-parent="#accordionExample">
                        <div class="card-body">
                            @forelse ($players['home']['top_games_rating'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->games->rating }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-passes-key"
                        data-toggle="collapse"
                        data-target="#collapse-top-passes-key{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-passes-key">
                        Top Passes Key
                    </div>

                    <div id="collapse-top-passes-key{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-passes-key" data-parent="#accordionExample">
                        <div class="card-body">
                            @forelse ($players['home']['top_passes_key'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->passes->key }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-tackles-total"
                        data-toggle="collapse"
                        data-target="#collapse-top-tackles-total{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-tackles-total">
                        Top Tackles Total
                    </div>

                    <div id="collapse-top-tackles-total{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-tackles-total" data-parent="#accordionExample">
                        <div class="card-body">
                            @forelse ($players['home']['top_tackles_total'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->tackles->total }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-fouls-committed"
                        data-toggle="collapse"
                        data-target="#collapse-top-fouls-committed{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-fouls-committed">
                        Top Fouls Committed
                    </div>

                    <div id="collapse-top-fouls-committed{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-fouls-committed" data-parent="#accordionExample">
                        <div class="card-body">
                            @forelse ($players['home']['top_fouls_committed'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->fouls->committed }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-cards-yellow"
                        data-toggle="collapse"
                        data-target="#collapse-top-cards-yellow{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-cards-yellow">
                        Top Cards Yellow
                    </div>

                    <div id="collapse-top-cards-yellow{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-cards-yellow" data-parent="#accordionExample">
                        <div class="card-body">
                            @forelse ($players['home']['top_cards_yellow'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->cards->yellow }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>
                {{--  --}}
            </div>
        </div>
    </div>
    {{-- End of Top home --}}
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- inpage 1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="2694040895"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
    {{-- Top away --}}
    <div class="col-md-6 mb-2">
        <div class="card align-middle bg-dark text-white">
            <h5 class="text-left p-2">
                <img src="{{ $teams->away->logo }}" alt="team-logo" class="img img-fluid"
                    style="width:30px; height:30px;">
                {{ $teams->away->name }}
            </h5>
        </div>
        <div class="card">
            <div class="card-body table-responsive" id="accordionExample2">
                {{--  --}}
                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-goals-total2"
                        data-toggle="collapse"
                        data-target="#collapse-top-goals-total2{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-goals-total2">
                        Top Goals Total
                    </div>

                    <div id="collapse-top-goals-total2{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-goals-total2" data-parent="#accordionExample2">
                        <div class="card-body">
                            @forelse ($players['away']['top_goals_total'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->goals->total }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-goals-assists2"
                        data-toggle="collapse"
                        data-target="#collapse-top-goals-assists2{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-goals-assists2">
                        Top Goals Assists
                    </div>

                    <div id="collapse-top-goals-assists2{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-goals-assists2" data-parent="#accordionExample2">
                        <div class="card-body">
                            @forelse ($players['away']['top_goals_assists'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->goals->assists }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-shots-total2"
                        data-toggle="collapse"
                        data-target="#collapse-top-shots-total2{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-shots-total2">
                        Top Shots Total
                    </div>

                    <div id="collapse-top-shots-total2{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-shots-total2" data-parent="#accordionExample2">
                        <div class="card-body">
                            @forelse ($players['away']['top_shots_total'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->shots->total }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-shots-on2"
                        data-toggle="collapse"
                        data-target="#collapse-top-shots-on2{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-shots-on2">
                        Top Shots On
                    </div>

                    <div id="collapse-top-shots-on2{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-shots-on2" data-parent="#accordionExample2">
                        <div class="card-body">
                            @forelse ($players['away']['top_shots_on'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->shots->on }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-games-rating2"
                        data-toggle="collapse"
                        data-target="#collapse-top-games-rating2{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-games-rating2">
                        Top Games Rating
                    </div>

                    <div id="collapse-top-games-rating2{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-games-rating2" data-parent="#accordionExample2">
                        <div class="card-body">
                            @forelse ($players['away']['top_games_rating'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->games->rating }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-passes-key2"
                        data-toggle="collapse"
                        data-target="#collapse-top-passes-key2{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-passes-key2">
                        Top Passes Key
                    </div>

                    <div id="collapse-top-passes-key2{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-passes-key2" data-parent="#accordionExample2">
                        <div class="card-body">
                            @forelse ($players['away']['top_passes_key'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->passes->key }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-tackles-total2"
                        data-toggle="collapse"
                        data-target="#collapse-top-tackles-total2{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-tackles-total2">
                        Top Tackles Total
                    </div>

                    <div id="collapse-top-tackles-total2{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-tackles-total2" data-parent="#accordionExample2">
                        <div class="card-body">
                            @forelse ($players['away']['top_tackles_total'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->tackles->total }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-fouls-committed2"
                        data-toggle="collapse"
                        data-target="#collapse-top-fouls-committed2{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-fouls-committed2">
                        Top Fouls Committed
                    </div>

                    <div id="collapse-top-fouls-committed2{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-fouls-committed2"
                        data-parent="#accordionExample2">
                        <div class="card-body">
                            @forelse ($players['away']['top_fouls_committed'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->fouls->committed }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="player-stats card-header text-white" id="heading-top-cards-yellow2"
                        data-toggle="collapse"
                        data-target="#collapse-top-cards-yellow2{{ $fixture->id }}"
                        aria-expanded="true" aria-controls="collapse-top-cards-yellow2">
                        Top Cards Yellow
                    </div>

                    <div id="collapse-top-cards-yellow2{{ $fixture->id }}" class="collapse"
                        aria-labelledby="heading-top-cards-yellow2" data-parent="#accordionExample2">
                        <div class="card-body">
                            @forelse ($players['away']['top_cards_yellow'] as $k=>$v)
                                <div class="media">
                                    <img src="{{ $v->player->photo }}" alt="User Image"
                                        class="mr-3 user-image rounded-circle">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $v->player->name }}</h5>
                                        <p>{{ $v->statistics[0]->cards->yellow }}</p>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <h5>No Data</h5>
                            @endforelse

                        </div>
                    </div>
                </div>
                {{--  --}}
            </div>
        </div>
    </div>
    {{-- End of top away --}}

</div>
