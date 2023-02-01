<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoice.index');
    }

    /** store function for invoice  */
    public function store(Request $request)
    {
        // $path = $request->file('invoice_file')->store('files/');

        // Storage::putFile('files', $request->invoice_file);

        // Storage::put('public/invoice/', $request->invoice_file, 'public');

        // Storage::put('/', file_get_contents($request->file('invoice_file')->getPathName()));


        $validated = $request->validate([
            'name' =>  'required|array',
            'price' =>  'required|array',
            'qty' =>  'required|array',
            'tax' =>  'required|array', //tax total amount
            'invoice_file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:3000'
        ]);

        try {

            DB::beginTransaction();

            $reqeustData = $request->all();

            // dd($reqeustData['name'][0]);

            $invoice = new Invoice();
            $invoice->date = date('Y-m-d', strtotime($request->invoice_date));

            /** uploading file */
            if ($request->file('invoice_file')) {
                // cache the file
                $file = $request->file('invoice_file');

                // generate a new filename. getClientOriginalExtension() for the file extension
                $filename = 'invoice-' . time() . '.' . $file->getClientOriginalExtension();

                // save to storage/app/photos as the new $filename
                $path = $file->storeAs('public/invoice', $filename);

                $invoice->file = $path;
            }

            $invoice->tax_total = $reqeustData['tax_total'];
            $invoice->net_total = $reqeustData['net_total'];
            $invoice->save();

            /** storing invoice details to invoice sub table */
            foreach ($request->price as $key => $value) {

                $row_total = round($reqeustData['qty'][$key] * $reqeustData['price'][$key], 2);
                $net_amount = round($row_total + $reqeustData['tax'][$key], 2);

                InvoiceSub::create([
                    'invoice_id'    =>  $invoice->id,
                    'name'  =>  $reqeustData['name'][$key],
                    'qty'   =>  $reqeustData['qty'][$key],
                    'amount'    =>  $reqeustData['price'][$key],
                    'total_amount'  =>  $row_total,
                    'tax_amount'    =>  $reqeustData['tax'][$key],
                    'net_amount'    =>  $net_amount
                ]);
            };

            DB::commit();

            return redirect()->route('invoice.index')->with('success', 'Invoice created succesfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong, Please try again.!');
        }
    }
}
