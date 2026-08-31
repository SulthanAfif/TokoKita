@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-slate-500 hover:text-indigo-600 transition">← Kembali ke daftar</a>
        <h2 class="text-lg font-semibold text-slate-800 mt-2">Tambah Produk Baru</h2>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
          class="rounded-2xl border border-slate-200 bg-white p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
            <select name="category_id" required
                    class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Pilih kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4"
                      class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Harga <span class="text-red-500">*</span></label>
                <input type="number" name="price" value="{{ old('price') }}" min="0" step="1" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Harga Diskon</label>
                <input type="number" name="discount_price" value="{{ old('discount_price') }}" min="0" step="1"
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="Opsional">
                @error('discount_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">SKU <span class="text-red-500">*</span></label>
                <input type="text" name="sku" value="{{ old('sku') }}" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="Contoh: PRD-001">
                @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Foto Produk</label>
            <input type="file" name="thumbnail" accept="image/*"
                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
            @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            <p class="text-xs text-slate-400 my-2">— atau —</p>

            <input type="url" name="thumbnail_url" value="{{ old('thumbnail_url') }}"
                   placeholder="https://contoh.com/gambar-produk.jpg"
                   class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            <p class="text-xs text-slate-400 mt-1">Tempel link gambar dari internet. Isi salah satu saja (upload file akan diprioritaskan kalau keduanya diisi).</p>
            @error('thumbnail_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2.5 text-sm text-slate-700 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" checked
                   class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            Aktifkan produk (tampil di toko)
        </label>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                    class="rounded-xl bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 shadow-sm transition">
                Simpan Produk
            </button>
            <a href="{{ route('admin.products.index') }}"
               class="rounded-xl border border-slate-200 text-slate-600 px-5 py-2.5 text-sm font-medium hover:bg-slate-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection