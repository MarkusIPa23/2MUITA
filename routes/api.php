<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\WebhookController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cases', [CaseController::class, 'index']);
    Route::post('/cases', [CaseController::class, 'store']);
    Route::get('/cases/{id}', [CaseController::class, 'show']);
    Route::patch('/cases/{id}', [CaseController::class, 'update']);

    Route::post('/documents', [DocumentController::class, 'upload']);
    Route::get('/documents/{document}', [DocumentController::class, 'download']);
});

Route::post('/webhooks/muita', [WebhookController::class, 'receive']);
