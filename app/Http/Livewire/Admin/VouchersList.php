<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Voucher;
use Livewire\WithPagination;

class VouchersList extends Component
{
    use WithPagination;

    public $search = '';
    public $showInactive = false;

    public function render()
    {
        $vouchers = Voucher::query()
            ->when(!$this->showInactive, fn($query) => $query->where('is_active', true))
            ->when($this->search, fn($query) => $query->where('code', 'like', '%'.$this->search.'%'))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.vouchers-list', [
            'vouchers' => $vouchers
        ]);
    }

    public function toggleActive(Voucher $voucher)
    {
        $voucher->update([
            'is_active' => !$voucher->is_active
        ]);
    }

    public function delete(Voucher $voucher)
    {
        $voucher->delete();
    }
}
