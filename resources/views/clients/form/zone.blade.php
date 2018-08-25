@php /** @var App\Client $client */ @endphp

<div class="form-row">
    <div class="form-group col-sm-12">
        <label for="zone_id" class="control-label">@lang('client.zone')</label>
        <select name="zone_id" id="zone_id" class="form-control selectpicker" data-live-search="true"
                required>
            <option value="" disabled {{ old('zone_id') ?: 'selected' }}>@lang('common.select')</option>
            @foreach($zones as $zone)
                <option {{ (isset($client) && $client->zone->id == $zone->id) || (old('zone_id') && old('zone_id') == $zone->id) ? 'selected' : "" }} value="{{ $zone->id }}">{{ $zone->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label for="pickup_address_text"
               class="control-label">@lang('client.pickup_address_text')</label>
        <input type="text" name="pickup_address[text]" id="pickup_address_text"
               value="{{ $client->pickup_address->text ?? old('pickup_address.text') }}"
               placeholder="@lang('client.pickup_address_text')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="pickup_address_maps"
               class="control-label">@lang('client.pickup_address_maps')</label>
        <input type="text" name="pickup_address[maps]" id="pickup_address_maps"
               value="{{ $client->pickup_address->maps ?? old('pickup_address.maps') }}"
               placeholder="@lang('client.maps_placeholder')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="sector" class="control-label">@lang('client.sector')</label>
        <input type="text" name="sector" id="sector" value="{{ $client->sector ?? old('sector') }}"
               placeholder="@lang('client.sector')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label for="category" class="control-label">@lang('client.category')</label>
        <select name="category" id="category" required class="selectpicker form-control">
            <option {{ (isset($client) && $client->category == 1) || (old('category') && old('category') == 1) ? 'selected' : '' }} value="1">@lang('client.online_store')</option>
            <option {{ (isset($client) && $client->category == 2) || (old('category') && old('category') == 2) ? 'selected' : '' }} value="2">@lang('client.local_store')</option>
        </select>
    </div>
</div>