<?php

namespace services\FixtureService;

use Carbon\Carbon;
use services\Callers\CurlCaller;
use services\Callers\LeagueCaller;
use Illuminate\Support\Facades\Cache;

class FixtureService
{
    protected $important_league_list;

    const URL = 'https://v3.football.api-sports.io';

    public function __construct()
    {
        $this->important_league_list = config('app.important_league_list');
    }

    public function getLeagues($id)
    {
        $leagues = [];

        $url = self::URL . '/leagues?team=' . $id;

        $resp = CurlCaller::get($url, []);

        if ($resp) {
            $leagues = $resp->response;
        }
        // else {
        //     return $this->getLeagues($id);
        // }

        return $leagues;
    }

    public function getAllFixtures()
    {
        if (isset($_COOKIE["date"])) {
            $date = $_COOKIE["date"];
        } else {
            $date = Carbon::now()->format('Y-m-d');
        }

        $url = self::URL . '/fixtures?date=' . $date;

        $resp = CurlCaller::get($url, []);

        $leagues_1 = [];
        $leagues_1_as = [];
        $leagues_2 = [];
        $leagues_2_as = [];
        $leagues_as = [];
        $response = [];

        if ($resp) {
            foreach ($resp->response as $key => $value) {
                if (in_array($value->league->id, $this->important_league_list)) {
                    if (!in_array($value->league->id, $leagues_1)) {
                        $leagues_1[$key] = $value->league->id;
                        $leagues_1_as[$value->league->id] = $value->league->name;
                    }
                } else {
                    if (!in_array($value->league->id, $leagues_2)) {
                        $leagues_2[$key] = $value->league->id;
                        $leagues_2_as[$value->league->id] = $value->league->country;
                    }
                }


                if (array_key_exists($value->league->id, $response)) {
                    array_push($response[$value->league->id], $value);
                } else {
                    $response[$value->league->id] = [$value];
                }
            }

            ksort($leagues_1_as);
            asort($leagues_2_as);
            $leagues_as = $leagues_1_as + $leagues_2_as;
        }
        // else {
        //     return $this->getAllFixtures();
        // }

        return ['leagues' => $leagues_as, 'fixtures' => $response];
    }

    public function getAllFilterFixtures()
    {
        // if (isset($_COOKIE["date"])) {
        //     $date = $_COOKIE["date"];
        // } else {
            $date = Carbon::now()->format('Y-m-d');
        // }

        $url = self::URL . '/fixtures?date=' . $date;

        $resp = CurlCaller::get($url, []);

        $leagues_1 = [];
        $leagues_1_as = [];
        $leagues_2 = [];
        $leagues_2_as = [];
        $leagues_as = [];
        $response = [];

        if ($resp) {
            foreach ($resp->response as $key => $value) {
                if (in_array($value->league->id, $this->important_league_list)) {
                    if (!in_array($value->league->id, $leagues_1)) {
                        $leagues_1[$key] = $value->league->id;
                        $leagues_1_as[$value->league->id] = $value->league->name;
                    }
                } else {
                    if (!in_array($value->league->id, $leagues_2)) {
                        $leagues_2[$key] = $value->league->id;
                        $leagues_2_as[$value->league->id] = $value->league->country;
                    }
                }


                if (array_key_exists($value->league->id, $response)) {
                    array_push($response[$value->league->id], $value);
                } else {
                    $response[$value->league->id] = [$value];
                }
            }

            ksort($leagues_1_as);
            asort($leagues_2_as);
            $leagues_as = $leagues_1_as + $leagues_2_as;
        }
        // else {
        //     return $this->getAllFixtures();
        // }

        return ['leagues' => $leagues_as, 'fixtures' => $response];
    }
    
    public function  getPlayers($id, $league, $season, $page, $players){

        $url = self::URL . '/players?team=' . $id . '&season=' . $season . '&league=' . $league . '&page=' . $page;

        $resp = CurlCaller::get($url, []);

        if ($resp) {

            if ($resp->results > 0) {
                $players = array_merge($players, $resp->response);
            }
            if ($resp->paging->current != $resp->paging->total) {
                $page++;
                return $this->getPlayers($id, $league, $season, $page, $players);
            }
        }
        // else {
        //     return $this->getPlayers($id, $league, $season, $page, $players);
        // }

        return $players;
    }

