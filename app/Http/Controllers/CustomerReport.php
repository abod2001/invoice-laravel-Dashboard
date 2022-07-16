<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\section;
use Illuminate\Http\Request;

class CustomerReport extends Controller
{
    public function index(){

        $sections = section::all();
        return view('reports.customers_report',compact('sections'));
    }
  
  
     public function Search_customers(Request $request){
  
  // في حالة البحث بدون التاريخ
        //return $request;
       if ($request->section_id && $request->product && $request->start_at =='' && $request->end_at=='') {
        $invoices = invoices::select('*')->where('section_id','=',$request->section_id)->where('product','=',$request->product)->get();
        $sections = section::all();
         return view('reports.customers_report',compact('sections'))->withDetails($invoices);
  
      
       }
  
  
    // في حالة البحث بتاريخ
       
       else {
         
         $start_at = date($request->start_at);
         $end_at = date($request->end_at);
  
        $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
         $sections = section::all();
         return view('reports.customers_report',compact('sections'))->withDetails($invoices);
  
        
       }
       
    
      
      }
}
