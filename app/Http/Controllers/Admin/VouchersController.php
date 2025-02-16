<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VouchersController extends Controller
{
    public function index()
    {
        return view('admin.vouchers.index');
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }
}
