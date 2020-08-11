<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $fillable = [
        'tag', 'title', 'subtitle', 'page_image', 'meta_description','reverse_direction',
    ];

    /**
     * 定义文章和标签的多对多关系
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag_pivot');
    }

    /**
     * Add any tags needed from the list
     * 从列表中添加所需的任何标记
     *
     * @param array $tags
     * @return array
     */
    public function addNeededTags(array $tags = [])
    {
        if (count($tags) === 0) {
            return $tags;
        }

        $found = static::whereIn('tag', $tags)->get()->pluck('tag')->all();
        foreach (array_diff($tags, $found) as $key => $vls) {
            static::create([
                'tag' => $tag,
                'title' => $tag,
                'subtitle' => 'Subtitle for '.$tag,
                'page_image' => '',
                'meta_description' => '',
                'reverse_direction' => false,
            ]);
        }
    }

    /**
     * Return the index layout to use for a tag
     *
     * @param string $tag
     * @param string $default
     * @return string
     */
    public static function layout($tag, $default = 'blog.index')
    {
        $layout = static::where('tag', $tag)->get()->pluck('layout')->first();

        return $layout ?: $default;
    }
}
