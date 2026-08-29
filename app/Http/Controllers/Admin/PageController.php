<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ];

        if ($page->slug === 'contact') {
            $rules['email'] = 'nullable|email|max:255';
            $rules['phone'] = 'nullable|string|max:50';
            $rules['address'] = 'nullable|string|max:500';
        }

        $validated = $request->validate($rules);

        $page->title = $validated['title'];
        $page->content = $validated['content'] ?? null;

        if ($page->slug === 'contact') {
            $page->meta = [
                'email' => $validated['email'] ?? '',
                'phone' => $validated['phone'] ?? '',
                'address' => $validated['address'] ?? '',
            ];
        }

        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        // Reset konten, bukan hapus halaman (agar route tetap jalan)
        $page->update([
            'content' => null,
            'meta' => $page->slug === 'contact'
                ? ['email' => '', 'phone' => '', 'address' => '']
                : null,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Konten halaman berhasil dikosongkan.');
    }
}
