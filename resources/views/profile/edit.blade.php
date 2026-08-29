@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-8">Profil Saya</h1>

    {{-- Informasi Profil --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-1">Informasi Akun</h2>
        <p class="text-sm text-slate-500 mb-6">Perbarui nama, email, dan nomor telepon Anda.</p>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">No. Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                       placeholder="08xxxxxxxxxx"
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="rounded-full bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- Alamat Pengiriman --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-1">Alamat Pengiriman</h2>
        <p class="text-sm text-slate-500 mb-6">Alamat ini digunakan saat checkout. Minimal 1 alamat diperlukan.</p>

        @if($addresses->isNotEmpty())
            <div class="space-y-3 mb-6">
                @foreach($addresses as $address)
                    <div class="flex items-start justify-between gap-4 rounded-xl border border-slate-200 p-4">
                        <div class="text-sm">
                            <p class="font-semibold text-slate-800">
                                {{ $address->label }}
                                @if($address->is_default)
                                    <span class="ml-1 text-xs bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full">Default</span>
                                @endif
                            </p>
                            <p class="text-slate-600 mt-1">{{ $address->recipient_name }} · {{ $address->phone }}</p>
                            <p class="text-slate-500">{{ $address->full_address }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                        </div>
                        <form action="{{ route('profile.address.destroy', $address) }}" method="POST"
                              onsubmit="return confirm('Hapus alamat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('profile.address.store') }}" class="space-y-4 border-t border-slate-100 pt-6">
            @csrf
            <p class="text-sm font-medium text-slate-700">Tambah Alamat Baru</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Label</label>
                    <input type="text" name="label" value="{{ old('label', 'Rumah') }}" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Rumah / Kantor">
                    @error('label') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Nama Penerima</label>
                    <input type="text" name="recipient_name" value="{{ old('recipient_name', $user->name) }}" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('recipient_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm text-slate-600 mb-1">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="08xxxxxxxxxx">
                @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-slate-600 mb-1">Alamat Lengkap</label>
                <textarea name="full_address" rows="2" required
                          class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                          placeholder="Jl. Merdeka No. 123, RT 01/02">{{ old('full_address') }}</textarea>
                @error('full_address') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Kota</label>
                    <input type="text" name="city" value="{{ old('city') }}" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('city') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province') }}" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('province') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Kode Pos</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('postal_code') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="submit"
                    class="rounded-full bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Tambah Alamat
            </button>
        </form>
    </div>

    {{-- Ubah Password --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-1">Ubah Password</h2>
        <p class="text-sm text-slate-500 mb-6">Pastikan akun Anda menggunakan password yang kuat.</p>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="current-password">
                @error('current_password', 'updatePassword') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                <input type="password" id="password" name="password" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="new-password">
                @error('password', 'updatePassword') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="new-password">
            </div>

            <button type="submit"
                    class="rounded-full bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Update Password
            </button>
        </form>
    </div>

    {{-- Hapus Akun --}}
    <div class="rounded-2xl border border-red-200 bg-red-50 p-6">
        <h2 class="text-lg font-semibold text-red-700 mb-1">Hapus Akun</h2>
        <p class="text-sm text-red-600 mb-4">Setelah akun dihapus, semua data akan hilang secara permanen.</p>

        <form method="POST" action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.')">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label for="delete_password" class="block text-sm font-medium text-red-700 mb-1">Masukkan password untuk konfirmasi</label>
                <input type="password" id="delete_password" name="password" required
                       class="w-full max-w-sm rounded-xl border-red-300 text-sm focus:ring-red-500 focus:border-red-500">
                @error('password', 'userDeletion') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="rounded-full bg-red-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-red-500 transition">
                Hapus Akun Saya
            </button>
        </form>
    </div>
</div>
@endsection
