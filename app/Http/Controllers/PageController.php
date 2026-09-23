<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::findBySlug('about');

        return view('pages.about', compact('page'));
    }

    public function contact()
    {
        $page = Page::findBySlug('contact');

        return view('pages.contact', compact('page'));
    }
}
