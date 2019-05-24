<?php

namespace App\Services;

use Michelf\MarkdownExtra;
use Michelf\SmartyPants;

class Markdowner
{
    public function toHtml($text)
    {
        $this->preTransformText($text);
        MarkdownExtra::defaultTransform($text);
        SmartyPants::defaultTransform($text);
        $this->postTransformText($text);
    }

    protected function preTransformText($text)
    {
        return $text;
    }

    protected function postTransformText($text)
    {
        return $text;
    }
}