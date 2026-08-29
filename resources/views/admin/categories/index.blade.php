@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Manajemen Kategori Produk</h2>
        <p class="text-sm text-slate-500">{{ $categories->total() }} kategori</p>
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 text-white px-5 py-2.5 text-sm font-semibold hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Kategori
    </a>
</div>

<form method="GET" class="flex flex-wrap items-center gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
           class="rounded-xl border-slate-200 bg-white px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
    <button type="submit" class="rounded-xl bg-slate-800 text-white px-4 py-2 text-sm font-medium hover:bg-slate-700">Cari</button>
</form>

<div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
    <div class="overflow-x-auto table-scroll">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Nama Kategori</th>
                    <th class="px-5 py-3 font-medium">Slug</th>
                    <th class="px-5 py-3 font-medium">Jumlah Produk</th>
                    <th class="px-5 py-3 font-medium">Dibuat</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-slate-800">{{ $category->name }}</p>
                            @if($category->description)
                                <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $category->description }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-xs font-mono text-slate-400">{{ $category->slug }}</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold
                                {{ $category->products_count > 0 ? 'bg-indigo-50 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $category->products_count }} produk
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500">{{ $category->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-slate-400">Belum ada kategori. Tambahkan kategori pertama.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($categories->hasPages())
    <div class="mt-6">{{ $categories->links() }}</div>
@endif
@endsection
