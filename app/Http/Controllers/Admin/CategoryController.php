<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * CategoryController (Admin)
 * --------------------------
 * CRUD kategori produk.
 * - Tidak bisa hapus kategori yang masih dipakai produk.
 */
class CategoryController extends Controller
{
    /**
     * Daftar kategori + jumlah produk di masing-masing
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('products') // Hitung relasi products
            ->when($request->search, fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Form tambah kategori
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'slug'        => 'nullable|string|max:255|unique:categories,slug',
        ]);

        // Jika slug kosong, generate otomatis dari nama
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Form edit kategori
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update kategori
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            // Unique name, tapi ignore kategori ini sendiri
            'name'        => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => 'nullable|string|max:1000',
            'slug'        => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori
     * Hanya boleh jika tidak ada produk yang memakai kategori ini
     */
    public function destroy(Category $category)
    {
        $count = $category->products()->count();

        if ($count > 0) {
            return back()->with('error',
                "Kategori tidak bisa dihapus karena masih dipakai {$count} produk. Pindahkan atau hapus produknya dulu."
            );
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