    public function sortPlayersByTop($data){
        $players = [];
        // Get the total number of players
        $numPlayers = count($data);

        $topGoalsTotal = $data;
        $topGoalsAssists = $data;
        $topShotsTotal = $data;
        $topShotsOn = $data;
        $topGamesRating = $data;
        $topPassesKey = $data;
        $topTacklesTotal = $data;
        $topFoulsCommitted = $data;
        $topCardsYellow = $data;


        // Perform bubble sort based on maximum goal total
        for ($i = 0; $i < $numPlayers - 1; $i++) {
            for ($j = 0; $j < $numPlayers - $i - 1; $j++) {
                $aGoalsTotal = !empty($topGoalsTotal[$j]->statistics[0]->goals->total) ? $topGoalsTotal[$j]->statistics[0]->goals->total : 0;
                $bGoalsTotal = !empty($topGoalsTotal[$j + 1]->statistics[0]->goals->total) ? $topGoalsTotal[$j + 1]->statistics[0]->goals->total : 0;

                if ($aGoalsTotal < $bGoalsTotal) {
                    // Swap the players if the current has fewer goals total than the next
                    $temp = $topGoalsTotal[$j];
                    $topGoalsTotal[$j] = $topGoalsTotal[$j + 1];
                    $topGoalsTotal[$j + 1] = $temp;
                }

                //======
                $aGoalsAssists = !empty($topGoalsAssists[$j]->statistics[0]->goals->assists) ? $topGoalsAssists[$j]->statistics[0]->goals->assists : 0;
                $bGoalsAssists = !empty($topGoalsAssists[$j + 1]->statistics[0]->goals->assists) ? $topGoalsAssists[$j + 1]->statistics[0]->goals->assists : 0;

                if ($aGoalsAssists < $bGoalsAssists) {
                    // Swap the players if the current has fewer goals assists than the next
                    $temp = $topGoalsAssists[$j];
                    $topGoalsAssists[$j] = $topGoalsAssists[$j + 1];
                    $topGoalsAssists[$j + 1] = $temp;
                }
                //======
                $aShotsTotal = !empty($topShotsTotal[$j]->statistics[0]->shots->total) ? $topShotsTotal[$j]->statistics[0]->shots->total : 0;
                $bShotsTotal = !empty($topShotsTotal[$j + 1]->statistics[0]->shots->total) ? $topShotsTotal[$j + 1]->statistics[0]->shots->total : 0;

                if ($aShotsTotal < $bShotsTotal) {
                    // Swap the players if the current has fewer shots total than the next
                    $temp = $topShotsTotal[$j];
                    $topShotsTotal[$j] = $topShotsTotal[$j + 1];
                    $topShotsTotal[$j + 1] = $temp;
                }
                //======
                $aShotsOn = !empty($topShotsOn[$j]->statistics[0]->shots->on) ? $topShotsOn[$j]->statistics[0]->shots->on : 0;
                $bShotsOn = !empty($topShotsOn[$j + 1]->statistics[0]->shots->on) ? $topShotsOn[$j + 1]->statistics[0]->shots->on : 0;

                if ($aShotsOn < $bShotsOn) {
                    // Swap the players if the current has fewer shots on than the next
                    $temp = $topShotsOn[$j];
                    $topShotsOn[$j] = $topShotsOn[$j + 1];
                    $topShotsOn[$j + 1] = $temp;
                }
                //======
                $aGamesRating = !empty($topGamesRating[$j]->statistics[0]->games->rating) ? $topGamesRating[$j]->statistics[0]->games->rating : 0;
                $bGamesRating = !empty($topGamesRating[$j + 1]->statistics[0]->games->rating) ? $topGamesRating[$j + 1]->statistics[0]->games->rating : 0;

                if ($aGamesRating < $bGamesRating) {
                    // Swap the players if the current has fewer rating than the next
                    $temp = $topGamesRating[$j];
                    $topGamesRating[$j] = $topGamesRating[$j + 1];
                    $topGamesRating[$j + 1] = $temp;
                }
                //======
                $aPassesKey = !empty($topPassesKey[$j]->statistics[0]->passes->key) ? $topPassesKey[$j]->statistics[0]->passes->key : 0;
                $bPassesKey = !empty($topPassesKey[$j + 1]->statistics[0]->passes->key) ? $topPassesKey[$j + 1]->statistics[0]->passes->key : 0;

                if ($aPassesKey < $bPassesKey) {
                    // Swap the players if the current has fewer passes key than the next
                    $temp = $topPassesKey[$j];
                    $topPassesKey[$j] = $topPassesKey[$j + 1];
                    $topPassesKey[$j + 1] = $temp;
                }
                //======
                $aTacklesTotal = !empty($topTacklesTotal[$j]->statistics[0]->tackles->total) ? $topTacklesTotal[$j]->statistics[0]->tackles->total : 0;
                $bTacklesTotal = !empty($topTacklesTotal[$j + 1]->statistics[0]->tackles->total) ? $topTacklesTotal[$j + 1]->statistics[0]->tackles->total : 0;

                if ($aTacklesTotal < $bTacklesTotal) {
                    // Swap the players if the current has fewer tackles total than the next
                    $temp = $topTacklesTotal[$j];
                    $topTacklesTotal[$j] = $topTacklesTotal[$j + 1];
                    $topTacklesTotal[$j + 1] = $temp;
                }
                //======
                $aFoulsCommitted = !empty($topFoulsCommitted[$j]->statistics[0]->fouls->committed) ? $topFoulsCommitted[$j]->statistics[0]->fouls->committed : 0;
                $bFoulsCommitted = !empty($topFoulsCommitted[$j + 1]->statistics[0]->fouls->committed) ? $topFoulsCommitted[$j + 1]->statistics[0]->fouls->committed : 0;

                if ($aFoulsCommitted < $bFoulsCommitted) {
                    // Swap the players if the current has fewer Fouls Committed than the next
                    $temp = $topFoulsCommitted[$j];
                    $topFoulsCommitted[$j] = $topFoulsCommitted[$j + 1];
                    $topFoulsCommitted[$j + 1] = $temp;
                }
                //======
                $aCardsYellow = !empty($topCardsYellow[$j]->statistics[0]->cards->yellow) ? $topCardsYellow[$j]->statistics[0]->cards->yellow : 0;
                $bCardsYellow = !empty($topCardsYellow[$j + 1]->statistics[0]->cards->yellow) ? $topCardsYellow[$j + 1]->statistics[0]->cards->yellow : 0;

                if ($aCardsYellow< $bCardsYellow) {
                    // Swap the players if the current has fewer Cards Yellow than the next
                    $temp = $topCardsYellow[$j];
                    $topCardsYellow[$j] = $topCardsYellow[$j + 1];
                    $topCardsYellow[$j + 1] = $temp;
                }
                //======


            }
        }

        for ($i = 0; $i < $numPlayers; $i++) {
            $GoalsTotal = $topGoalsTotal[$i]->statistics[0]->goals->total;
            if(empty($GoalsTotal) || $GoalsTotal == 0){
                unset($topGoalsTotal[$i]);
                array_values($topGoalsTotal);
            }
            //==
            $GoalsAssists = $topGoalsAssists[$i]->statistics[0]->goals->assists;
            if(empty($GoalsAssists) || $GoalsTotal == 0){
                unset($topGoalsAssists[$i]);
                array_values($topGoalsAssists);
            }
            //==
            $ShotsTotal = $topShotsTotal[$i]->statistics[0]->shots->total;
            if(empty($ShotsTotal) || $ShotsTotal == 0){
                unset($topShotsTotal[$i]);
                array_values($topShotsTotal);
            }
            //==
            $ShotsOn = $topShotsOn[$i]->statistics[0]->shots->on;
            if(empty($ShotsOn) || $ShotsOn == 0){
                unset($topShotsOn[$i]);
                array_values($topShotsOn);
            }
            //==
            $GamesRating = $topGamesRating[$i]->statistics[0]->games->rating;
            if(empty($GamesRating) || $GamesRating == 0){
                unset($topGamesRating[$i]);
                array_values($topGamesRating);
            }
            //==
            $PassesKey = $topPassesKey[$i]->statistics[0]->passes->key;
            if(empty($PassesKey) || $PassesKey == 0){
                unset($topPassesKey[$i]);
                array_values($topPassesKey);
            }
            //==
            $TacklesTotal = $topTacklesTotal[$i]->statistics[0]->tackles->total;
            if(empty($TacklesTotal) || $TacklesTotal == 0){
                unset($topTacklesTotal[$i]);
                array_values($topTacklesTotal);
            }
            //==
            $FoulsCommitted = $topFoulsCommitted[$i]->statistics[0]->fouls->committed;
            if(empty($FoulsCommitted) || $FoulsCommitted == 0){
                unset($topFoulsCommitted[$i]);
                array_values($topFoulsCommitted);
            }
            //==
            $CardsYellow = $topCardsYellow[$i]->statistics[0]->cards->yellow;
            if(empty($CardsYellow) || $CardsYellow == 0){
                unset($topCardsYellow[$i]);
                array_values($topCardsYellow);
            }
            //==

        }

        // return the sorted array
        $players['top_goals_total'] = $topGoalsTotal;
        $players['top_goals_assists'] = $topGoalsAssists;
        $players['top_shots_total'] = $topShotsTotal;
        $players['top_shots_on'] = $topShotsOn;
        $players['top_games_rating'] = $topGamesRating;
        $players['top_passes_key'] = $topPassesKey;
        $players['top_tackles_total'] = $topTacklesTotal;
        $players['top_fouls_committed'] = $topFoulsCommitted;
        $players['top_cards_yellow'] = $topCardsYellow;

        return $players;
    }

