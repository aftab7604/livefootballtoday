{{-- league table --}}
<div class="card align-middle bg-dark text-white">
    <h5 class="text-left p-2">Table</h5>
</div>
<div class="card standing-table">
    <div class="">
        <div class="table-responsive">
            @forelse ($standings as $single_standing)
                <table class="table wg-table">
                    <thead></thead>
                    <tbody>
                    <tr>
                        <td class="wg_header" colspan="11" style="text-align: left;">
                            <img class="wg_flag" src="{{ $league->flag }}" loading="lazy">
                            {{ $league->country }}: {{ $league->name }}
                        </td>
                    </tr>
                    <tr>

                        <td class="wg_header" colspan="2"></td>
                        <td class="wg_header wg_text_center wg_tooltip wg_tooltip_left"
                            data-toggle="tooltip" data-placement="left"
                            title="MATCHES PLAYED">
                            MP</td>
                        <td class="wg_header wg_text_center wg_tooltip wg_tooltip_left"
                            data-toggle="tooltip" data-placement="left" title="WIN">W</td>
                        <td class="wg_header wg_text_center wg_tooltip wg_tooltip_left"
                            data-toggle="tooltip" data-placement="left" title="DRAW">D</td>
                        <td class="wg_header wg_text_center wg_tooltip wg_tooltip_left"
                            data-toggle="tooltip" data-placement="left" title="LOSE">L</td>
                        <td class="wg_header wg_text_center wg_tooltip wg_tooltip_left wg_hide_xxs"
                            data-toggle="tooltip" data-placement="left"
                            title="GOALS FOR:GOALS AGAINST">G</td>
                        <td class="wg_header wg_text_center wg_tooltip wg_tooltip_left wg_hide_xs"
                            data-toggle="tooltip" data-placement="left" title="DIFFERENCE">
                            +/-</td>
                        <td class="wg_header wg_text_center wg_tooltip wg_tooltip_left"
                            data-toggle="tooltip" data-placement="left" title="POINTS">P</td>
                        <td class="wg_header wg_hide_xs" colspan="2"></td>
                    </tr>
                    @forelse ($single_standing as $standing)
                        @php
                            $rowColor = '';
                            if (isset($standing->description) && !empty($standing->description)) {
                                $rowColor = 'lightblue';
                            }
                        @endphp
                        <tr>
                            <td class="wg_text_center wg_bolder wg_width_20"
                                style="background-color: {{ $rowColor }};">
                                {{ $standing->rank }}
                            </td>
                            <td class="wg_nowrap"
                                style="text-align: left; background-color:{{ $rowColor }};">
                                <img class="wg_logo" src="{{ $standing->team->logo }}"
                                    alt="">
                                {{ $standing->team->name }}
                            </td>
                            <td class="wg_text_center wg_width_20"
                                style="background-color: {{ $rowColor }};">
                                {{ $standing->all->played }}
                            </td>
                            <td class="wg_text_center wg_width_20"
                                style="background-color: {{ $rowColor }};">
                                {{ $standing->all->win }}
                            </td>
                            <td class="wg_text_center wg_width_20"
                                style="background-color: {{ $rowColor }};">
                                {{ $standing->all->draw }}
                            </td>
                            <td class="wg_text_center wg_width_20"
                                style="background-color: {{ $rowColor }};">
                                {{ $standing->all->lose }}
                            </td>
                            <td class="wg_text_center wg_width_20 wg_hide_xxs"
                                style="background-color: {{ $rowColor }};">
                                {{ $standing->all->goals->for }}:{{ $standing->all->goals->against }}
                            </td>
                            <td class="wg_text_center wg_width_20 wg_hide_xs"
                                style="background-color: {{ $rowColor }};">
                                {{ $standing->goalsDiff }}
                            </td>
                            <td class="wg_text_center wg_width_20"
                                style="background-color: {{ $rowColor }};">
                                <span class="<?php echo isset($standing->description) && !empty($standing->description) ? 'wg_tooltip wg_tooltip_left' : ''; ?>" data-toggle="tooltip"
                                    data-placement="left"
                                    title="{{ $standing->description }}">
                                    {{ $standing->points }}
                                </span>
                            </td>
                            <td class="wg_text_center wg_width_90 wg_hide_xs"
                                style="text-align: left; background-color: {{ $rowColor }};">
                                @php
                                    $str = $standing->form;
                                    $strCount = strlen($str);
                                @endphp
                                @if ($strCount > 0)
                                    @for ($i = 0; $i < $strCount; $i++)
                                        @switch($str[$i])
                                            @case('W')
                                                <span class="wg_form wg_form_win">W</span>
                                            @break

                                            @case('L')
                                                <span class="wg_form wg_form_lose">L</span>
                                            @break

                                            @case('D')
                                                <span class="wg_form wg_form_draw">D</span>
                                            @break

                                            @default
                                        @endswitch
                                    @endfor
                                @endif
                            </td>
                            <td class="wg_text_center wg_width_20 wg_hide_xs">
                                @if (isset($standing->description) && !empty($standing->description))
                                    <span class="wg_info wg_tooltip wg_tooltip_left"
                                        data-toggle="tooltip" data-placement="left"
                                        title="{{ $standing->description }}">?</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="11">
                                    No information Available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @empty
                <table class="table wg-table">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <td colspan="11">
                                No Standings Available
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforelse
        </div>
    </div>
</div>
{{-- end league table --}}
