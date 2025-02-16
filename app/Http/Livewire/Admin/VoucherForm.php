<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Voucher;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VoucherForm extends Component
{
    public Voucher $voucher;
    public $isEdit = false;

    protected function rules()
    {
        return [
            'voucher.code' => [
                'required',
                Rule::unique('vouchers', 'code')->ignore($this->voucher->id)
            ],
            'voucher.discount_type' => 'required|in:percentage,fixed',
            'voucher.discount_value' => 'required|numeric|min:0',
            'voucher.usage_limit' => 'nullable|integer|min:1',
            'voucher.email' => 'nullable|email',
            'voucher.valid_from' => 'nullable|date',
            'voucher.valid_until' => 'nullable|date|after:valid_from',
            'voucher.minimum_order_value' => 'nullable|numeric|min:0',
            'voucher.maximum_discount' => 'nullable|numeric|min:0',
            'voucher.description' => 'nullable|string',
        ];
    }

    public function mount(Voucher $voucher = null)
    {
        $this->voucher = $voucher ?? new Voucher();
        $this->isEdit = $voucher->exists;
        $this->voucher->discount_type = 'percentage';
        // Inicjalizacja pustych wartości jako null

        if ($this->voucher->valid_from) {
            $this->voucher->valid_from = Carbon::parse($this->voucher->valid_from)->format('Y-m-d\TH:i');
        }
        if ($this->voucher->valid_until) {
            $this->voucher->valid_until = Carbon::parse($this->voucher->valid_until)->format('Y-m-d\TH:i');
        }

        if (!$this->isEdit) {
            $this->voucher->minimum_order_value = null;
            $this->voucher->maximum_discount = null;
        }
    }

    public function generateCode()
    {
        $this->voucher->code = strtoupper(Str::random(8));
    }

    public function save()
    {
        $this->validate();

        // Konwersja pustych stringów na null dla pól decimal
        if ($this->voucher->minimum_order_value === '') {
            $this->voucher->minimum_order_value = null;
        }
        if ($this->voucher->maximum_discount === '') {
            $this->voucher->maximum_discount = null;
        }
        if ($this->voucher->usage_limit === '') {
            $this->voucher->usage_limit = null;
        }

        // Upewnij się, że kod jest zapisany jako string
        $this->voucher->code = (string) $this->voucher->code;

        $this->voucher->save();

        session()->flash(
            'message',
            $this->isEdit ? 'Voucher został zaktualizowany.' : 'Voucher został utworzony.'
        );

        return redirect()->route('admin.vouchers.index');
    }

    public function render()
    {
        return view('livewire.admin.voucher-form');
    }

    // Dodaj metody do obsługi updatowanych właściwości
    public function updatedVoucherMinimumOrderValue($value)
    {
        if ($value === '') {
            $this->voucher->minimum_order_value = null;
        }
    }

    public function updatedVoucherMaximumDiscount($value)
    {
        if ($value === '') {
            $this->voucher->maximum_discount = null;
        }
    }

    public function updatedVoucherUsageLimit($value)
    {
        if ($value === '') {
            $this->voucher->usage_limit = null;
        }
    }
}
