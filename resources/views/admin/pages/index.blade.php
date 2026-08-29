@extends('layouts.admin')

@section('title', 'Kelola Halaman')

@section('content')
<div class="mb-6">
    <h2 class="text-lg font-semibold text-slate-800">Halaman Statis</h2>
    <p class="text-sm text-slate-500">Edit konten halaman Tentang & Kontak tanpa mengubah kode.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    @foreach($pages as $page)
        <div class="rounded-2xl border border-slate-200 bg-white p-5 flex flex-col">
            <div class="flex items-start justify-between gap-3 mb-3">
                <div>
                    <h3 class="font-semibold text-slate-800">{{ $page->title }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">/{{ $page->slug === 'about' ? 'tentang' : 'kontak' }}</p>
                </div>
                <span class="text-[10px] uppercase tracking-wider font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500">
                    {{ $page->slug }}
                </span>
            </div>
            <p class="text-sm text-slate-500 line-clamp-2 flex-1 mb-4">
                {{ Str::limit(strip_tags($page->content ?? 'Belum ada konten.'), 120) }}
            </p>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.pages.edit', $page) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                    Edit
                </a>
                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                      onsubmit="return confirm('Kosongkan konten halaman ini?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 transition">
                        Kosongkan
                    </button>
                </form>
                <a href="{{ $page->slug === 'about' ? route('pages.about') : route('pages.contact') }}" target="_blank"
                   class="ml-auto text-xs text-slate-400 hover:text-indigo-600 transition">
                    Lihat →
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection
