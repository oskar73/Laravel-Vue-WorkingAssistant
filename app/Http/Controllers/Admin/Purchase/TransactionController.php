<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Invoice;
use App\Models\Transaction;
use PDF;

class TransactionController extends AdminController
{
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'purchase.transaction');
    }

    public function invoice($id)
    {
        $invoice = Invoice::findorfail($id);
        if (request()->wantsJson()) {
            return response()->json([
                'status' => 1,
                'data' => view('components.invoice.template1', compact('invoice'))->render(),
            ]);
        }

        return view(self::$viewDir.'purchase.invoice', compact('invoice'));
    }

    public function invoiceDownload($id)
    {
        $invoice = Invoice::findorfail($id);
        $pdf = PDF::loadView('components.invoice.template1', compact('invoice'));

        return $pdf->download('invoice.pdf');
    }
}
