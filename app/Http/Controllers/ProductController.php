<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestProduct;
use App\Models\Product;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(section $section  , Product $product)
    {
        $products = $product->with('sections')->get();
        $sections = $section->get();
        return view('products.products' ,[
            'sections' => $sections,
            'products' => $products,
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
    public function store(RequestProduct $request , Product $product)
    {
    //     $product->create([
    //         'product_name' => $request->product_name,
    //         'description' => $request->description,
    //         'section_id' => $request->section_id,
    //    ]);
        try{
           $product->create($request->all());
            return redirect()->route('products.index')->with('success', 'تم العملية بنجاح');
        }catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('products.index')->with('erorrs' , 'حدث خطا ما يرجى المحاولة لاحقا');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
      //  return $request;

        
        $id = section::where('section_name', $request->section_name)->first()->id;
        $products = $product->findOrFail($request->pro_id);
        try{
            $products->update([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'section_id' => $id,
            ]);
             return redirect()->route('products.index')->with('success', 'تم العملية بنجاح');
         }catch (\Exception $ex) {
             DB::rollBack();
             return redirect()->route('products.index')->with('erorrs' , 'حدث خطا ما يرجى المحاولة لاحقا');
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $id = $product->findOrFail($product->id);
        try{
            $id->delete();
            return redirect()->route('products.index')->with('success', 'تم العملية بنجاح');

        }catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('products.index')->with('erorrs' , 'حدث خطا ما يرجى المحاولة لاحقا');
        }
    }
}
