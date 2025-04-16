<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Detail_sales;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\Products;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detail_sale = Detail_sales::all();
        $sales = Sales::with('customer', 'user')->orderBy('id', 'desc')->get();
        return view('views.pages.sales.index', compact('sales','detail_sale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Products::all();
        return view('views.pages.sales.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $products = $request->products;
        $data['products'] = [];
        $data['total'] = 0;
        foreach ($products as $product) {
            $product = explode(';', $product);
            $id = $product[0];
            $name = $product[1];
            $price = $product[2];
            $quantity = $product[3];
            $subtotal = $product[4];
            
            $data['products'][] = [
                'product_id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'sub_total' => $subtotal,
            ];
            $data['total'] += $subtotal;
        }
        // dd($data['proucts']);
        return view('views.pages.sales.payment', $data);
    }

    /**
     * Display the specified resource.
     */
    public function paymentProccess(Request $request)
    {
        $products = $request->shop;
        $data['products'] = [];
        $total_pay = (int)str_replace(['Rp. ', '.'], '', $request->total_pay);
        $total = (int)$request->total;
        // dd($total_pay);
        if ($request->member == 'Member') {
            $no_hp = $request->no_hp;
            $existCustomer = Customers::where('no_hp', $no_hp)->first();

            if ($existCustomer) {
                $existCustomer->update([
                    'poin' => $existCustomer->poin + ($total / 100),
                    'name' => $existCustomer->name,
                    'no_hp' => $existCustomer->no_hp
                ]);

                Sales::create([
                    'sale_date' => now(),
                    'customer_id' => $existCustomer->id,
                    'total_price' => $total,
                    'total_pay' => $total_pay,
                    'total_return' => $total_pay - $total,
                    'user_id' => Auth::user()->id,
                    'poin' => $total / 100,
                    'used_point' => 0
                ]);

                foreach ($products as $product) {
                    $product = explode(';', $product);
                    $id = $product[0];
                    $name = $product[1];
                    $price = $product[2];
                    $quantity = $product[3];
                    $subtotal = $product[4];
                    Products::where('id', $id)->update([
                        'stock' => Products::where('id', $id)->first()->stock - $quantity
                    ]);
                    Detail_sales::create([
                        'sale_id' => Sales::latest()->first()->id,
                        'product_id' => $id,
                        'quantity' => $quantity,
                        'sub_total' => $subtotal,
                    ]);
                }
            } else {
                Customers::create([
                    'name' => null,
                    'no_hp' => $no_hp,
                    'poin' => $total / 100,
                ]);

                Sales::create([
                    'sale_date' => now(),
                    'customer_id' => Customers::latest()->first()->id,
                    'total_price' => $total,
                    'total_pay' => $total_pay,
                    'total_return' => $total_pay - $total,
                    'user_id' => Auth::user()->id,
                    'poin' => $total / 100,
                    'used_point' => 0
                ]);

                foreach ($products as $product) {
                    $product = explode(';', $product);
                    $id = $product[0];
                    $name = $product[1];
                    $price = $product[2];
                    $quantity = $product[3];
                    $subtotal = $product[4];

                    Products::where('id', $id)->update([
                        'stock' => Products::where('id', $id)->first()->stock - $quantity
                    ]);

                    Detail_sales::create([
                        'sale_id' => Sales::latest()->first()->id,
                        'product_id' => $id,
                        'quantity' => $quantity,
                        'sub_total' => $subtotal,
                    ]);
                }
            }
            $sale = Sales::latest()->with('customer')->first();
            return redirect()->route('sales.showMember', $sale->id);
        }

        Sales::create([
            'sale_date' => now(),
            'customer_id' => null,
            'total_price' => $total,
            'total_pay' => $total_pay,
            'total_return' => $total_pay - $total,
            'user_id' => Auth::user()->id,
            'poin' => $total / 100,
            'used_point' => 0
        ]);
        foreach ($products as $product) {
            $product = explode(';', $product);
            $id = $product[0];
            $name = $product[1];
            $price = $product[2];
            $quantity = $product[3];
            $subtotal = $product[4];

            Products::where('id', $id)->update([
                'stock' => Products::where('id', $id)->first()->stock - $quantity
            ]);

            Detail_sales::create([
                'sale_id' => Sales::latest()->first()->id,
                'product_id' => $id,
                'quantity' => $quantity,
                'sub_total' => $subtotal,
            ]);
        }
        $sale = Sales::latest()->with('customer')->first();
        return redirect()->route('sales.printSale', $sale->id);
    }

    public function showMember($id)
    {
        $sale = Sales::findOrFail($id);
        $isFirst = Sales::where('customer_id', $sale->customer_id)->count() == 1 ? true : false;
        $detail_sale = Detail_sales::where('sale_id', $sale->id)->get();
        return view('views.pages.sales.member', compact('sale', 'detail_sale', 'isFirst'));
    }

    public function updateSale(Request $request, $id)
    {
        $sale = Sales::with('customer')->findOrFail($id);
        $customer = Customers::findOrFail($sale->customer_id);
        
        if ($request->has('name')) {
            $customer->update([
                'name' => $request->name,
            ]);
        }
        
        if ($request->check_poin == 'Ya') {
            $sale->update([
                'used_point' => $sale->customer->poin,
                'total_return' => $sale->total_return + $sale->customer->poin,
            ]);
            $customer->update([
                'poin' => 0
            ]);
        }
        
        return redirect()->route('sales.printSale', $sale->id);
    }
    

    public function printSale($id)
    {
        $sale = Sales::with('customer', 'user')->findOrFail($id);
        $detail_sale = Detail_sales::where('sale_id', $sale->id)->with('product')->get();
        return view('views.pages.sales.print', compact('sale', 'detail_sale'));
    }

    public function exportPDF($id)
    {
        $sale = Sales::with('customer', 'user')->findOrFail($id);
        $detail_sale = Detail_sales::where('sale_id', $sale->id)->with('product')->get();

        $data = [
            'sale' => $sale,
            'detail_sale' => $detail_sale,
            'isMember' => $sale->customer != null,
        ];
        // return view('views.pdf.invoice', $data);
        $pdf = Pdf::loadView('views.pdf.invoice', $data);
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('invoice.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'laporan-penjualan.xlsx');
    }

    public function show($id)
    {
        $sale = Sales::with('customer', 'user')->findOrFail($id);
        $detail_sale = Detail_sales::where('sale_id', $sale->id)->with('product')->get();

        // Check if the sale has a customer, otherwise set default values
        $customerName = $sale->customer ? $sale->customer->name : 'Non-Member';

        return view('views.pages.sales.show', compact('sale', 'detail_sale', 'customerName'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
