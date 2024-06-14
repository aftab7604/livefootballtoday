<?php

namespace App\Http\Controllers\PublicArea;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
// use GuzzleHttp\Psr7\Request;
use services\Callers\FixtureCaller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Cache;

class FixtureController extends Controller
{
    public function fixtures(Request $request)
    {
        $token = $request->get("token");
        // if(isset($token) && !empty($token)){
        //     echo "<pre>"; print_r($token); die;
        // }
        setcookie('date', Carbon::now()->format('Y-m-d'), time() + (86400 * 30), "/");

        return view('PublicArea.pages.fixtures.all-fixtures');
    }

    public function fixturesAjax()
    {
        $response['leagues'] = [];
        $response['fixtures'] = [];

        $data = FixtureCaller::getAllFixtures();

        $response['leagues'] = $data['leagues'];
        $response['fixtures'] = $data['fixtures'];
        $response['timezone'] = get_local_time();

        return view('PublicArea.pages.fixtures.all-fixtures-ajax')->with($response);
    }

    public function getFixture(int $id)
    {
        $response['id'] = $id;

        $data = FixtureCaller::getPredictions($id);

        $response['predictions'] = $data['predictions'];
        $response['predictions_array'] = $data['predictions_array'];

        return view('PublicArea.pages.fixtures.single-fixture')->with($response);
    }

    public function getFixtureAjax(int $id)
    {
        $data = FixtureCaller::getSingleFixture($id);

        if (!$data['status']) {
            return '<div class="col-md-12 mb-2">No results found</div>';
        }

        $response['fixture'] = $data['fixture'];
        $response['league'] = $data['league'];
        $response['teams'] = $data['teams'];
        $response['goals'] = $data['goals'];
        $response['score'] = $data['score'];
        $response['events'] = $data['events'];
        $response['lineups'] = $data['lineups'];
        $response['match_statistics'] = $data['match_statistics'];
        // $response['team_statistics'] = $data['team_statistics'];
        // $response['h2h'] = $data['h2h'];
        $response['predictions'] = $data['predictions'];
        // $response['standings'] = $data['standings'];
        // $response['form'] = $data['form'];
        $response['timezone'] = get_local_time();

        return view('PublicArea.pages.fixtures.single-fixture-ajax')->with($response);
    }

    public function getMatchInfo($id)
    {
        $response['id'] = $id;
        $response['api_key'] = config('app.football_api_key');

        return view('PublicArea.pages.fixtures.match-info')->with($response);
    }

    public function getMatchPreview(int $id)
    {
        $response['id'] = $id;
        $data = FixtureCaller::getPredictions($id);
        $response['predictions'] = $data['predictions'];
        $response['predictions_array'] = $data['predictions_array'];

        return view('PublicArea.pages.fixtures.single-match-preview')->with($response);
    }

    public function getMatchPreviewAjax(int $id)
    {
        $data = FixtureCaller::getForm($id);

        if (!$data['status']) {
            return '<div class="col-md-12 mb-2">No results found</div>';
        }

        $response['fixture'] = $data['fixture'];
        $response['league'] = $data['league'];
        $response['teams'] = $data['teams'];
        $response['goals'] = $data['goals'];
        $response['score'] = $data['score'];
        $response['events'] = $data['events'];
        $response['lineups'] = $data['lineups'];
        $response['match_statistics'] = $data['match_statistics'];
        $response['form'] = $data['form'];
        $response['timezone'] = get_local_time();
        // $response['injuries'] = $data['injuries'];
        // $response['players'] = $data['players'];

        return view('PublicArea.pages.fixtures.single-match-preview-ajax')->with($response);
    }


    public function getMatchStats($id){

        $data['overallstats'] = FixtureCaller::getTeamStats($id);
        $data['teamstats'] = FixtureCaller::getTeamMatchStats($id);
        $data['homestats'] = $data['teamstats']['home_stats'];
        $data['awaystats'] = $data['teamstats']['away_stats'];
        return view('PublicArea.pages.fixtures.team-stats-ajax')->with($data);

    }



    public function getHeadToHead(int $id)
    {
        $data = FixtureCaller::getHeadToHead($id);

        if (!$data['status']) {
            return '<div class="col-md-12 mb-2">No results found</div>';
        }

        $response['fixture'] = $data['fixture'];
        $response['league'] = $data['league'];
        $response['teams'] = $data['teams'];
        $response['goals'] = $data['goals'];
        $response['score'] = $data['score'];
        $response['events'] = $data['events'];
        $response['lineups'] = $data['lineups'];
        $response['match_statistics'] = $data['match_statistics'];
        $response['h2h'] = $data['h2h'];
        $response['timezone'] = get_local_time();

        return view('PublicArea.pages.fixtures.head-to-head-ajax')->with($response);
    }


