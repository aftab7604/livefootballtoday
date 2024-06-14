{{-- h2h --}}
<div class="mb-2">
    <div class="card align-middle bg-dark text-white">
        <h5 class="text-left p-2">Head To Head</h5>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="h2h_table table" style="width: 100%;">
                <tbody>
                    @forelse ($h2h as $h2h_single)
                        <tr class="thead-light">
                            <th colspan="5">
                                {{ \carbon\carbon::parse($h2h_single->fixture->timestamp)->setTimezone($timezone)->format('d/m/Y') }}
                            </th>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 15%">
                                <a class="no-underline"
                                    href="{{ route('public.team.get', [
                                        'nation' => str_replace(' ', '_', $league->country),
                                        'id' => $h2h_single->teams->home->id,
                                        'club' => str_replace(' ', '_', $h2h_single->teams->home->name),
                                    ]) }}">
                                    <img class="team-logo-h2h"
                                        src="{{ $h2h_single->teams->home->logo }}" alt="home">
                                </a>
                            </td>
                            <td class="text-left">
                                <a class="no-underline"
                                    href="{{ route('public.team.get', [
                                        'nation' => str_replace(' ', '_', $league->country),
                                        'id' => $h2h_single->teams->home->id,
                                        'club' => str_replace(' ', '_', $h2h_single->teams->home->name),
                                    ]) }}">
                                    {{ $h2h_single->teams->home->name }}
                                </a>
                            </td>
                            <td style="white-space: nowrap centered-links" align="center">
                                <p>{{ $h2h_single->goals->home }}-{{ $h2h_single->goals->away }}</p>

                            </td>
                            <td class="text-right">
                                <a class="no-underline"
                                    href="{{ route('public.team.get', [
                                        'nation' => str_replace(' ', '_', $league->country),
                                        'id' => $h2h_single->teams->away->id,
                                        'club' => str_replace(' ', '_', $h2h_single->teams->away->name),
                                    ]) }}">
                                    {{ $h2h_single->teams->away->name }}
                                </a>
                            </td>
                            <td class="text-right" style="width: 15%">
                                <a class="no-underline"
                                    href="{{ route('public.team.get', [
                                        'nation' => str_replace(' ', '_', $league->country),
                                        'id' => $h2h_single->teams->away->id,
                                        'club' => str_replace(' ', '_', $h2h_single->teams->away->name),
                                    ]) }}">
                                    <img class="team-logo-h2h"
                                        src="{{ $h2h_single->teams->away->logo }}" alt="home">
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
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
                                No data available
                            </td>
                        </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- End of h2h --}}
