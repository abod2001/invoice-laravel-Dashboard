<?php

namespace App\Http\Controllers;

use App\Models\Invoice_Details;
use App\Models\InvoiceAttachment;
use App\Models\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Invoice_Details  $invoice_Details
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_Details $invoice_Details , invoices $invoice , InvoiceAttachment $InvoiceAttachment)
    {
        $invoce = [];
        $invoce['invoices'] = $invoice->with('sections')->where('id' ,$invoice->id)->get();
        $invoce['invoiceDetails'] = $invoice_Details->where('invoice_id' ,$invoice->id)->get();
        $invoce['InvoiceAttachment'] = $InvoiceAttachment->where('invoice_id' ,$invoice->id)->get();

        $userUnreadNotification = auth()->user()->unreadNotifications;
        foreach ($userUnreadNotification as $noty){
            if($noty->data['invoice_id']==$invoce['invoices']) {
                $noty->markAsRead();
            }
        }    
        return view('invoices.invoicesDetails',/*$invoce*/compact('invoce'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice_Details  $invoice_Details
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice_Details $invoice_Details , invoices $invoice , InvoiceAttachment $InvoiceAttachment)
    {
        //return $invoice->where('id' ,$invoice->id)->get();
        $invoce = [];
        $invoce['invoices'] = $invoice->with('sections')->where('id' ,$invoice->id)->get();
        $invoce['invoiceDetails'] = $invoice_Details->where('invoice_id' ,$invoice->id)->get();
        $invoce['InvoiceAttachment'] = $InvoiceAttachment->where('invoice_id' ,$invoice->id)->get();
    return view('invoices.invoicesDetails',/*$invoce*/compact('invoce'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice_Details  $invoice_Details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_Details $invoice_Details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice_Details  $invoice_Details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, InvoiceAttachment $invoice_attachments)
    {
        $id = $invoice_attachments->findOrFail($request->id_file);
        $id->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }
    public function open_file($invoice_number,$file_name)
    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($files);
    }
    public function get_file($invoice_number,$file_name)
    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download($files);
    }
}
