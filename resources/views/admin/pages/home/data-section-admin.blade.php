@if($item->fee == 1 )
	<div class="alert alert-success">
		<div class="col-xs-12 col-md-1 " style="display: inline-flex;">
			{{ $item->id }}
		</div>
		<div class="col-xs-12 col-md-4" style="display: inline-flex;" title="{{ $item->start_date }} - {{ $item->end_date }}">
			{{ $item->name }}
		</div>
		<div class="col-xs-12 col-md-2" style="display: inline-flex;">

            <span>{{ getUserName($item->getUser) }}</span>
		</div>

		<div class="col-xs-12 col-md-2" style="display: inline-flex;">
			{{ \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->diffInDays($item->end_date) }} left
		</div>
	</div>
	@else
	<div class="alert bg-warning">
		<div class="col-xs-12 col-md-1 " style="display: inline-flex;">
			{{ $item->id }}
		</div>
		<div class="col-xs-12 col-md-4" style="display: inline-flex;" title="{{ $item->start_date }} - {{ $item->end_free_date }}">
			{{ $item->name }}
		</div>
		<div class="col-xs-12 col-md-2" style="display: inline-flex;">
            <span>{{ $item->getUser->first_name}} {{ $item->getUser->last_name}}</span>
		</div>

		<div class="col-xs-12 col-md-2" style="display: inline-flex;">
			{{ \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->diffInDays($item->end_free_date) }} left
		</div>
	</div>
@endif