    public function getInjuries($response)
    {
        $injuries = [];

        $fixture = $response->fixture->id;

        $league = $response->league->id;
        $season = $response->league->season;

        $home_team = $response->teams->home->id;
        $away_team = $response->teams->away->id;
        $url_1 = self::URL . '/injuries?league=' . $league . '&season=' . $season .'&fixture=' . $fixture . '&team=' . $home_team;

        $resp_1 = CurlCaller::get($url_1, []);

        if ($resp_1) {
            $uniquePlayers = array();
            $final_resp =  array();
            foreach($resp_1->response as $k=>$v){
                if(!in_array($v->player->id,$uniquePlayers)){
                    $final_resp[] = $v;
                    $uniquePlayers[] = $v->player->id;
                }
            }
            $injuries['home'] = $final_resp;
            // $injuries['home'] = $resp_1->response;
        }
        // else {
        //     return $this->getTeamStatistics($response);
        // }

        $url_2 = self::URL . '/injuries?league=' . $league . '&season=' . $season . '&team=' . $away_team;

        $resp_2 = CurlCaller::get($url_2, []);

        if ($resp_2) {
            $uniquePlayers = array();
            $final_resp =  array();
            foreach($resp_2->response as $k=>$v){
                if(!in_array($v->player->id,$uniquePlayers)){
                    $final_resp[] = $v;
                    $uniquePlayers[] = $v->player->id;
                }
            }
            $injuries['away'] = $final_resp;
            // $injuries['away'] = $resp_2->response;
        }
        // else {
        //     return $this->getTeamStatistics($response);
        // }

        return $injuries;
    }