    public function getStandings(int $id)
    {
        $data = FixtureCaller::getStandings($id);

        if (!$data['status']) {
            return '<div class="col-md-12 mb-2">No results found</div>';
        }

        $response['fixture'] = $data['fixture'];
        $response['league'] = $data['league'];
        $response['teams'] = $data['teams'];
        $response['goals'] = $data['goals'];
        $response['score'] = $data['score'];
        $response['events'] = $data['events'];
        $response['lineups'] = $data['lineups'];
        $response['match_statistics'] = $data['match_statistics'];
        $response['standings'] = $data['standings'];
        $response['timezone'] = get_local_time();

        return view('PublicArea.pages.fixtures.standings-ajax')->with($response);
    }


    // public function getPlayerStats($league_id){

    //     $season = request("season");
    //     $home_id = request("home_id");
    //     $away_id = request("away_id");

    //     $data['playerstats'] = FixtureCaller::getPlayerStats($league_id, $season, $home_id, $away_id);

    //     return view('PublicArea.pages.fixtures.player-stats-tab')->with($data);

    // }

    public function getPlayerStats(int $id)
    {
        $data = FixtureCaller::getPlayerStats($id);

        if (!$data['status']) {
            return '<div class="col-md-12 mb-2">No results found</div>';
        }

        $response['fixture'] = $data['fixture'];
        $response['league'] = $data['league'];
        $response['teams'] = $data['teams'];
        $response['goals'] = $data['goals'];
        $response['score'] = $data['score'];
        $response['events'] = $data['events'];
        $response['lineups'] = $data['lineups'];
        $response['match_statistics'] = $data['match_statistics'];
        $response['players'] = $data['players'];
        $response['timezone'] = get_local_time();

        return view('PublicArea.pages.fixtures.player-stats-tab')->with($data);
    }
    
    
     public function getProbabilities(int $id){

        $prediction = FixtureCaller::getOnlyPredictions($id);

        $homePercentage = $prediction->percent->home;
        $drawPercentage = $prediction->percent->draw;
        $awayPercentage = $prediction->percent->away;

        $homePercentage = intval(trim($homePercentage, "%"));
        $drawPercentage = intval(trim($drawPercentage, "%"));
        $awayPercentage = intval(trim($awayPercentage, "%"));

        $homeOdd = $homePercentage > 0 ? 100 / $homePercentage : 0;
        $drawOdd = $drawPercentage > 0 ? 100 / $drawPercentage : 0;
        $awayOdd = $awayPercentage > 0 ? 100 / $awayPercentage : 0;

        $odd1 = $homeOdd > 0 ? $homeOdd + 0.11 : 0;
        $oddx = $drawOdd > 0 ? $drawOdd + 0.2 : 0;
        $odd2 = $awayOdd > 0 ? $awayOdd + 0.08 : 0;


        $homePercent = $odd1 > 0 ? round(100 / $odd1, 0) : 0;
        $drawPercent = $oddx > 0 ? round(100 / $oddx, 0) : 0;
        $awayPercent = $odd2 > 0 ? round(100 / $odd2, 0) : 0;

        $score = get_score($homeOdd);

        $btts_yes_or_no = $score ? get_btts_yes_or_no($score) : "";
        $btts_yes = $btts_yes_or_no == "Yes" ? "Yes" : "No";
        $btts_no = $btts_yes_or_no == "No" ? "Yes" : "No";

        $u25_or_o25 = $score ? get_u25_or_o25($score) : "";
        $u25 = $u25_or_o25 == "U2.5" ? "Yes" : "No";
        $o25 = $u25_or_o25 == "O2.5" ? "Yes" : "No";

        $one_x_two  = $score ? get_1x2($score) : "";
        $one = $one_x_two == "1" ? "Yes" : "No";
        $x = $one_x_two == "X" ? "Yes" : "No";
        $two = $one_x_two == "2" ? "Yes" : "No";

        return response()->json([
            "btts_yes_or_no" => $btts_yes_or_no,
            "u25_or_o25" => $u25_or_o25,
            "one_x_two" => $one_x_two,
            "score" => $score,
            "btts_yes" => $btts_yes,
            "btts_no" => $btts_no,
            "u25" => $u25,
            "o25" => $o25,
            "homePercent" => $homePercent,
            "drawPercent" => $drawPercent,
            "awayPercent" => $awayPercent,
            "one" => $one,
            "x" => $x,
            "two" => $two
        ], 200);
    }
}
