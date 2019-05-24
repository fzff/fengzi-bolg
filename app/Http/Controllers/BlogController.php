<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\Tags;
use App\Services\PostService;
use App\Services\RssFeed;
use App\Services\SiteMap;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    protected $rssFeed;
    protected $siteMap;

    public function __construct(RssFeed $rssFeed, SiteMap $siteMap)
    {
        $this->rssFeed = $rssFeed;
        $this->siteMap = $siteMap;
    }

    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $postService = new PostService($tag);
        $data = $postService->lists();
        $layout = $tag ? Tags::layout($tag) : 'blog.layouts.index';

        return view($layout, $data);
    }

    public function showPost($slug, Request $request)
    {
        $post = Post::with('tags')->where('slug', $slug)->firstOrFail();
        $tag = $request->get('tag');
        if ($tag) {
            $tag = Tags::where('tag', $tag)->firstOrFail();
        }

        return view($post->layout, compact('post', 'tag'));
    }

    public function rss()
    {
       $rss = $this->rssFeed->getRss();

       return response($rss)
           ->header('Content-Type', 'application/rss+xml');
    }

    public function siteMap()
    {
        $siteMap = $this->siteMap->getSiteMap();

        return response($siteMap)
            ->header('Content-type', 'application/xml');
    }
}