    public function getSingleFixture(int $id)
    {
        $url = self::URL . '/fixtures?id=' . $id;
        $resp = CurlCaller::get($url, []);

        $response = [];
        $fixture = null;
        $league = null;
        $teams = null;
        $goals = null;
        $score = null;
        $events = null;
        $lineups = null;
        $match_statistics = null;
        // $team_statistics = [];
        // $h2h = [];
        $predictions = [];
        // $standings = [];
        // $injuries = [];
        // $players = [];

        if ($resp) {
            if ($resp->results == 0) {
                return ['status' => false];
            }


            $response = $resp->response[0];
            $fixture = $resp->response[0]->fixture;
            Cache::put("fixture-$fixture->id", $resp);
            $league = $resp->response[0]->league;
            $teams = $resp->response[0]->teams;
            $goals = $resp->response[0]->goals;
            $score = $resp->response[0]->score;
            $events = $resp->response[0]->events;
            $lineups = $resp->response[0]->lineups;
            $match_statistics = $resp->response[0]->statistics;

            // $team_statistics = $this->getTeamStatistics($response,$id);
            // $h2h = $this->getH2H($response);
            $predictions = $this->getPredictions($id);
            // $standings = LeagueCaller::getStandings($league->id, $league->season);
            // $form = $this->getTeamForm($response);
            // $injuries =  $this->getInjuries($response);

            // $fixtureLeague = $response->league->id;
            // $fixtureSeason = $response->league->season;
            // $home_team = $response->teams->home->id;
            // $away_team = $response->teams->away->id;

            // $home_players = $this->getPlayers($home_team, $fixtureLeague, $fixtureSeason, 1, []);
            // $players['home'] = $this->sortPlayersByTop($home_players);

            // $away_players = $this->getPlayers($away_team, $fixtureLeague, $fixtureSeason, 1, []);
            // $players['away'] = $this->sortPlayersByTop($away_players);
            // $players['away'] = $this->sortPlayersByTop($this->getPlayers($away_team, $away_league, $away_season, 1, []));
        }
        //  else {
        //     return $this->getFixture($id);
        // }

        return [
            'status' => true,
            'fixture' => $fixture,
            'league' => $league,
            'teams' => $teams,
            'goals' => $goals,
            'score' => $score,
            'events' => $events,
            'lineups' => $lineups,
            'match_statistics' => $match_statistics,
            // 'team_statistics' => $team_statistics,
            // 'h2h' => $h2h,
            'predictions' => $predictions,
            // 'standings' => $standings,
            // 'form' => $form,
            // 'injuries'=> $injuries,
            // 'players'=>$players
        ];
    }

    public function getMatchFixture(int $id)
    {
        $resp = Cache::get("fixture-$id");

        if(!$resp){
            $url = self::URL . '/fixtures?id=' . $id;
            $resp = CurlCaller::get($url, []);
        }

        $response = [];
        $fixture = null;
        $league = null;
        $teams = null;
        $goals = null;
        $score = null;
        $events = null;
        $lineups = null;
        $match_statistics = null;
        // $team_statistics = [];
        $h2h = [];
        // $predictions = [];
        $standings = [];
        // $injuries = [];
        // $players = [];

        if ($resp) {
            if ($resp->results == 0) {
                return ['status' => false];
            }

            $response = $resp->response[0];
            $fixture = $resp->response[0]->fixture;
            $league = $resp->response[0]->league;
            $teams = $resp->response[0]->teams;
            $goals = $resp->response[0]->goals;
            $score = $resp->response[0]->score;
            $events = $resp->response[0]->events;
            $lineups = $resp->response[0]->lineups;
            $match_statistics = $resp->response[0]->statistics;

            // $team_statistics = $this->getTeamStatistics($response,$id);
            $h2h = $this->getH2H($response);
            // $predictions = $this->getPredictions($id);
            $standings = LeagueCaller::getStandings($league->id, $league->season);
            $form = $this->getTeamForm($response);
            // $injuries =  $this->getInjuries($response);

            // $fixtureLeague = $response->league->id;
            // $fixtureSeason = $response->league->season;
            // $home_team = $response->teams->home->id;
            // $away_team = $response->teams->away->id;

            // $home_players = $this->getPlayers($home_team, $fixtureLeague, $fixtureSeason, 1, []);
            // $players['home'] = $this->sortPlayersByTop($home_players);

            // $away_players = $this->getPlayers($away_team, $fixtureLeague, $fixtureSeason, 1, []);
            // $players['away'] = $this->sortPlayersByTop($away_players);
            // $players['away'] = $this->sortPlayersByTop($this->getPlayers($away_team, $away_league, $away_season, 1, []));
        }
        //  else {
        //     return $this->getFixture($id);
        // }

        return [
            'status' => true,
            'fixture' => $fixture,
            'league' => $league,
            'teams' => $teams,
            'goals' => $goals,
            'score' => $score,
            'events' => $events,
            'lineups' => $lineups,
            'match_statistics' => $match_statistics,
            // 'team_statistics' => $team_statistics,
            'h2h' => $h2h,
            // 'predictions' => $predictions,
            'standings' => $standings,
            'form' => $form,
            // 'injuries'=> $injuries,
            // 'players'=>$players
        ];
    }

    public function getFixture(int $id)
    {
        $url = self::URL . '/fixtures?id=' . $id;

        $resp = CurlCaller::get($url, []);

        $response = [];
        $fixture = null;
        $league = null;
        $teams = null;
        $goals = null;
        $score = null;
        $events = null;
        $lineups = null;
        $match_statistics = null;
        $team_statistics = [];
        $h2h = [];
        $predictions = [];
        $standings = [];
        $injuries = [];
        $players = [];

        if ($resp) {
            if ($resp->results == 0) {
                return ['status' => false];
            }

            $response = $resp->response[0];
            $fixture = $resp->response[0]->fixture;
            $league = $resp->response[0]->league;
            $teams = $resp->response[0]->teams;
            $goals = $resp->response[0]->goals;
            $score = $resp->response[0]->score;
            $events = $resp->response[0]->events;
            $lineups = $resp->response[0]->lineups;
            $match_statistics = $resp->response[0]->statistics;

            $team_statistics = $this->getTeamStatistics($response,$id);
            $h2h = $this->getH2H($response);
            $predictions = $this->getPredictions($id);
            $standings = LeagueCaller::getStandings($league->id, $league->season);
            $form = $this->getTeamForm($response);
            $injuries =  $this->getInjuries($response);

            $fixtureLeague = $response->league->id;
            $fixtureSeason = $response->league->season;
            $home_team = $response->teams->home->id;
            $away_team = $response->teams->away->id;

            $home_players = $this->getPlayers($home_team, $fixtureLeague, $fixtureSeason, 1, []);
            $players['home'] = $this->sortPlayersByTop($home_players);

            $away_players = $this->getPlayers($away_team, $fixtureLeague, $fixtureSeason, 1, []);
            $players['away'] = $this->sortPlayersByTop($away_players);
            // $players['away'] = $this->sortPlayersByTop($this->getPlayers($away_team, $away_league, $away_season, 1, []));
        }
        //  else {
        //     return $this->getFixture($id);
        // }

        return [
            'status' => true,
            'fixture' => $fixture,
            'league' => $league,
            'teams' => $teams,
            'goals' => $goals,
            'score' => $score,
            'events' => $events,
            'lineups' => $lineups,
            'match_statistics' => $match_statistics,
            'team_statistics' => $team_statistics,
            'h2h' => $h2h,
            'predictions' => $predictions,
            'standings' => $standings,
            'form' => $form,
            'injuries'=> $injuries,
            'players'=>$players
        ];
    }

