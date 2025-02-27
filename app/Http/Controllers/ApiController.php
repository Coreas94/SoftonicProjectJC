<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use App\Utils\DataFileLoader;
use App\Http\Responses\ApiResponse;
use App\Utils\AppFormatterResponse;

class ApiController extends Controller
{
   public function getAppById(string $id): JsonResponse
    {
        $app = $this->findApp($id);

        if (!$app) {
            return ApiResponse::error('App not found', 404);
        }

        $developer = $this->getDeveloper($app['developer_id']);

        return ApiResponse::success(AppFormatterResponse::format($app, $developer));
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
