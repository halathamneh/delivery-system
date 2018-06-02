<!-- Modal -->
<div class="modal fade" id="reviewShipmentModal" tabindex="-1" role="dialog" data-backdrop="static"
     aria-labelledby="reviewShipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewShipmentModalLabel">@lang("shipment.review")</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div>@lang('shipment.client_account_number') <span data-update="client_account_number"></span></div>
                                <div>@lang('shipment.client.name') <span data-update="client_name"></span></div>
                                <div>@lang('shipment.client.name') <span data-update="client_name"></span></div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div>@lang('shipment.waybill') <span data-update="waybill"></span></div>
                                <div>@lang('shipment.delivery_date') <span data-update="delivery_date"></span></div>
                                <div>@lang('shipment.package_weight') <span data-update="package_weight"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                Delivery
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>