    public function getTeamStatistics($response,$id ='')
    {
        $team_statistics = [];

        $league = $response->league->id;
        $season = $response->league->season;

        $home_team = $response->teams->home->id;
        $away_team = $response->teams->away->id;

        $url_1 = self::URL . '/teams/statistics?league=' . $league . '&season=' . $season . '&team=' . $home_team;

        $resp_1 = CurlCaller::get($url_1, []);

        if ($resp_1) {
            $team_statistics['home'] = $resp_1->response;
        }
        // else {
        //     return $this->getTeamStatistics($response);
        // }

        $url_2 = self::URL . '/teams/statistics?league=' . $league . '&season=' . $season . '&team=' . $away_team;

        $resp_2 = CurlCaller::get($url_2, []);

        if ($resp_2) {
            $team_statistics['away'] = $resp_2->response;
        }

        $url_2 = self::URL .'/fixtures/statistics?fixture='.$id.'&team='.$home_team;

        $resp_2 = CurlCaller::get($url_2, []);
        $team_statistics['home_team']=array();
        if ($resp_2) {
            $team_statistics['home_team'] =   $resp_2->response;
        }
        $url_2 = self::URL .'/fixtures/statistics?fixture='.$id.'&team='.$away_team;

        $resp_2 = CurlCaller::get($url_2, []);
        $team_statistics['away_team']=array();
        if ($resp_2) {
            $team_statistics['away_team'] =   $resp_2->response;
        }












// Now $team_season_statistics contains the season statistics for the specified team


        // else {
        //     return $this->getTeamStatistics($response);
        // }

        return $team_statistics;
    }

    public function getTeamForm($response)
    {
        $team_form = [];

        $season = $response->league->season;

        $home_team = $response->teams->home->id;
        $away_team = $response->teams->away->id;

        $url_1 = self::URL . '/fixtures?last=5&season=' . $season . '&team=' . $home_team;

        $resp_1 = CurlCaller::get($url_1, []);

        if ($resp_1) {
            $team_form['home'] = $resp_1->response;
        }
        // else {
        //     return $this->getTeamStatistics($response);
        // }

        $url_2 = self::URL . '/fixtures?last=5&season=' . $season . '&team=' . $away_team;

        $resp_2 = CurlCaller::get($url_2, []);

        if ($resp_2) {
            $team_form['away'] = $resp_2->response;
        }
        // else {
        //     return $this->getTeamStatistics($response);
        // }

        return $team_form;
    }

    public function getH2H($response)
    {
        $h2h = [];

        $home_team = $response->teams->home->id;
        $away_team = $response->teams->away->id;

        $url = self::URL . '/fixtures/headtohead?h2h=' . $home_team . '-' . $away_team . '&last=' . 5;

        $resp = CurlCaller::get($url, []);

        if ($resp) {
            $h2h = $resp->response;
        }
        // else {
        //     return $this->getH2H($response);
        // }

        return $h2h;
    }
    
    
    public function getOnlyPredictions($id){

        $cachedStats = Cache::get("probs-$id");
        if($cachedStats){
            return $cachedStats;
        }

        $predictions = [];

        $url = self::URL . '/predictions?fixture=' . $id;

        $resp = CurlCaller::get($url, []);

        if ($resp) {
            $predictions = $resp->response[0]->predictions;
        }

        $expiresAt = Carbon::now()->endOfDay();
        Cache::put("probs-$id", $predictions, $expiresAt);

        return $predictions;
    }

    public function getPredictions($id)
    {
        $predictions = [];

        $url = self::URL . '/predictions?fixture=' . $id;

        $resp = CurlCaller::get($url, []);

        if ($resp) {
            $predictions = $resp->response;
        }
        // else {
        //     return $this->getPredictions($id);
        // }
        $predictions_array = $this->getPredictionsArray($predictions);

        return ['predictions' => $predictions, 'predictions_array' => $predictions_array];
    }

    public function getPredictionsArray($predictions)
    {
        $predictions_array = [];

        foreach ($predictions as $prediction) {
            $i = 0;
            foreach ($prediction->comparison as  $comparison) {
                $predictions_array['home'][$i] = str_replace('%', '', $comparison->home);
                $predictions_array['away'][$i] = str_replace('%', '', $comparison->away);
                $i++;
            }
        }

        return $predictions_array;
    }


