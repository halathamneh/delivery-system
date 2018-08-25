<?php

namespace App;

use App\Interfaces\Accountable;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property Carbon until
 * @property Carbon from
 * @property Client|Courier target
 * @property string type
 * @property Collection shipments
 * @property string period
 * @property float discount
 * @property float due_for
 * @property float due_from
 * @property float pickup_fees
 * @property float total
 * @property string terms_applied
 */
class Invoice extends Model
{
    protected $fillable = [
        'type',
        'target',
        'from',
        'until',
        'discount',
        'notes',
    ];

    protected $dates = [
        'from',
        'until'
    ];

    /**
     * @param $value
     */
    public function setPeriodAttribute($value)
    {
        $dates = explode(' - ', $value);
        $this->from = Carbon::createFromFormat('M d, Y', $dates[0]);
        $this->until = Carbon::createFromFormat('M d, Y', $dates[1]);
    }

    /**
     * @return string
     */
    public function getPeriodAttribute()
    {
        return $this->from->toFormattedDateString() . " - " . $this->until->toFormattedDateString();
    }

    /**
     * @return Shipment
     */
    public function shipments()
    {
        $shipments = Shipment::unpaid()->whereBetween('delivery_date', [$this->from, $this->until]);

        if ($this->type == "client")
            return $shipments->where('client_account_number', $this->target->account_number);
        elseif ($this->type == "courier")
            return $shipments->where('courier_id', $this->target->id);
        return $shipments;
    }

    /**
     * @return Collection
     */
    public function getShipmentsAttribute()
    {
        return $this->shipments()->get();
    }

    public function getTargetAttribute()
    {
        $value = $this->attributes['target'];
        if ($this->type == "client")
            return Client::find($value);
        else if ($this->type == "courier")
            return Courier::find($value);
        return null;
    }


    /**
     * @return Pickup
     */
    public function pickups()
    {
        $pickups = Pickup::unpaid()->whereBetween('created_at', [$this->from, $this->until]);

        if ($this->type == "client")
            return $pickups->where('client_account_number', $this->target->account_number);
        elseif ($this->type == "courier")
            return $pickups->where('courier_id', $this->target->id);
        return $pickups;
    }

    /**
     * @return Pickup[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPickupsAttribute()
    {
        return $this->pickups()->get();
    }

    /**
     * @return float
     */
    public function getDueForAttribute()
    {
        if ($this->target instanceof Accountable)
            return $this->target->dueFor($this);
        return 0;
    }

    /**
     * @return float
     */
    public function getDueFromAttribute()
    {
        if ($this->target instanceof Accountable)
            return $this->target->dueFrom($this);
        return 0;
    }

    public function getTermsAppliedAttribute()
    {
        return "-" . fnumber($this->discount) . "%";
    }

    public function getPickupFeesAttribute()
    {
        return $this->pickups()->sum('pickup_fees');
    }

    public function getTotalAttribute()
    {
        $net = $this->due_from - $this->due_for;
        if($this->discount > 0) {
            $net -= $net * ($this->discount / 100);
        }
        $net += $this->pickup_fees;

        return $net;
    }
}