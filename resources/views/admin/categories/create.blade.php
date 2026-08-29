@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-xl">
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-slate-500 hover:text-indigo-600">← Kembali</a>
    <h2 class="text-lg font-semibold text-slate-800 mt-2 mb-6">Tambah Kategori</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="rounded-2xl border border-slate-200 bg-white p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Contoh: Elektronik">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Slug <span class="text-slate-400 font-normal">(opsional)</span></label>
            <input type="text" name="slug" value="{{ old('slug') }}"
                   class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="otomatis dari nama jika kosong">
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3"
                      class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="rounded-xl bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Simpan Kategori
            </button>
            <a href="{{ route('admin.categories.index') }}"
               class="rounded-xl border border-slate-200 px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
