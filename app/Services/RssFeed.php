<?php

namespace App\Services;


use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed
{
    public function getRss()
    {
        if (Cache::has('rss-reed')) {
            return Cache::get('rss-reed');
        }

        $rss = $this->buildRssData();
        Cache::add('rss-reed', $rss, 120);

        return $rss;
    }

    /**
     * 构建rss数据
     */
    public function buildRssData()
    {
       $carbon  = Carbon::now();
       $feed    = new Feed();
       $channel = new Channel();

        $channel->title(config('blog.title'))
            ->description(config('blog.description'))
            ->url(url('/'))
            ->language('en')
            ->copyright('Copyright (c) ' . config('author'))
            ->lastBuildDate($carbon->timestamp)
            ->appendTo($feed);

        $post = Post::where('published_at', '<=', $carbon)
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->take(config('blog.rss_size'))
            ->get();

        $data = array();
        foreach ($post as $key => $vls) {
            $item = new Item();
            $item->title($vls->title)
                ->description($vls->subtitle)
                ->url($vls->url())
                ->pubDate($vls->published_at->timestamp)
                ->guid($vls->url(), true)
                ->appendTo($channel);
        }

        $feed = (string)$feed;

        // Replace a couple items to make the feed more compliant
        $feed = str_replace(
            '<rss version="2.0">',
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
            $feed
        );
        $feed = str_replace(
            '<channel>',
            '<channel>' . "\n" . '    <atom:link href="' . url('/rss') .
            '" rel="self" type="application/rss+xml" />',
            $feed
        );

        return $feed;

    }
}