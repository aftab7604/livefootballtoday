<div class="card">
    <div class="card-body table-responsive">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th class="text-left" scope="col">Country</th>
                    <th class="text-left" scope="col">League / Cup</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 0;
                @endphp
                @foreach ($leagues_ordered as $key => $leagues_ordered_value)
                @php
                $i++;
                @endphp
                <tr>
                    <th scope="row" style="width: 25% !important">
                        {{$i}}
                    </th>
                    <td class="text-left" style="width: 35% !important">
                        @if ($leagues[$key]->country->flag)
                        <img width="14%" src="{{$leagues[$key]->country->flag}}" alt="">
                        @endif
                        {{$leagues[$key]->country->name}}
                    </td>
                    <td class="text-left" style="width: 40% !important">
                        <a class="no-underline"
                            href="{{route('public.league.get', ['nation' => str_replace(' ','_', $leagues[$key]->country->name), 'league_name' => str_replace(' ','_', $leagues[$key]->league->name)])}}">
                            <img width="14%" src="{{$leagues[$key]->league->logo}}" alt="">
                            {{$leagues[$key]->league->name}}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   
</div>



<script>
    $(document).ready(function () {
        $('.table').DataTable({
            language: {
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });

    });

</script>
<?php
 /*
<div style="background-color:white;margin-top:35px; padding:20px 25px 20px 25px;">
    
    <h2 style="text-align:center;">Champions League matches</h2>
 <p style="text-align:justify;">Get all the stats-based updates on our website and find all the information you need on the lively game of football. Be prepared to be swept away into the world of football! Whether you're a dedicated fan or enjoy keeping up with the sport, we have all the latest updates on Football tables and league standings. Whether your favorite teams are heavy favorites fighting for first place or slight underdogs fighting for redemption, you may follow their journeys with interest.</p>
 
 <p style="text-align:justify;">Are you thrilled about the upcoming Champions League matches? Stop searching now! Get ready to be enthralled by the gripping and dramatic competition among Europe's top club teams. Stay up-to-date with all the latest happenings as you cheer on your favorite teams as they take on the top European teams.</p>
 
 <p style="text-align:justify;">For those who have a special place in their hearts for English football, our Premier League fixtures section is just what you need. Keep up with the schedule of forthcoming matches and plan your weekends around the most eagerly awaited encounters. We've got you covered, from crucial matches that could determine the champion to intense relegation showdowns.</p>
 
 <p style="text-align:justify;">So, why wait? Join us on this football adventure and feel the thrill of the game like never before. Whether you're looking for live scores, detailed analyses, or expert opinions, we've got everything to fulfill your football desires. Become a part of our football-loving community and share your enthusiasm for the sport at live football today.</p>
 </div>
 ?>