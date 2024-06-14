<div class="row table-row m-0">
    <div class="col-md-12 bg-12 py-2 px-0">
        <div class="row m-0">
            <div class="col-md-6 col-left-x text-left">
              <h2><img class="team-logo-h2h" src="{{ $homestats->team->logo }}" alt="home" style="width:50px;height:50px"> {{ $homestats->team->name }}  overall stats </h2>
            </div>
            <div class="col-md-6 col-right-x text-right">
               <h2><img class="team-logo-h2h" src="{{ $awaystats->team->logo }}" alt="home" style="width:50px;height:50px"> {{ $awaystats->team->name }} overall stats </h2>
            </div>
          </div>
    </div>
    {{--  <div class="col-md-12 text-center py-2">
        <h2>Played: <span class="font-number">10</span></h2>
    </div>
    <div class="col-md-12 text-center p-0 bg-12">
        <div class="row m-0">
            <div class="col-md-4 text-center bg-gre py-2">
              <h2>Wins<br><span class="font-number">8</span></h2>
            </div>
            <div class="col-md-4 text-center py-2">
                <h2>Draws<br><span class="font-number">1</span></h2>
            </div>
            <div class="col-md-4 text-center py-2">
                <h2>Wins<br><span class="font-number">1</span></h2>
            </div>
        </div>
    </div>  --}}



    <div class="col-md-12 p-0 table-12">
        <table class="table table-striped table-hover">
            <thead class="bg-12">
                <tr>
                    <th>Total</th>
                    <th>Per Match</th>
                    <th></th>
                    <th>Per Macth</th>
                    <th>Total</th>

                </tr>
            </thead>

            <tbody>


                <tr>
                    <td><span class="badge badge-info">{{ $homestats->fixtures->played->total }}</span></td>
                    <td>-</td>
                    <td>Total Match</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ $awaystats->fixtures->played->total }}</span></td>
                </tr>
                <tr>
                    <td><span class="badge badge-info">{{ $homestats->fixtures->wins->total }}</span></td>
                    <td>-</td>
                    <td>Total Win</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ $awaystats->fixtures->wins->total }}</span></td>
                </tr>

                <tr>
                    <td><span class="badge badge-info">{{ $homestats->fixtures->loses->total }}</span></td>
                    <td>-</td>
                    <td>Total lost</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ $awaystats->fixtures->loses->total }}</span></td>
                </tr>

                <tr>
                    <td><span class="badge badge-info">{{ $homestats->fixtures->draws->total }}</span></td>
                    <td>-</td>
                    <td>Total draw</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ $awaystats->fixtures->draws->total }}</span></td>
                </tr>

                <tr>
                    <td><span class="badge badge-info">{{ $homestats->goals->for->total->total }}</span></td>
                    <td>{{ $homestats->goals->for->average->total }}</td>
                    <td>Goals</td>
                    <td>{{ $awaystats->goals->for->average->total }}</td>
                    <td><span class="badge badge-danger">{{ $awaystats->goals->for->total->total }}</span></td>
                </tr>


                <tr>
                    <td><span class="badge badge-info">{{ $homestats->goals->against->total->total }}</span></td>
                    <td>{{ $homestats->goals->against->average->total }}</td>
                    <td>Goals Conceded</td>
                    <td>{{ $awaystats->goals->against->average->total }}</td>
                    <td><span class="badge badge-danger">{{ $awaystats->goals->against->total->total }}</span></td>
                </tr>

                <tr>
                    <td><span class="badge badge-info">{{ !empty($homestats->clean_sheet->home) ? $homestats->clean_sheet->home : 0 }}</span></td>
                    <td>-</td>
                    <td>Clean Sheets</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ !empty($awaystats->clean_sheet->home) ? $awaystats->clean_sheet->home : 0 }}</span></td>
                </tr>


                @foreach ($overallstats['home'] as $key => $val)
                    <tr>
                        <td>
                            <span class="badge badge-info">
                            {{ $overallstats['home'][$key] }}
                            </span>
                        </td>
                        <td>{{ $homestats->fixtures->played->total > 0 ? round($overallstats['home'][$key] / $homestats->fixtures->played->total, 2) : 0 }}</td>
                        <td>{{ $key }}</td>
                        <td>{{ $awaystats->fixtures->played->total > 0 ? round($overallstats['away'][$key] / $awaystats->fixtures->played->total, 2) : 0 }}</td>
                        <td>
                            <span class="badge badge-danger">
                            {{ $overallstats['away'][$key] }}
                            </span>
                        </td>
                    </tr>
                @endforeach

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6504405400600762"
     crossorigin="anonymous"></script>