    public function getTeamStats(int $id){

        $cachedStats = Cache::get("teamstats-$id");
        if($cachedStats){
            return $cachedStats;
        }

        $resp = Cache::get("fixture-$id");

        if(!$resp){
            $url = self::URL . '/fixtures?id=' . $id;
            $resp = CurlCaller::get($url, []);
        }

        $league = $resp->response[0]->league;
        $teams = $resp->response[0]->teams;

        $league_id = $league->id;
        $season = $league->season;
        $home_id = $teams->home->id;
        $away_id = $teams->away->id;

        $url = self::URL . "/fixtures?league=$league_id&season=$season&team=$home_id";
        $fixRes = CurlCaller::get($url, []);
        $fixtureIds = [];
        $response = [];

        foreach ($fixRes->response as $i => $fresp) {
            array_push($fixtureIds, $fresp->fixture->id);
            if( (count($fixtureIds) == 20) || ($i+1 == count($fixRes->response)) ){
                $fixtureIds = implode("-", $fixtureIds);
                $url = self::URL . "/fixtures?ids=$fixtureIds";
                $resp = CurlCaller::get($url, []);
                $response = array_merge($response, $resp->response);
                $fixtureIds = [];
            }
        }
        // foreach($response as $res){
        //     echo "<pre>";
        //     print_r($res->statistics);
        //     echo "</pre>";
        // }
        // dd("OK");

        $teamStats = [
            "home_name" => $fixRes->response[0]->teams->home->name,
            "home_total" => count($fixRes->response),
            "away_name" => '',
            "away_total" => 0,
            "home" => [
                "Shots on Goal" => 0,
                "Shots off Goal" => 0,
                "Total Shots" => 0,
                "Blocked Shots" => 0,
                "Shots insidebox" => 0,
                "Shots outsidebox" => 0,
                "Fouls" => 0,
                "Corner Kicks" => 0,
                "Offsides" => 0,
                "Ball Possession" => 0,
                "Yellow Cards" => 0,
                "Red Cards" => 0,
                "Goalkeeper Saves" => 0,
                "Total passes" => 0,
                "Passes accurate" => 0,
                "Passes %" => 0
            ],
            "away" => [
                "Shots on Goal" => 0,
                "Shots off Goal" => 0,
                "Total Shots" => 0,
                "Blocked Shots" => 0,
                "Shots insidebox" => 0,
                "Shots outsidebox" => 0,
                "Fouls" => 0,
                "Corner Kicks" => 0,
                "Offsides" => 0,
                "Ball Possession" => 0,
                "Yellow Cards" => 0,
                "Red Cards" => 0,
                "Goalkeeper Saves" => 0,
                "Total passes" => 0,
                "Passes accurate" => 0,
                "Passes %" => 0
            ],

        ];

        foreach ($response as $cres) {

            if($cres->statistics && count($cres->statistics) > 0){
                if(count($cres->statistics) > 0 && $cres->statistics[0]->statistics && $cres->statistics[0]->team->id == $home_id){
                    foreach ($cres->statistics[0]->statistics as $hstat) {
                        if($hstat->value && is_int($hstat->value))
                        $teamStats['home'][$hstat->type] = $teamStats['home'][$hstat->type] + $hstat->value;
                    }
                }elseif(count($cres->statistics) > 0 && $cres->statistics[1]->statistics){
                    foreach ($cres->statistics[1]->statistics as $hstat) {
                        if($hstat->value && is_int($hstat->value))
                        $teamStats['home'][$hstat->type] = $teamStats['home'][$hstat->type] + $hstat->value;
                    }
                }

            }

        }

        $url = self::URL . "/fixtures?league=$league_id&season=$season&team=$away_id";
        $fixRes = CurlCaller::get($url, []);
        $fixtureIds = [];
        $response = [];

        $teamStats['away_name'] = $fixRes->response[0]->teams->away->name;
        $teamStats['away_total'] = count($fixRes->response);

        foreach ($fixRes->response as $i => $fresp) {
            array_push($fixtureIds, $fresp->fixture->id);
            if( (count($fixtureIds) == 20) || ($i+1 == count($fixRes->response)) ){
                $fixtureIds = implode("-", $fixtureIds);
                $url = self::URL . "/fixtures?ids=$fixtureIds";
                $resp = CurlCaller::get($url, []);
                $response = array_merge($response, $resp->response);
                $fixtureIds = [];
            }
        }

        foreach ($response as $cres) {

            if($cres->statistics && count($cres->statistics) > 0){

                if(count($cres->statistics) > 0 && $cres->statistics[0]->statistics && $cres->statistics[0]->team->id == $away_id){
                    foreach ($cres->statistics[0]->statistics as $astat) {
                        if($astat->value && is_int($astat->value))
                        $teamStats['away'][$astat->type] = $teamStats['away'][$astat->type] + $astat->value;
                    }
                }elseif(count($cres->statistics) > 0 && $cres->statistics[1]->statistics){
                    foreach ($cres->statistics[1]->statistics as $astat) {
                        if($astat->value && is_int($astat->value))
                        $teamStats['away'][$astat->type] = $teamStats['away'][$astat->type] + $astat->value;
                    }
                }

            }

        }

        $expiresAt = Carbon::now()->endOfDay();
        Cache::put("teamstats-$id", $teamStats, $expiresAt);
        return $teamStats;
        // $match_statistics = $resp->response[0]->statistics;

    }


