<div id="service-list" class="d-grid g-4">
    @foreach ($business_item->getServiceList as $service)
        <div class="service-item" id="service-item-1">
            <h3 class="font-weight-bold">{{ $service->name }}</h3>
            <p class="m-0">
                {{ nl2br($service->description) }}
            </p>
        </div>
    @endforeach
</div>