<!-- stat page -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6504405400600762"
     data-ad-slot="2432388266"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
            </tbody>
        </table>
</div>

<h2 class="mt-3">Home & away stats</h2>
<div class="row table-row m-0">
    <div class="col-md-12 bg-12 py-2 px-0">

        <div class="row m-0">
            <div class="col-md-6 col-left-x text-left">
              <h2><img class="team-logo-h2h" src="{{ $homestats->team->logo }}" alt="home" style="width:50px;height:50px"> {{ $homestats->team->name }} Home stats</h2>
            </div>
            <div class="col-md-6 col-right-x text-right">
               <h2><img class="team-logo-h2h" src="{{ $awaystats->team->logo }}" alt="home" style="width:50px;height:50px"> {{ $awaystats->team->name }} Away stats</h2>
            </div>
          </div>
    </div>
    <div class="col-md-12 p-0 table-12">
        <table class="table table-striped table-hover">
            <thead class="bg-12">
                <tr>
                    <th>Total</th>
                    <th>Per Match</th>
                    <th></th>
                    <th>Per Macth</th>
                    <th>Total</th>

                </tr>
            </thead>
            <tbody>


                <tr>
                    <td><span class="badge badge-info">{{ $homestats->fixtures->played->home }}</span></td>
                    <td>-</td>
                    <td>Total Match</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ $awaystats->fixtures->played->away }}</span></td>
                </tr>
                <tr>
                    <td><span class="badge badge-info">{{ $homestats->fixtures->wins->home }}</span></td>
                    <td>-</td>
                    <td>Total Win</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ $awaystats->fixtures->wins->away }}</span></td>
                </tr>

                <tr>
                    <td><span class="badge badge-info">{{ $homestats->fixtures->loses->home }}</span></td>
                    <td>-</td>
                    <td>Total lost</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ $awaystats->fixtures->loses->away }}</span></td>
                </tr>

                <tr>
                    <td><span class="badge badge-info">{{ $homestats->fixtures->draws->home }}</span></td>
                    <td>-</td>
                    <td>Total draw</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ $awaystats->fixtures->draws->away }}</span></td>
                </tr>

                <tr>
                    <td><span class="badge badge-info">{{ $homestats->goals->for->total->home }}</span></td>
                    <td>{{ $homestats->goals->for->average->home }}</td>
                    <td>Goals</td>
                    <td>{{ $awaystats->goals->for->average->away }}</td>
                    <td><span class="badge badge-danger">{{ $awaystats->goals->for->total->away }}</span></td>
                </tr>


                <tr>
                    <td><span class="badge badge-info">{{ $homestats->goals->against->total->home }}</span></td>
                    <td>{{ $homestats->goals->against->average->home }}</td>
                    <td>Goals Conceded</td>
                    <td>{{ $awaystats->goals->against->average->away }}</td>
                    <td><span class="badge badge-danger">{{ $awaystats->goals->against->total->away }}</span></td>
                </tr>

                <tr>
                    <td><span class="badge badge-info">{{ !empty($homestats->clean_sheet->home) ? $homestats->clean_sheet->home : 0 }}</span></td>
                    <td>-</td>
                    <td>Clean Sheets</td>
                    <td>-</td>
                    <td><span class="badge badge-danger">{{ !empty($awaystats->clean_sheet->away) ? $awaystats->clean_sheet->away : 0 }}</span></td>
                </tr>

                @foreach ($teamstats['home'] as $key => $val)
                    <tr>
                        <td>
                            <span class="badge badge-info">
                            {{ $teamstats['home'][$key] }}
                            </span>
                        </td>
                        <td>{{ $homestats->fixtures->played->home > 0 ? round($teamstats['home'][$key] / $homestats->fixtures->played->home, 2) : 0 }}</td>
                        <td>{{ $key }}</td>
                        <td>{{ $awaystats->fixtures->played->away > 0 ? round($teamstats['away'][$key] / $awaystats->fixtures->played->away, 2) : 0 }}</td>
                        <td>
                            <span class="badge badge-danger">
                                {{ $teamstats['away'][$key] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                

            </tbody>
        </table>
    </div>

</div>
