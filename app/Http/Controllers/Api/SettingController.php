<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected SettingService $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function getInformation(Request $request)
    {
        $data = $this->service->getInformation($request);

        if (empty($data)) {
            return response()->json([
                'status' => 404,
                'message' => 'Settings not found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Data fetched successfully',
            'data' => $data,
        ]);
    }

    public function getSetting()
    {
        $color = $this->service->getColor();

        return response()->json([
            'status' => 200,
            'message' => 'Color fetched successfully',
            'data' => [
                'color' => $color,
            ],
        ]);
    }
}
