<?php

namespace App\Services;


use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class SiteMap
{
    public function getSiteMap()
    {
        if (Cache::has('site-map')) {
            return Cache::get('site-map');
        }

        $map = $this->buildSiteMap();

        Cache::add('site-map', $map, 120);
        return$map;
    }

    public function buildSiteMap()
    {
        $postInfo = $this->getPostsInfo();
        $postData = array_values($postInfo);
        sort($postData);

        $last = last($postData);
        $url = trim(url('/'), '/') . '/';

        $xml = array();
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?' . '>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml[] = '  <url>';
        $xml[] = "    <loc>$url</loc>";
        $xml[] = "    <lastmod>$last</lastmod>";
        $xml[] = '    <changefreq>daily</changefreq>';
        $xml[] = '    <priority>0.8</priority>';
        $xml[] = '  </url>';

        foreach ($postInfo as $key => $lastmod) {
            $xml[] = '  <url>';
            $xml[] = "    <loc>{$url}blog/$key</loc>";
            $xml[] = "    <lastmod>$lastmod</lastmod>";
            $xml[] = "  </url>";
        }

        $xml[] = '</urlset>';

        return join("\n", $xml);
    }

    /**
     * Return all the posts as $url => $date
     */
    protected function getPostsInfo()
    {
        return Post::where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->pluck('updated_at', 'slug')
            ->all();
    }
}