<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return view('views.pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('views.pages.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'img' => 'required'
        ]);
        $data = $request->all(); // Ambil semua request
        if ($request->file('img')) {
            $extension = $request->file('img')->getClientOriginalExtension();
            $newName = $request->name . '-' . now()->timestamp . '.' . $extension;
            $request->file('img')->storeAs('img', $newName, 'public');
            $data['img'] = $newName;
            $data['price'] = (int)str_replace(['Rp. ', '.'], '', $request->price);
            // dd($data['price']);
        }

        Products::create($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['product'] = Products::findOrFail($id);
        return view('views.pages.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menghapus format Rupiah dari input harga sebelum menyimpan ke database
        $price = str_replace(['Rp.', '.', ','], '', $request->price);

        // Temukan produk yang akan diupdate
        $product = Products::findOrFail($id);

        // Update data produk
        $product->update([
            'name' => $request->name,
            'price' => $price, // Harga yang sudah diformat
            'stock' => $request->stock,
        ]);

        // Jika ada gambar baru, upload gambar
        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('storage/img'), $imageName);
            $product->update(['img' => $imageName]);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function updateStock(Request $request, $id)
{
    // Validasi jumlah stok harus berupa angka dan minimal 1
    $request->validate([
        'stock' => 'required|integer|min:1',
    ]);

    // Temukan produk yang akan diupdate stoknya
    $product = Products::findOrFail($id);

    // Update stok produk
    $product->update([
        'stock' => $request->stock,
    ]);

    // Redirect kembali dengan pesan sukses
    return redirect()->route('products.index')->with('success', 'Stok produk berhasil diubah');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product, $id)
    {
        // Hapus gambar jika ada
        if ($product->image) {
            Storage::delete('public/image/' . $product->image);
        }

        $product = Products::find($id);

        // Hapus data produk dari database
        $product->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }
}
