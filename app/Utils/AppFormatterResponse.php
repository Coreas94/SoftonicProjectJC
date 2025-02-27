<?php

namespace App\Utils;

class AppFormatterResponse
{
    public static function format(array $app, ?array $developer): array
    {
        return [
            'id' => $app['id'],
            'author_info' => [
                'name' => $developer['name'] ?? 'Unknown',
                'url' => $developer['url'] ?? '',
            ],
            'title' => $app['title'],
            'version' => $app['version'],
            'url' => $app['url'],
            'short_description' => $app['short_description'],
            'license' => $app['license'],
            'thumbnail' => $app['thumbnail'],
            'rating' => $app['rating'],
            'total_downloads' => $app['total_downloads'],
            'compatible' => is_array($app['compatible']) ? implode('|', $app['compatible']) : '',
        ];
    }
}
