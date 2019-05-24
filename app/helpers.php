<?php

function outPutFileSize($bytes, $decimals = 2)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

/**
 * 判断文件的MIME类型是否为图片
 */
function isImage($mimeType)
{
    return starts_with($mimeType, 'image/');
}

/**
 * 返回列表中选择的值的checked
 *
 * @param $value
 * @return string
 */
function checked($value)
{
    return $value ? 'checked' : '';
}

/**
 * Return img url for headers
 * 返回图片url作为头文件
 *
 */
function pageImage($value = null)
{
    if (empty($value)) {
        $value = config('blog.page_image');
    }
    if (!starts_with($value, 'http') && (isset($value[0]) && $value[0] !== '/')) {
        $value = config('blog.uploads.webPath') . '/' . $value;
    }

    return $value;
}