<?php

return [
    'name' => "锋子博客",
    'title' => "锋子博客",
    'subtitle' => 'http://fengzi.com',
    'description' => '记录平时自己的一些生活和琐事',
    'author' => '锋子',
    'page_image' => 'home-bg.jpg',
    'posts_per_page' => 10,
    'rss_size' => 20,
    'uploads' => [
        'storage' => 'public',
        'webpath' => '/storage/uploads',
    ],
    'contact_email' => env('MAIL_FROM'),
];