<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachment;
use App\Models\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class invoiceArchifeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(invoices $invoice)
    {
       $invoices = $invoice->onlyTrashed()->get();
        return view('invoices.invoicesArchife' , [
            'invoices' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices $invoice)
    {
        $id = $request->invoice_id;
        $invoice->withTrashed()->where('id', $id)->restore();
        session()->flash('restore_invoice');
        return redirect()->route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , invoices $invoice , InvoiceAttachment $InvoiceAttachment)
    {
        $invoices = $invoice->withTrashed()->where('id',$request->invoice_id)->first();
        $details = $InvoiceAttachment->where('invoice_id', $request->invoice_id)->first();
        if (isset($details->invoice_number)) {
            Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
        }
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect()->route('invoiceArchife.index');
    }
}