    public function getTeamMatchStats(int $id){

        $cachedStats = Cache::get("matchstats-$id");
        if($cachedStats){
            return $cachedStats;
        }

        $resp = Cache::get("fixture-$id");

        if(!$resp){
            $url = self::URL . '/fixtures?id=' . $id;
            $resp = CurlCaller::get($url, []);
        }

        $league = $resp->response[0]->league;
        $teams = $resp->response[0]->teams;

        $league_id = $league->id;
        $season = $league->season;
        $home_id = $teams->home->id;
        $away_id = $teams->away->id;

        $url = self::URL . "/fixtures?league=$league_id&season=$season&team=$home_id";
        $fixRes = CurlCaller::get($url, []);
        $fixtureIds = [];
        $response = [];

        foreach ($fixRes->response as $i => $fresp) {
            array_push($fixtureIds, $fresp->fixture->id);
            if( (count($fixtureIds) == 20) || ($i+1 == count($fixRes->response)) ){
                $fixtureIds = implode("-", $fixtureIds);
                $url = self::URL . "/fixtures?ids=$fixtureIds";
                $resp = CurlCaller::get($url, []);
                $response = array_merge($response, $resp->response);
                $fixtureIds = [];
            }
        }


        $url = self::URL . "/teams/statistics?league=$league_id&season=$season&team=$home_id";
        $homeRes = CurlCaller::get($url, []);

        $url = self::URL . "/teams/statistics?league=$league_id&season=$season&team=$away_id";
        $awayRes = CurlCaller::get($url, []);

        $teamStats = [
            "home_stats" => $homeRes->response,
            "away_stats" => $awayRes->response,
            "home_name" => $fixRes->response[0]->teams->home->name,
            "home_total" => count($fixRes->response),
            "away_name" => '',
            "away_total" => 0,
            "home" => [
                "Shots on Goal" => 0,
                "Shots off Goal" => 0,
                "Total Shots" => 0,
                "Blocked Shots" => 0,
                "Shots insidebox" => 0,
                "Shots outsidebox" => 0,
                "Fouls" => 0,
                "Corner Kicks" => 0,
                "Offsides" => 0,
                "Ball Possession" => 0,
                "Yellow Cards" => 0,
                "Red Cards" => 0,
                "Goalkeeper Saves" => 0,
                "Total passes" => 0,
                "Passes accurate" => 0,
                "Passes %" => 0
            ],
            "away" => [
                "Shots on Goal" => 0,
                "Shots off Goal" => 0,
                "Total Shots" => 0,
                "Blocked Shots" => 0,
                "Shots insidebox" => 0,
                "Shots outsidebox" => 0,
                "Fouls" => 0,
                "Corner Kicks" => 0,
                "Offsides" => 0,
                "Ball Possession" => 0,
                "Yellow Cards" => 0,
                "Red Cards" => 0,
                "Goalkeeper Saves" => 0,
                "Total passes" => 0,
                "Passes accurate" => 0,
                "Passes %" => 0
            ],

        ];

        foreach ($response as $cres) {

            if($cres->statistics && count($cres->statistics) > 0){
                if(count($cres->statistics) > 0 && $cres->statistics[0]->statistics && $cres->statistics[0]->team->id == $home_id){
                    foreach ($cres->statistics[0]->statistics as $hstat) {
                        if($hstat->value && is_int($hstat->value))
                        $teamStats['home'][$hstat->type] = $teamStats['home'][$hstat->type] + $hstat->value;
                    }
                }

            }

        }

        $url = self::URL . "/fixtures?league=$league_id&season=$season&team=$away_id";
        $fixRes = CurlCaller::get($url, []);
        $fixtureIds = [];
        $response = [];

        $teamStats['away_name'] = $fixRes->response[0]->teams->away->name;
        $teamStats['away_total'] = count($fixRes->response);

        foreach ($fixRes->response as $i => $fresp) {
            array_push($fixtureIds, $fresp->fixture->id);
            if( (count($fixtureIds) == 20) || ($i+1 == count($fixRes->response)) ){
                $fixtureIds = implode("-", $fixtureIds);
                $url = self::URL . "/fixtures?ids=$fixtureIds";
                $resp = CurlCaller::get($url, []);
                $response = array_merge($response, $resp->response);
                $fixtureIds = [];
            }
        }

        foreach ($response as $cres) {

            if($cres->statistics && count($cres->statistics) > 0){

                if(count($cres->statistics) > 0 && $cres->statistics[0]->statistics && $cres->statistics[0]->team->id == $away_id){
                    foreach ($cres->statistics[0]->statistics as $astat) {
                        if($astat->value && is_int($astat->value))
                        $teamStats['away'][$astat->type] = $teamStats['away'][$astat->type] + $astat->value;
                    }
                }

            }

        }

        $expiresAt = Carbon::now()->endOfDay();
        Cache::put("matchstats-$id", $teamStats, $expiresAt);

        return $teamStats;
        // $match_statistics = $resp->response[0]->statistics;

    }

