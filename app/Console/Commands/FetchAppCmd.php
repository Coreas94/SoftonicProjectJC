<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Utils\DataFileLoader;
use App\Utils\AppFormatterResponse;

class FetchAppCmd extends Command
{
   protected $signature = 'app:fetch {id}';
   protected $description = 'Fetch app information by ID';

   public function handle()
   {
      $id = $this->argument('id');
      $app = $this->findApp($id);

      if (!$app) {
         $this->error("App not found");
         return;
      }

      $developer = $this->getDeveloper($app['developer_id']);

      $this->line(json_encode(AppFormatterResponse::format($app, $developer), JSON_PRETTY_PRINT));
   }

   private function findApp(string $id): ?array
   {
      $apps = DataFileLoader::load('app.json');
      foreach ($apps as $app) {
         if ($app['id'] == $id) {
            return $app;
         }
      }
      return null;
   }

   private function getDeveloper(int $developerId): ?array
   {
      $developers = DataFileLoader::load('developer.json');
      foreach ($developers as $dev) {
         if ($dev['id'] == $developerId) {
            return $dev;
         }
      }
      return null;
   }
}
