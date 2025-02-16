<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'usage_limit',
        'times_used',
        'email',
        'valid_from',
        'valid_until',
        'minimum_order_value',
        'maximum_discount',
        'is_active',
        'description'
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['minimum_order_value', 'maximum_discount', 'usage_limit']) && $value === '') {
            $value = null;
        }
        return parent::setAttribute($key, $value);
    }

    public function isValid($email = null, $orderValue = null)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->usage_limit !== null && $this->times_used >= $this->usage_limit) {
            return false;
        }

        $now = Carbon::now();
        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }
        if ($this->valid_until && $now->gt($this->valid_until)) {
            return false;
        }

        if ($this->email !== null && $email !== $this->email) {
            return false;
        }

        if ($this->minimum_order_value !== null && $orderValue < $this->minimum_order_value) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($orderValue)
    {
        if ($this->discount_type === 'percentage') {
            $discount = $orderValue * ($this->discount_value / 100);

            if ($this->maximum_discount !== null) {
                $discount = min($discount, $this->maximum_discount);
            }

            return $discount;
        }

        return $this->discount_value;
    }
}
