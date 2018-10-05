<?php

namespace App\Http\Controllers;

use App\Client;
use App\Courier;
use App\Pickup;
use App\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;

class PickupsController extends Controller
{

    public function __construct()
    {
        View::share([
            'pageTitle' => trans('pickup.label')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $s = $request->get('s', false);

        $pickups = Pickup::latest('available_time_start');
        $startDate = $endDate = false;
        if (Auth::user()->isCourier()) {
            $pickups->today()->where('courier_id', Auth::user()->courier->id);
        } elseif ($request->has('start') && $request->has('end')) {
            $startDate = Carbon::createFromTimestamp($request->get('start'))->toDateString();
            $endDate = Carbon::createFromTimestamp($request->get('end'))->toDateString();
            $pickups->whereBetween('available_time_start', [$startDate, $endDate])->whereBetween('available_time_end', [$startDate, $endDate], 'or');
        }

        if ($s)
            $pickups->where('client_account_number', '=', $s);
        return view('pickups.index')->with([
            'pickups'   => $pickups->get(),
            'startDate' => $startDate,
            'endDate'   => $endDate,
            's'         => $s
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $couriers = Courier::all();
        return view('pickups.create')->with([
            'couriers'  => $couriers,
            'pageTitle' => trans('pickup.create')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pickup = new Pickup;
        try {
            $pickup->client()->associate(Client::findOrFail($request->get('client_account_number')));
            $pickup->courier()->associate(Courier::findOrFail($request->get('courier_id')));

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        $pickup->fill($request->toArray());

        $day = $request->get('available_day');
        $start = $request->get('time_start');
        $end = $request->get('time_end');
        $startDate = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $start);
        $endDate = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $end);
        $pickup->available_time_start = $startDate;
        $pickup->available_time_end = $endDate;
        $pickup->save();

        $waybills = $request->get('waybills', []);
        if (count($waybills)) {
            foreach ($waybills as $waybill) {
                $pickup->shipments()->attach(Shipment::waybill($waybill)->first());
            }
        }

        return redirect()->route('pickups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function show(Pickup $pickup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Pickup $pickup)
    {

        $couriers = Courier::all();
        $pickup->load('shipments');
        return view('pickups.edit')->with([
            'pickup'   => $pickup,
            'couriers' => $couriers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pickup $pickup)
    {
        $pickup->courier()->associate(Courier::findOrFail($request->get('courier_id')));
        $pickup->fill($request->toArray());
        $day = $request->get('available_day');
        $start = $request->get('time_start');
        $end = $request->get('time_end');
        $startDate = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $start);
        $endDate = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $end);
        $pickup->available_time_start = $startDate;
        $pickup->available_time_end = $endDate;
        $pickup->save();

        return redirect()->route('pickups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pickup $pickup)
    {
        try {
            $pickup->delete();
        } catch (\Exception $ex) {
        }
        return back();
    }

    /**
     * @param Request $request
     * @param Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function actions(Request $request, Pickup $pickup)
    {
        $request->validate([
            'status'         => 'required',
            'available_day'  => 'required_if:status,client_rescheduled',
            'time_start'     => 'required_if:status,client_rescheduled',
            'time_end'       => 'required_if:status,client_rescheduled',
            'actualPackages' => 'required_if:status,completed'
        ]);

        $status = $request->get('status');
        switch ($status) {
            case "client_rescheduled":
                $day = $request->get('available_day');
                $start = $request->get('time_start');
                $end = $request->get('time_end');
                $startDate = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $start);
                $endDate = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $end);
                $pickup->available_time_start = $startDate;
                $pickup->available_time_end = $endDate;
                $pickup->status = "pending";
                $pickup->actual_packages_number = null;
                $pickup->notes_external = $request->get('reasons');
                break;
            case "completed":
                $pickup->actual_packages_number = $request->get('actualPackages');
                $pickup->notes_external = $request->get('reasons');
                $pickup->status = $status;
                break;
            case "declined_client":
            case "declined_dispatcher":
            case "declined_not_available":
                $pickup->actual_packages_number = null;
                $pickup->notes_external = $request->get('reasons');
                $pickup->status = $status;
                break;
        }
        $pickup->save();

        return redirect()->route('pickups.index');
    }
}
