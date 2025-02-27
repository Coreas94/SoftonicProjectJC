<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DetectDuplicatesPhpTest extends TestCase
{
   public function testDetectDuplicatesRunsSuccessfully()
   {
      $sourcePath = 'dumps/source_test.csv';
      $catalogPath = 'dumps/catalog_test.csv';
      $outputPath = 'dumps/output_test.csv';

      Storage::makeDirectory('dumps');
      Storage::put($sourcePath, "id_store,publisher_url\n1,http://send.onenetworkdirect.net/z/263434/CD133141/");
      Storage::put($catalogPath, "url\nhttps://www.sysinfotools.com/recovery/pst-recovery.php");

      $this->artisan("detect:duplicatesphp", [
         'source' => $sourcePath,
         'catalog' => $catalogPath,
         'output' => $outputPath
      ])->assertExitCode(0);

      $this->assertTrue(Storage::exists($outputPath), 'Output file was not created');

      $outputContent = Storage::get($outputPath);
      $lines = explode("\n", trim($outputContent));
      $this->assertGreaterThan(1, count($lines), 'Output file is empty');

      Storage::delete([$sourcePath, $catalogPath, $outputPath]);
   }

}
