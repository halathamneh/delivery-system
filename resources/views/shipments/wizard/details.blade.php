@php /** @var \App\Shipment $shipment */ @endphp
<fieldset>
    <legend><i class="fa fa-info-circle"></i> @lang("shipment.details")</legend>

    <div>

        <h2 class="step-title font-weight-bold"><i class="fa fa-info-circle"></i> @lang("shipment.details")</h2>
        <p>@lang("shipment.detailsNote")</p>

        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">

                    <div class="form-group col-sm-6">
                        <label for="waybill">@lang('shipment.waybill') *</label>
                        <input type="number" name="waybill" id="waybill" class="form-control" data-bind="waybill"
                               readonly
                               required placeholder="@lang('shipment.waybill')"
                               value="{{ $suggestedWaybill ?? $shipment->waybill }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="deliveryDate">@lang('shipment.delivery_date') *</label>
                        <input type="text" name="delivery_date" id="delivery_date" class="form-control datetimepicker"
                               required placeholder="@lang('shipment.deliveryDate')" data-bind="delivery_date"
                               value="{{ isset($shipment) ? $shipment->delivery_date->format("d-m-Y") : old("delivery_date") }}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="package_weight">@lang('shipment.package_weight')</label>
                        <input type="number" name="package_weight" id="package_weight" class="form-control"
                               data-bind="package_weight"
                               placeholder="@lang('shipment.package_weight')" step="0.01" max="30"
                               value="{{ isset($shipment) ? $shipment->package_weight : old("package_weight") }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="shipment_value">@lang('shipment.shipment_value')</label>
                        <input type="number" name="shipment_value" id="shipment_value" class="form-control"
                               placeholder="@lang('shipment.shipment_value')" step="0.01" min="0" data-bind="shipment_value"
                               value="{{ isset($shipment) ? $shipment->shipment_value : old("shipment_value") }}">
                    </div>
                    @if(!isset($shipment))
                        <div class="form-group col-sm-6">
                            <label for="status">@lang('shipment.initial_status') *</label>
                            <select name="status" id="status" class="form-control selectpicker" data-live-search="true" data-bind="status">
                                <option value=""
                                        disabled {{ old('status') ?: "selected" }}>@lang('common.select')</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status') == $status->id ? "selected" : "" }}>@lang("shipment.statuses.".$status->name)</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    {{--<div class="form-group col-sm-6">--}}
                    {{--<label for="status_more">@lang('shipment.status_more') *</label>--}}
                    {{--<select name="status_more" id="status_more" class="form-control selectpicker"--}}
                    {{--data-live-search="true">--}}
                    {{--<option value="" disabled selected>@lang('common.select')</option>--}}
                    {{--<option value="1">Status 1</option>--}}
                    {{--<option value="2">Status 2</option>--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    <div class="col-sm-6 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="custom_price" name="custom_price" value="true" {{ old('custom_price') == "true" ? "checked" : "" }}>
                            <label class="custom-control-label" for="custom_price">@lang('shipment.custom_price')</label>
                        </div>
                        <input type="number" min="0" step="0.1" placeholder="@lang('shipment.total_price')" name="total_price" id="total_price"
                               value="{{ old('total_price') }}" class="form-control" {{ old('custom_price') == "true" ? "" : "disabled" }}>
                        <small class="form-text text-muted">@lang('shipment.custom_price_help')</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-body">
                <div class="form-row">

                    <div class="form-group col-sm-12">
                        <label for="services" style="font-size: 1.2rem;">@lang('shipment.extra_services')</label>
                        <select name="services[]" id="services" class="form-control selectpicker" multiple
                                data-live-search="true" data-bind="extra_services"
                                data-none-selected-text="@lang("shipment.select_multi_service")">
                            @foreach($services as $service)
                                @php /** @var \App\Service $service */ @endphp
                                <option value="{{ $service->id }}"
                                        {{ (isset($shipment) && $service->hasShipment($shipment)) || (is_array(old('services')) && in_array($service->id, old('services'))) ? "selected" : "" }}
                                        data-subtext="{{ $service->price . ' ' . trans('common.jod') }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>


    </div>
</fieldset>