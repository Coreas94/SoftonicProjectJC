<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DetectDuplicatesPhp extends Command
{
    protected $signature = 'detect:duplicatesphp {source} {catalog} {output} 
        {--limit-source= : Limit number of records from source file} 
        {--limit-catalog= : Limit number of records from catalog file}';
    protected $description = 'Detect duplicate publisher URLs directly in Laravel';

    public function handle()
    {
        $sourceFile = 'dumps/' . basename($this->argument('source'));
        $catalogFile = 'dumps/' . basename($this->argument('catalog'));
        $outputFile = 'dumps/' . basename($this->argument('output'));

        if (!Storage::exists($sourceFile) || !Storage::exists($catalogFile)) {
            return Command::FAILURE;
        }

        $sourceData = array_map('str_getcsv', explode("\n", Storage::get($sourceFile)));
        $catalogData = array_map('str_getcsv', explode("\n", Storage::get($catalogFile)));

        $sourceHeader = array_shift($sourceData);
        $catalogHeader = array_shift($catalogData);

        $limitSource = $this->option('limit-source');
        $limitCatalog = $this->option('limit-catalog');

        if ($limitSource) {
            $sourceData = array_slice($sourceData, 0, (int)$limitSource);
        }
        if ($limitCatalog) {
            $catalogData = array_slice($catalogData, 0, (int)$limitCatalog);
        }

        if (!in_array('id_store', $sourceHeader) || !in_array('publisher_url', $sourceHeader)) {
            return Command::FAILURE;
        }

        if (!in_array('url', $catalogHeader)) {
            return Command::FAILURE;
        }

        $idIndex = array_search('id_store', $sourceHeader);
        $urlIndex = array_search('publisher_url', $sourceHeader);

        $sourceCollection = collect($sourceData)->map(fn($row) => [
            'id_store' => $row[$idIndex] ?? '',
            'publisher_url' => $this->normalizeUrl($row[$urlIndex] ?? '')
        ])->filter(fn($row) => !empty($row['id_store']) && !empty($row['publisher_url']));

        $catalogCollection = collect($catalogData)->map(fn($row) => $this->normalizeUrl($row[0] ?? ''))
            ->filter();
        
        $notSimilarIds = [];

        foreach ($sourceCollection as $source) {
            $matches = $catalogCollection->map(fn($catalogUrl) => 
                similar_text($source['publisher_url'], $catalogUrl, $percent) ? $percent : 0
            );
            
            if ($matches->max() < 85) {
                $notSimilarIds[] = [$source['id_store']];
            }
        }

        $csvContent = "id_store\n" . implode("\n", array_map(fn($id) => $id[0], $notSimilarIds));
        Storage::put($outputFile, $csvContent);

        $this->info("Completed process. " . count($notSimilarIds) . " records saved in $outputFile");

        return Command::SUCCESS;
    }

    private function normalizeUrl(string $url): string 
    {
        $url = strtolower(trim($url));
        $url = rtrim($url, '/');
        $url = preg_replace('#^https?://#', '', $url);
        $url = preg_replace('#^www\.#', '', $url);
        return $url;
    }
}
