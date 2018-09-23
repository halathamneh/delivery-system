@php /** @var \App\Shipment $shipment */ @endphp
<div class="container">
    <div class="row mt-4" data-id="{{ $shipment->id }}">
        <div class="mx-auto col-md-9">

            @if(auth()->user()->isCourier() && auth()->user()->can('update', $shipment))
                @include("shipments.actions.courierConfirm")
            @endif

            @can('delete', $shipment)
                @include('shipments.actions.changeStatus')
                @include('shipments.actions.return')
                @include('shipments.actions.delete')
            @endcan

        </div>
    </div>
</div>
