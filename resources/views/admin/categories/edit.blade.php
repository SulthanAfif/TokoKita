@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-xl">
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-slate-500 hover:text-indigo-600">← Kembali</a>
    <h2 class="text-lg font-semibold text-slate-800 mt-2 mb-6">Edit Kategori</h2>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="rounded-2xl border border-slate-200 bg-white p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                   class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                   class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3"
                      class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $category->description) }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="rounded-xl bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.categories.index') }}"
               class="rounded-xl border border-slate-200 px-6 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
