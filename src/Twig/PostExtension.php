<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PostExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('post_title', [$this, 'formatToPostTitle']),
            new TwigFilter('post_description', [$this, 'formatToPostDescription']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            // new TwigFunction('post_title', [$this, 'formatToPostTitle']),
        ];
    }

    public function formatToPostTitle(string $title, int $length = 50): string 
    {
        return substr($title, 0, $length);
    }

    public function formatToPostDescription(string $description, int $length = 150): string
    {
        return substr($description, 0, $length) . '...';
    }
}
