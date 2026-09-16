<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

/**
 * PageController (Admin)
 * ----------------------
 * Mengelola halaman statis: Tentang Kami & Kontak.
 * - Edit judul + konten
 * - Untuk halaman kontak: juga bisa edit email, telepon, alamat
 * - "Hapus" hanya mengosongkan konten (halaman tetap ada agar route tidak error)
 */
class PageController extends Controller
{
    /**
     * Daftar halaman yang bisa diedit
     */
    public function index()
    {
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Form edit halaman
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Simpan perubahan halaman
     */
    public function update(Request $request, Page $page)
    {
        // Validasi dasar
        $rules = [
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
        ];

        // Validasi tambahan khusus halaman kontak
        if ($page->slug === 'contact') {
            $rules['email']   = 'nullable|email|max:255';
            $rules['phone']   = 'nullable|string|max:50';
            $rules['address'] = 'nullable|string|max:500';
        }

        $validated = $request->validate($rules);

        // Update judul & konten
        $page->title   = $validated['title'];
        $page->content = $validated['content'] ?? null;

        // Update meta (email, phone, address) khusus kontak
        if ($page->slug === 'contact') {
            $page->meta = [
                'email'   => $validated['email'] ?? '',
                'phone'   => $validated['phone'] ?? '',
                'address' => $validated['address'] ?? '',
            ];
        }

        $page->save();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil diperbarui.');
    }

    /**
     * "Hapus" = kosongkan konten (bukan delete record)
     * Agar route /tentang dan /kontak tetap berfungsi
     */
    public function destroy(Page $page)
    {
        $page->update([
            'content' => null,
            'meta'    => $page->slug === 'contact'
                ? ['email' => '', 'phone' => '', 'address' => '']
                : null,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Konten halaman berhasil dikosongkan.');
    }
}
