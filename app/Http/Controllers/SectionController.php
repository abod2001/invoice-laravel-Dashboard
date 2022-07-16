<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(section $section)
    {
        $sec = $section->get();
        return view('section.section',[
            'sections' => $sec,
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
    public function store(SectionRequest $request , section $section)
    {
        try{
            $section->create([
                    'section_name' => $request->section_name,
                    'description' => $request->description,
                    'created_by' => (Auth::user()->name),
            ]);
            return redirect()->route('section.index')->with('success', 'تم العملية بنجاح');
        }catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('section.index')->with('erorrs' , 'حدث خطا ما يرجى المحاولة لاحقا');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, section $section)
    {
        $id = $request->id;
        try{
            $sections = $section->findOrFail($id);
            $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
            return redirect()->route('section.index')->with('success', 'تم العملية بنجاح');

        }catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('section.index')->with('erorrs' , 'حدث خطا ما يرجى المحاولة لاحقا');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(section $section)
    {
        $id = $section->findOrFail($section->id);
        try{
            $id->delete();
            return redirect()->route('section.index')->with('success', 'تم العملية بنجاح');

        }catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('section.index')->with('erorrs' , 'حدث خطا ما يرجى المحاولة لاحقا');
        }
        /*
        $id = $request->id;
        sections::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');*/
    }
}
