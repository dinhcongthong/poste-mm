@empty($closing_date)

    @if(!empty($working_time))
        @php
        $current_date = new DateTime(null, new DateTimeZone('Asia/Yangon'));

        $cla = '';
        $sta = '';

        if($working_time[0] == 1) {
            $current_hour = $current_date->format('H:i');
            $start_hours = explode(',', $working_time[1]);
            $end_hours = explode(',', $working_time[2]);

            if($current_hour < $start_working_time) {
                $cla = 'status-closing';
            } elseif($current_hour > $end_working_time) {
                $cla = 'status-closed';
            } else {
                $cla = 'status-opening';
            }
        } else {
            $cla = 'status-closed';
        }
        @endphp
        <div class="col-12 mt-3 mt-lg-0 shop-schel flex-wrap">
            <a tabindex="0" class="col-auto p-0 text-dark" role="button" data-toggle="popover" data-container="body" data-trigger="focus" data-html="true" title="Hours" data-content="{{ $time_in_week }}">
                @if($working_time[0] == 1)
                    <span class="{{ $cla }}"></span>
                    <span>
                        {{ $start_hours[0] . ' - ' . $end_hours[0] }}
                        @if(count($start_hours) > 1)
                            {{ ', '.$start_hours[1] . ' - ' . $end_hours[1] }}
                        @endif
                    </span>
                @else
                    <span class="text-danger">Closing</span>
                    {{ $article->working_time }}
                @endif
                @if(!empty($working_time[3]))
                    @php
                    $note = '';
                    for($i = 3; $i < count($working_time); $i++) {
                        if($i == 3) {
                            $note = $working_time[$i];
                        } else {
                            $note .= '-'.$working_time[$i];
                        }
                    }
                    @endphp
                    {{ ' | '.$note }}
                @endif
            </a>
        </div>
    @else
        @if(!empty($article->working_time))
            <div class="col-12 mt-3 mt-lg-0 shop-schel flex-wrap">
                <a tabindex="0" class="col-auto p-0 text-dark" role="button" data-toggle="popover" data-container="body" data-trigger="focus" data-html="true" title="Hours" data-content="{{ $time_in_week }}">
                    {{ $article->working_time}}
                </a>
            </div>
        @endif
    @endif

@else
    <div class="col-12 mt-3 mt-lg-0 shop-schel flex-wrap">
        <a tabindex="0" class="col-auto p-0 text-dark" role="button" data-toggle="popover" data-container="body" data-trigger="focus" data-html="true" data-content="{{ $time_in_week }}">
            <span class="status-closed">Closing</span>
            <span>{{ $closing_date->note }}</span>
        </a>
    </div>
@endempty
