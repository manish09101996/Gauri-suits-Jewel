<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::published()
            ->latest('published_at')
            ->paginate(9);

        return view('storefront.blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('storefront.blog.show', compact('post', 'recentPosts'));
    }
}
