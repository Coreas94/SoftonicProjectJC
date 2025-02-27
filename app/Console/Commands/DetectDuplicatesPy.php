<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DetectDuplicatesPy extends Command
{
    protected $signature = 'detect:duplicatespy {source} {catalog} {output}';
    protected $description = 'Detect duplicate publisher URLs using Python';

    public function handle()
    {
        $sourceFile = $this->argument('source');
        $catalogFile = $this->argument('catalog');
        $outputFile = $this->argument('output');

        $scriptPath = base_path('scripts/detect_duplicates.py');
        
        $process = new Process(['python3', $scriptPath, $sourceFile, $catalogFile, $outputFile]);
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Error executing script ' . $process->getErrorOutput());
            return Command::FAILURE;
        }

        $this->info('Process completed. See results at: ' . $outputFile);
        return Command::SUCCESS;
    }
}
