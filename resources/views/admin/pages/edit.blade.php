@extends('layouts.admin')

@section('title', 'Edit: ' . $page->title)

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.pages.index') }}" class="text-sm text-slate-500 hover:text-indigo-600 transition">← Kembali</a>
        <h2 class="text-lg font-semibold text-slate-800 mt-2">Edit Halaman</h2>
        <p class="text-sm text-slate-500">{{ $page->title }}</p>
    </div>

    <form action="{{ route('admin.pages.update', $page) }}" method="POST"
          class="rounded-2xl border border-slate-200 bg-white p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title', $page->title) }}" required
                   class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Konten</label>
            <textarea name="content" rows="8"
                      class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Tulis konten halaman di sini...">{{ old('content', $page->content) }}</textarea>
            <p class="text-xs text-slate-400 mt-1">Bisa pakai baris baru. Akan ditampilkan sebagai paragraf.</p>
            @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        @if($page->slug === 'contact')
            <div class="border-t border-slate-100 pt-5 space-y-4">
                <p class="text-sm font-medium text-slate-700">Info Kontak</p>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $page->meta['email'] ?? '') }}"
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Telepon / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $page->meta['phone'] ?? '') }}"
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Alamat</label>
                    <input type="text" name="address" value="{{ old('address', $page->meta['address'] ?? '') }}"
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        @endif

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                    class="rounded-xl bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.pages.index') }}"
               class="rounded-xl border border-slate-200 text-slate-600 px-5 py-2.5 text-sm font-medium hover:bg-slate-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
