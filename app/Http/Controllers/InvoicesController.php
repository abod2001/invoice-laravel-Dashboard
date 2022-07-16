<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\Exports\InvoicesExport;
use App\Imports\ExcelImport;
use App\Models\Invoice_Details;
use App\Models\InvoiceAttachment;
use App\Models\invoices;
use App\Models\Product;
use App\Models\section;
use App\Models\User;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(invoices $invoices)
    {
        $invoice = $invoices->with('sections')->get();
        return view('invoices.invoices', [
            'invoices' => $invoice,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(section $section)
    {
        $sections = $section->get();
        return view('invoices.create_invoices', [
            'sections' => $sections,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, invoices $invoice)
    {
        //return $request;
        // $request->merge([
        //     'status' => 'غير مدفوعة',
        //     'value_status' => 2
        // ]);
        //$invoice->create($request->all());
        // invoices::create([
        //     'invoice_number'=>$request->invoice_number,
        //     'invoice_date'=>$request->invoice_date,
        //     'due_date'=>$request->due_date,
        //     'section_id'=>$request->section_id,
        //     'product'=>$request->product,
        //     'amount_collection'=>$request->amount_collection,
        //     'amount_commission'=>$request->amount_commission,
        //     'discount'=>$request->discount,
        //     'rate_VAT'=>$request->rate_VAT,
        //     'value_VAT'=>$request->value_VAT,
        //     'total'=>$request->total,
        //     'note'=>$request->note,
        //  ]);
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section_id,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_VAT' => $request->value_VAT,
            'rate_VAT' => $request->rate_VAT,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);
        $invoice_id = invoices::latest()->first()->id;
        Invoice_Details::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section_id,
            'status' => 'غير مدفوعة',
            'salue_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        if ($request->hasFile('pic')) {
            $invoice_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();//اسم الصورة
            $invoice_number = $request->invoice_number;

            $attachments = new InvoiceAttachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        // $user = User::first();
        // Notification::send($user , new InvoicePaid($invoice_id));
        //$user = User::findOrFail(Auth::user()->id); لشخص
        $user = User::get();
        $invoices = invoices::latest()->first();
        Notification::send($user , new \App\Notifications\AddInvoice($invoices));
        $data = [
            //'user_id' => Auth::user()->id,
            'user' => Auth::user()->name,
            'invoice_number' => $request->invoice_number,
        ];
        event(new NewNotification($data));
        return redirect()->route('invoices.index')->with('success', 'تم العملية بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(invoices $invoice)
    {                       
        $invoice = $invoice->where('id',$invoice->id)->first();
        
        return view('invoices.statusUpdate',[
            'invoices' =>$invoice,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit(section $section, invoices $invoice)
    {
        $invoices = $invoice->where('id', $invoice->id)->first();
        $sections = $section->get();
        return view('invoices.invoicesEdit', compact('sections', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices $invoices)
    {
        //return $request;
        $id = $request->invoice_id;
        $invoice = $invoices->findOrFail($id);
         $invoice->update($request->all());
        return redirect()->route('invoices.index')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, invoices $invoices , InvoiceAttachment $InvoiceAttachment)
    {
        $id = $invoices->where('id',$request->id)->first();
        $details = $InvoiceAttachment->where('invoice_id', $request->id)->first();
        
        $id_page =$request->id_page;
        if (!$id_page==2) {
            if (isset($details->invoice_number)) {
                Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
            }
            $id->forceDelete();
            return redirect()->route('invoices.index')->with('success', 'تم الحذف بنجاح');
        }
        else {
            $id->delete();
            return redirect()->route('invoiceArchife.index')->with('success', 'تم الارشفة بنجاح');
        }
    }
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return ($products);
    }
    
    public function Status_Update(invoices $invoice, Request $request , Invoice_Details $invoice_Details)
    {
        $invoices = $invoice->findOrFail($request->id);
        if ($request->status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);

            $invoice_Details->create([
                'invoice_id' => $request->id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'salue_status' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);
            $invoice_Details->create([
                'invoice_id' => $request->id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'salue_status' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }
        return redirect()->route('invoices.index')->with('success', 'تم التعديل بنجاح');
    }

    public function Invoice_Paid(invoices $invoice)
    {
        $invoices = $invoice->where('value_status', 1)->get();
        return view('invoices.invoicesPaid',compact('invoices'));
    }

    public function Invoice_unPaid(invoices $invoice)
    {
        $invoices = $invoice->where('value_status', 2)->get();
        return view('invoices.invoicesUnPaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoices::where('Value_Status',3)->get();
        return view('invoices.invoices_Partial',compact('invoices'));
    }
    public function Print_invoice(invoices $invoice)
    {
        $invoices = $invoice->where('id', $invoice->id)->first();
        return view('invoices.printInvoice',[
            'invoices' => $invoices,
        ]);

    }
    public function export() 
    {
        return Excel::download(new InvoicesExport, 'قائمة الفواتير.xlsx');
    }

    public function MarkAsRead_all ()
    {

        $userUnreadNotification = auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }

    }
    
    function import(Request $request)
    {
        // return $request;
        $this->validate($request, [
        'select_file'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('select_file')->getRealPath();
        Excel::import(new ExcelImport, $path);
        return back()->with('success', 'Excel Data Imported successfully.');
    }
}
