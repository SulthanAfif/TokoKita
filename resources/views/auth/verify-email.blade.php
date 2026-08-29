<x-guest-layout>
    <div class="mb-4 text-center">
        <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
            </svg>
        </div>
        <h2 class="text-lg font-bold text-gray-900">Verifikasi Email Anda</h2>
        <p class="mt-2 text-sm text-gray-600">
            Terima kasih sudah mendaftar! Silakan verifikasi email
            <strong class="text-gray-800">{{ auth()->user()->email }}</strong>
            sebelum mulai berbelanja.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
            Link verifikasi baru sudah dikirim. Cek email Anda (atau file log jika mode development).
        </div>
    @endif

    {{-- Tombol verifikasi langsung (praktis untuk demo/local tanpa SMTP) --}}
    <form method="POST" action="{{ route('verification.manual') }}" class="mb-4">
        @csrf
        <button type="submit"
                class="w-full rounded-xl bg-indigo-600 text-white font-semibold py-3 hover:bg-indigo-500 transition">
            ✓ Verifikasi Email Sekarang
        </button>
    </form>

    <div class="flex items-center justify-between gap-3 text-sm">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="text-indigo-600 hover:text-indigo-500 font-medium underline">
                Kirim ulang link
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-500 hover:text-gray-700 underline">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
