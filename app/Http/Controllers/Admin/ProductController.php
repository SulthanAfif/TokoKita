<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * ProductController (Admin)
 * -------------------------
 * CRUD produk dari sisi admin:
 * - index   : daftar produk + search
 * - create  : form tambah produk
 * - store   : simpan produk baru
 * - edit    : form edit produk
 * - update  : update data produk
 * - destroy : hapus produk (+ hapus file gambar)
 */
class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk (dengan search & jumlah terjual)
     */
    public function index(Request $request)
    {
        $products = Product::with('category')
            // Hitung total quantity yang terjual (exclude order cancelled)
            ->withSum(['orderItems as sold_qty' => function ($q) {
                $q->whereHas('order', fn ($o) => $o->where('status', '!=', 'cancelled'));
            }], 'quantity')
            // Filter pencarian nama
            ->when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Tampilkan form tambah produk
     */
    public function create()
    {
        $categories = Category::all(); // Dropdown kategori
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Simpan produk baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price', // Harus lebih kecil dari price
            'stock'          => 'required|integer|min:0',
            'sku'            => 'required|string|unique:products,sku',
            'thumbnail'      => 'nullable|image|max:2048',          // Max 2MB
            'thumbnail_url'  => 'nullable|url|max:2048',            // Atau pakai URL eksternal
            'is_active'      => 'boolean',
        ]);

        // Handle gambar: upload file ATAU pakai URL
        if ($request->hasFile('thumbnail')) {
            // Simpan file ke storage/app/public/products
            $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        } elseif (!empty($validated['thumbnail_url'])) {
            // Simpan URL langsung (tidak di-download)
            $validated['thumbnail'] = $validated['thumbnail_url'];
        }
        unset($validated['thumbnail_url']); // Hapus key yang tidak ada di tabel

        // Checkbox is_active: true jika dicentang, false jika tidak
        $validated['is_active'] = $request->boolean('is_active');

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit produk
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update data produk
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock'          => 'required|integer|min:0',
            // Unique SKU, tapi ignore SKU produk ini sendiri
            'sku'            => 'required|string|unique:products,sku,' . $product->id,
            'thumbnail'      => 'nullable|image|max:2048',
            'thumbnail_url'  => 'nullable|url|max:2048',
            'is_active'      => 'boolean',
        ]);

        // Handle ganti gambar
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama (jika file lokal, bukan URL)
            if ($product->thumbnail && !str_starts_with($product->thumbnail, 'http')) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        } elseif (!empty($validated['thumbnail_url'])) {
            if ($product->thumbnail && !str_starts_with($product->thumbnail, 'http')) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $validated['thumbnail'] = $validated['thumbnail_url'];
        }
        unset($validated['thumbnail_url']);

        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk (+ hapus file gambar jika ada)
     */
    public function destroy(Product $product)
    {
        // Hapus file gambar lokal (jika bukan URL eksternal)
        if ($product->thumbnail && !str_starts_with($product->thumbnail, 'http')) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
