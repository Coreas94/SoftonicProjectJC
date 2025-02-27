<?php

namespace Tests\Unit;

use App\Utils\DataFileLoader;
use Tests\TestCase;

class DataFileLoaderTest extends TestCase
{
    public function test_load_existing_json_file()
    {
        $data = DataFileLoader::load('app.json');

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('id', $data[0]);
    }

    public function test_load_non_existing_json_file()
    {
        $data = DataFileLoader::load('non_existing.json');

        $this->assertNull($data);
    }
}
