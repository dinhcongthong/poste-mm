<div class="alert alert-success">
    <div class="col-xs-12 col-md-1 " style="display: inline-flex;">
        {{ $item->id }}
    </div>
    <div class="col-xs-12 col-md-4" style="display: inline-flex;" title="{{ $item->start_date }} - {{ $item->end_date }}">
        {{ $item->name }}
    </div>
    <div class="col-xs-12 col-md-2" style="display: inline-flex;">

        <span>{{ $item->getADPosition->name}}</span>
    </div>

    <div class="col-xs-12 col-md-2" style="display: inline-flex;">
        {{ \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->diffInDays($item->end_date) }} left
    </div>
</div>
