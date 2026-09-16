<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * HeroSlideController (Admin)
 * ---------------------------
 * Mengelola gambar carousel di beranda (hero slides).
 * Fitur:
 * - Tambah slide (upload file atau URL)
 * - Edit / aktif-nonaktifkan
 * - Hapus
 * - Reorder (drag & drop via AJAX)
 */
class HeroSlideController extends Controller
{
    /**
     * Daftar semua slide (diurutkan)
     */
    public function index()
    {
        $slides = HeroSlide::ordered()->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    /**
     * Tambah slide baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'     => 'nullable|image|max:4096',   // Max 4MB
            'image_url' => 'nullable|url|max:2048',
            'title'     => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Harus ada gambar (file ATAU URL)
        if (!$request->hasFile('image') && empty($validated['image_url'])) {
            return back()
                ->withErrors(['image' => 'Upload gambar atau isi URL gambar.'])
                ->withInput();
        }

        // Tentukan path gambar
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hero-slides', 'public');
        } else {
            $path = $validated['image_url'];
        }

        // Letakkan di urutan paling akhir
        $maxOrder = HeroSlide::max('sort_order') ?? 0;

        HeroSlide::create([
            'image'      => $path,
            'title'      => $validated['title'] ?? null,
            'sort_order' => $maxOrder + 1,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Slide hero berhasil ditambahkan.');
    }

    /**
     * Update slide
     */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'image'      => 'nullable|image|max:4096',
            'image_url'  => 'nullable|url|max:2048',
            'title'      => 'nullable|string|max:255',
            'is_active'  => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Ganti gambar jika ada upload baru atau URL baru
        if ($request->hasFile('image')) {
            // Hapus file lama (jika lokal)
            if ($heroSlide->image && !str_starts_with($heroSlide->image, 'http')) {
                Storage::disk('public')->delete($heroSlide->image);
            }
            $heroSlide->image = $request->file('image')->store('hero-slides', 'public');
        } elseif (!empty($validated['image_url'])) {
            if ($heroSlide->image && !str_starts_with($heroSlide->image, 'http')) {
                Storage::disk('public')->delete($heroSlide->image);
            }
            $heroSlide->image = $validated['image_url'];
        }

        $heroSlide->title     = $validated['title'] ?? $heroSlide->title;
        $heroSlide->is_active = $request->boolean('is_active');

        if (array_key_exists('sort_order', $validated) && $validated['sort_order'] !== null) {
            $heroSlide->sort_order = $validated['sort_order'];
        }

        $heroSlide->save();

        return back()->with('success', 'Slide berhasil diperbarui.');
    }

    /**
     * Hapus slide (+ hapus file gambar)
     */
    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image && !str_starts_with($heroSlide->image, 'http')) {
            Storage::disk('public')->delete($heroSlide->image);
        }

        $heroSlide->delete();

        return back()->with('success', 'Slide berhasil dihapus.');
    }

    /**
     * Reorder slide via AJAX (drag & drop)
     * Body: { order: [id1, id2, id3, ...] }
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:hero_slides,id',
        ]);

        // Update sort_order sesuai urutan array
        foreach ($request->order as $index => $id) {
            HeroSlide::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