    public function getPlayerStats(int $id)
    {
        $cachedStats = Cache::get("playerstats-$id");
        if($cachedStats){
            return $cachedStats;
        }

        $resp = Cache::get("fixture-$id");

        if(!$resp){
            $url = self::URL . '/fixtures?id=' . $id;
            $resp = CurlCaller::get($url, []);
        }

        $response = [];
        $fixture = null;
        $league = null;
        $teams = null;
        $goals = null;
        $score = null;
        $events = null;
        $lineups = null;
        $match_statistics = null;

        if ($resp) {
            if ($resp->results == 0) {
                return ['status' => false];
            }

            $response = $resp->response[0];
            $fixture = $resp->response[0]->fixture;
            $league = $resp->response[0]->league;
            $teams = $resp->response[0]->teams;
            $goals = $resp->response[0]->goals;
            $score = $resp->response[0]->score;
            $events = $resp->response[0]->events;
            $lineups = $resp->response[0]->lineups;
            $match_statistics = $resp->response[0]->statistics;

            $fixtureLeague = $response->league->id;
            $fixtureSeason = $response->league->season;
            $home_team = $response->teams->home->id;
            $away_team = $response->teams->away->id;

            $home_players = $this->getPlayers($home_team, $fixtureLeague, $fixtureSeason, 1, []);
            $players['home'] = $this->sortPlayersByTop($home_players);

            $away_players = $this->getPlayers($away_team, $fixtureLeague, $fixtureSeason, 1, []);
            $players['away'] = $this->sortPlayersByTop($away_players);

        }

        $playerstats = [
            'status' => true,
            'fixture' => $fixture,
            'league' => $league,
            'teams' => $teams,
            'goals' => $goals,
            'score' => $score,
            'events' => $events,
            'lineups' => $lineups,
            'match_statistics' => $match_statistics,
            'players'=>$players
        ];

        $expiresAt = Carbon::now()->endOfDay();
        Cache::put("playerstats-$id", $playerstats, $expiresAt);

        return $playerstats;
    }

    public function getForm(int $id)
    {
        $resp = Cache::get("fixture-$id");

        if(!$resp){
            $url = self::URL . '/fixtures?id=' . $id;
            $resp = CurlCaller::get($url, []);
        }

        $response = [];
        $fixture = null;
        $league = null;
        $teams = null;
        $goals = null;
        $score = null;
        $events = null;
        $lineups = null;
        $match_statistics = null;

        if ($resp) {
            if ($resp->results == 0) {
                return ['status' => false];
            }

            $response = $resp->response[0];
            $fixture = $resp->response[0]->fixture;
            $league = $resp->response[0]->league;
            $teams = $resp->response[0]->teams;
            $goals = $resp->response[0]->goals;
            $score = $resp->response[0]->score;
            $events = $resp->response[0]->events;
            $lineups = $resp->response[0]->lineups;
            $match_statistics = $resp->response[0]->statistics;

            $form = $this->getTeamForm($response);

        }


        return [
            'status' => true,
            'fixture' => $fixture,
            'league' => $league,
            'teams' => $teams,
            'goals' => $goals,
            'score' => $score,
            'events' => $events,
            'lineups' => $lineups,
            'match_statistics' => $match_statistics,
            'form' => $form,
        ];
    }

    public function getStandings(int $id)
    {
        $cachedStats = Cache::get("standings-$id");
        if($cachedStats){
            return $cachedStats;
        }

        $resp = Cache::get("fixture-$id");

        if(!$resp){
            $url = self::URL . '/fixtures?id=' . $id;
            $resp = CurlCaller::get($url, []);
        }

        $response = [];
        $fixture = null;
        $league = null;
        $teams = null;
        $goals = null;
        $score = null;
        $events = null;
        $lineups = null;
        $match_statistics = null;
        $standings = [];

        if ($resp) {
            if ($resp->results == 0) {
                return ['status' => false];
            }

            $response = $resp->response[0];
            $fixture = $resp->response[0]->fixture;
            $league = $resp->response[0]->league;
            $teams = $resp->response[0]->teams;
            $goals = $resp->response[0]->goals;
            $score = $resp->response[0]->score;
            $events = $resp->response[0]->events;
            $lineups = $resp->response[0]->lineups;
            $match_statistics = $resp->response[0]->statistics;

            $standings = LeagueCaller::getStandings($league->id, $league->season);

        }

        $standingstats = [
            'status' => true,
            'fixture' => $fixture,
            'league' => $league,
            'teams' => $teams,
            'goals' => $goals,
            'score' => $score,
            'events' => $events,
            'lineups' => $lineups,
            'match_statistics' => $match_statistics,
            'standings' => $standings,
        ];

        $expiresAt = Carbon::now()->endOfDay();
        Cache::put("standings-$id", $standingstats, $expiresAt);

        return $standingstats;
    }

    public function getHeadToHead(int $id)
    {
        $cachedStats = Cache::get("h2h-$id");
        if($cachedStats){
            return $cachedStats;
        }

        $resp = Cache::get("fixture-$id");

        if(!$resp){
            $url = self::URL . '/fixtures?id=' . $id;
            $resp = CurlCaller::get($url, []);
        }

        $response = [];
        $fixture = null;
        $league = null;
        $teams = null;
        $goals = null;
        $score = null;
        $events = null;
        $lineups = null;
        $match_statistics = null;
        $h2h = [];

        if ($resp) {
            if ($resp->results == 0) {
                return ['status' => false];
            }

            $response = $resp->response[0];
            $fixture = $resp->response[0]->fixture;
            $league = $resp->response[0]->league;
            $teams = $resp->response[0]->teams;
            $goals = $resp->response[0]->goals;
            $score = $resp->response[0]->score;
            $events = $resp->response[0]->events;
            $lineups = $resp->response[0]->lineups;
            $match_statistics = $resp->response[0]->statistics;

            $h2h = $this->getH2H($response);

        }

        $h2h = [
            'status' => true,
            'fixture' => $fixture,
            'league' => $league,
            'teams' => $teams,
            'goals' => $goals,
            'score' => $score,
            'events' => $events,
            'lineups' => $lineups,
            'match_statistics' => $match_statistics,
            'h2h' => $h2h,
        ];

        $expiresAt = Carbon::now()->endOfDay();
        Cache::put("h2h-$id", $h2h, $expiresAt);

        return $h2h;
    }
}
