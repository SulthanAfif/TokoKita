@extends('layouts.admin')

@section('title', 'Statistik & Konten Beranda')

@section('content')
<div x-data="homePreview()" class="space-y-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Edit Konten Beranda</h2>
        <p class="text-sm text-slate-500">Ubah teks di kiri — preview langsung di kanan (mirip tampilan toko).</p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">

        {{-- ========== FORM ========== --}}
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5" id="settings-form">
            @csrf
            @method('PUT')

            {{-- HERO --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 space-y-3">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2 text-sm">Hero</h3>

                @foreach([
                    'hero_badge' => 'Badge',
                    'hero_title_1' => 'Judul baris 1',
                    'hero_title_2' => 'Judul baris 2',
                    'hero_subtitle' => 'Subjudul',
                    'hero_stat_1_value' => 'Stat 1 nilai',
                    'hero_stat_1_label' => 'Stat 1 label',
                    'hero_stat_2_value' => 'Stat 2 nilai',
                    'hero_stat_2_label' => 'Stat 2 label',
                    'hero_stat_3_value' => 'Stat 3 nilai',
                    'hero_stat_3_label' => 'Stat 3 label',
                    'hero_card_title' => 'Kartu kanan judul',
                    'hero_card_subtitle' => 'Kartu kanan subjudul',
                    'hero_badge_promo' => 'Badge PROMO',
                    'hero_badge_flash' => 'Badge Flash Sale',
                ] as $key => $label)
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">{{ $label }}</label>
                        @if(in_array($key, ['hero_subtitle', 'hero_card_title']))
                            <textarea name="{{ $key }}" rows="2" x-model="{{ $key }}"
                                      class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old($key, $settings[$key]->value ?? $fields[$key][0]) }}</textarea>
                        @else
                            <input type="text" name="{{ $key }}" x-model="{{ $key }}"
                                   value="{{ old($key, $settings[$key]->value ?? $fields[$key][0]) }}"
                                   class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @endif
                        @error($key) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endforeach
            </div>

            {{-- TRUST --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 space-y-3">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2 text-sm">Trust Bar</h3>
                <div class="grid sm:grid-cols-2 gap-3">
                    @foreach([1,2,3,4] as $i)
                        <div class="rounded-xl border border-slate-100 p-3 space-y-2">
                            <p class="text-[10px] font-semibold text-slate-400 uppercase">Kartu {{ $i }}</p>
                            <input type="text" name="trust_{{ $i }}_title" x-model="trust_{{ $i }}_title"
                                   value="{{ old('trust_'.$i.'_title', $settings['trust_'.$i.'_title']->value ?? $fields['trust_'.$i.'_title'][0]) }}"
                                   placeholder="Judul"
                                   class="w-full rounded-lg border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <input type="text" name="trust_{{ $i }}_desc" x-model="trust_{{ $i }}_desc"
                                   value="{{ old('trust_'.$i.'_desc', $settings['trust_'.$i.'_desc']->value ?? $fields['trust_'.$i.'_desc'][0]) }}"
                                   placeholder="Deskripsi"
                                   class="w-full rounded-lg border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- PROMO --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 space-y-3">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2 text-sm">Banner Promo</h3>
                @foreach([
                    'promo_eyebrow' => 'Label kecil',
                    'promo_title' => 'Judul',
                    'promo_subtitle' => 'Subjudul',
                    'promo_button' => 'Teks tombol',
                ] as $key => $label)
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">{{ $label }}</label>
                        <input type="text" name="{{ $key }}" x-model="{{ $key }}"
                               value="{{ old($key, $settings[$key]->value ?? $fields[$key][0]) }}"
                               class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                @endforeach
            </div>

            <button type="submit"
                    class="w-full sm:w-auto rounded-xl bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
                Simpan Semua Perubahan
            </button>
        </form>

        {{-- ========== LIVE PREVIEW ========== --}}
        <div class="xl:sticky xl:top-20 space-y-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Preview langsung</p>

            {{-- Hero preview --}}
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-600 text-white p-6 shadow-xl">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-[11px] font-semibold border border-white/20 mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span x-text="hero_badge"></span>
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                    <span x-text="hero_title_1"></span><br>
                    <span class="bg-gradient-to-r from-yellow-200 via-pink-200 to-white bg-clip-text text-transparent" x-text="hero_title_2"></span>
                </h1>
                <p class="mt-3 text-sm text-indigo-100 leading-relaxed" x-text="hero_subtitle"></p>

                <div class="mt-5 flex flex-wrap gap-5">
                    <div>
                        <p class="text-xl font-extrabold" x-text="hero_stat_1_value"></p>
                        <p class="text-[10px] text-indigo-200" x-text="hero_stat_1_label"></p>
                    </div>
                    <div>
                        <p class="text-xl font-extrabold" x-text="hero_stat_2_value"></p>
                        <p class="text-[10px] text-indigo-200" x-text="hero_stat_2_label"></p>
                    </div>
                    <div>
                        <p class="text-xl font-extrabold" x-text="hero_stat_3_value"></p>
                        <p class="text-[10px] text-indigo-200" x-text="hero_stat_3_label"></p>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="bg-gradient-to-r from-pink-500 to-rose-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full" x-text="hero_badge_promo"></span>
                    <span class="bg-white text-indigo-700 text-[10px] font-bold px-2.5 py-1 rounded-full" x-text="hero_badge_flash"></span>
                </div>
                <p class="mt-3 text-xs text-indigo-200/80">
                    Kartu: <span class="font-semibold text-white" x-text="hero_card_title.replace(/\\n/g, ' ')"></span>
                    · <span x-text="hero_card_subtitle"></span>
                </p>
            </div>

            {{-- Trust preview --}}
            <div class="grid grid-cols-2 gap-2">
                <template x-for="(t, i) in [
                    {title: trust_1_title, desc: trust_1_desc},
                    {title: trust_2_title, desc: trust_2_desc},
                    {title: trust_3_title, desc: trust_3_desc},
                    {title: trust_4_title, desc: trust_4_desc},
                ]" :key="i">
                    <div class="rounded-xl bg-white border border-slate-100 p-3 shadow-sm">
                        <p class="text-xs font-bold text-slate-800" x-text="t.title"></p>
                        <p class="text-[10px] text-slate-400" x-text="t.desc"></p>
                    </div>
                </template>
            </div>

            {{-- Promo preview --}}
            <div class="rounded-2xl bg-gradient-to-r from-rose-500 via-pink-500 to-orange-400 text-white p-5 shadow-lg">
                <p class="text-[10px] font-bold uppercase tracking-widest text-white/80 mb-1" x-text="promo_eyebrow"></p>
                <h3 class="text-lg font-extrabold" x-text="promo_title"></h3>
                <p class="text-xs text-white/80 mt-1" x-text="promo_subtitle"></p>
                <span class="inline-block mt-3 rounded-full bg-white text-pink-600 text-xs font-bold px-4 py-1.5" x-text="promo_button"></span>
            </div>
        </div>
    </div>
</div>

<script>
function homePreview() {
    return {
        hero_badge: @json(old('hero_badge', $settings['hero_badge']->value ?? $fields['hero_badge'][0])),
        hero_title_1: @json(old('hero_title_1', $settings['hero_title_1']->value ?? $fields['hero_title_1'][0])),
        hero_title_2: @json(old('hero_title_2', $settings['hero_title_2']->value ?? $fields['hero_title_2'][0])),
        hero_subtitle: @json(old('hero_subtitle', $settings['hero_subtitle']->value ?? $fields['hero_subtitle'][0])),
        hero_stat_1_value: @json(old('hero_stat_1_value', $settings['hero_stat_1_value']->value ?? $fields['hero_stat_1_value'][0])),
        hero_stat_1_label: @json(old('hero_stat_1_label', $settings['hero_stat_1_label']->value ?? $fields['hero_stat_1_label'][0])),
        hero_stat_2_value: @json(old('hero_stat_2_value', $settings['hero_stat_2_value']->value ?? $fields['hero_stat_2_value'][0])),
        hero_stat_2_label: @json(old('hero_stat_2_label', $settings['hero_stat_2_label']->value ?? $fields['hero_stat_2_label'][0])),
        hero_stat_3_value: @json(old('hero_stat_3_value', $settings['hero_stat_3_value']->value ?? $fields['hero_stat_3_value'][0])),
        hero_stat_3_label: @json(old('hero_stat_3_label', $settings['hero_stat_3_label']->value ?? $fields['hero_stat_3_label'][0])),
        hero_card_title: @json(old('hero_card_title', $settings['hero_card_title']->value ?? $fields['hero_card_title'][0])),
        hero_card_subtitle: @json(old('hero_card_subtitle', $settings['hero_card_subtitle']->value ?? $fields['hero_card_subtitle'][0])),
        hero_badge_promo: @json(old('hero_badge_promo', $settings['hero_badge_promo']->value ?? $fields['hero_badge_promo'][0])),
        hero_badge_flash: @json(old('hero_badge_flash', $settings['hero_badge_flash']->value ?? $fields['hero_badge_flash'][0])),
        trust_1_title: @json(old('trust_1_title', $settings['trust_1_title']->value ?? $fields['trust_1_title'][0])),
        trust_1_desc: @json(old('trust_1_desc', $settings['trust_1_desc']->value ?? $fields['trust_1_desc'][0])),
        trust_2_title: @json(old('trust_2_title', $settings['trust_2_title']->value ?? $fields['trust_2_title'][0])),
        trust_2_desc: @json(old('trust_2_desc', $settings['trust_2_desc']->value ?? $fields['trust_2_desc'][0])),
        trust_3_title: @json(old('trust_3_title', $settings['trust_3_title']->value ?? $fields['trust_3_title'][0])),
        trust_3_desc: @json(old('trust_3_desc', $settings['trust_3_desc']->value ?? $fields['trust_3_desc'][0])),
        trust_4_title: @json(old('trust_4_title', $settings['trust_4_title']->value ?? $fields['trust_4_title'][0])),
        trust_4_desc: @json(old('trust_4_desc', $settings['trust_4_desc']->value ?? $fields['trust_4_desc'][0])),
        promo_eyebrow: @json(old('promo_eyebrow', $settings['promo_eyebrow']->value ?? $fields['promo_eyebrow'][0])),
        promo_title: @json(old('promo_title', $settings['promo_title']->value ?? $fields['promo_title'][0])),
        promo_subtitle: @json(old('promo_subtitle', $settings['promo_subtitle']->value ?? $fields['promo_subtitle'][0])),
        promo_button: @json(old('promo_button', $settings['promo_button']->value ?? $fields['promo_button'][0])),
    }
}
</script>
@endsection
