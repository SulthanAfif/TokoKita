@extends('layouts.app')

@section('title', $page->title ?? 'Tentang Kami')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-slate-800">{{ $page->title ?? 'Tentang TokoKita' }}</h1>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-8 sm:p-10 space-y-4 text-slate-600 leading-relaxed">
        @if($page && $page->content)
            @foreach(preg_split('/\n\s*\n/', $page->content) as $paragraph)
                @if(trim($paragraph))
                    <p>{{ trim($paragraph) }}</p>
                @endif
            @endforeach
        @else
            <p class="text-slate-400 text-center">Konten belum tersedia.</p>
        @endif
    </div>
</div>
@endsection
