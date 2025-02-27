<?php

namespace App\Utils;

use Illuminate\Support\Facades\File;
use SimpleXMLElement;

class DataFileLoader
{
    public static function load(string $filename): ?array
    {
        $path = base_path("outputs/{$filename}");

        if (!File::exists($path)) {
            return null;
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return match ($extension) {
            'json' => self::loadJson($path),
            'xml' => self::loadXml($path),
            default => null,
        };
    }

    private static function loadJson(string $path): array
    {
        return json_decode(File::get($path), true) ?? [];
    }

    private static function loadXml(string $path): array
    {
        $xmlContent = File::get($path);
        $xml = simplexml_load_string($xmlContent, SimpleXMLElement::class, LIBXML_NOCDATA);
        return json_decode(json_encode($xml), true) ?? [];
    }
}
