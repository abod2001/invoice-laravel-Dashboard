<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // foreach($collection as $key=>$value) {
        //     dd($key,$value);
        // }
        // $collection = Excel::load($collection)->get();
        if ($collection->count() > 0) {
            foreach ($collection->toArray() as $key => $value) {
                 dd($value);
                $insert_data[] = array(
                    'invoice_number'  => $value[1],
                    'invoice_date'   => $value[2],
                    'due_date'   => $value[3],
                    'product'    => $value[4],
                    'section_id'  => $value[5],
                    'amount_collection'   => $value[6],
                    'amount_commission' => $value[7],
                    'discount' => $value[8],
                    'value_VAT' => $value[9],
                    'rate_VAT' => $value[10],
                    'total' => $value[11],
                    'status' => $value[12],
                    'value_status' => $value[13],
                    'note' => $value[14],
                );
                DB::table('invoices')->insert($insert_data);
            }
        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }
}
