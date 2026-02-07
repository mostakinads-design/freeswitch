<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ExtensionController;
use App\Http\Controllers\Api\DIDController;
use App\Http\Controllers\Api\IVRController;
use App\Http\Controllers\Api\QueueController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CDRController;
use App\Http\Controllers\Api\CallController;
use App\Http\Controllers\Api\ConferenceController;
use App\Http\Controllers\Api\GatewayController;
use App\Http\Controllers\Api\DialerController;

Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    
    // Extensions
    Route::apiResource('extensions', ExtensionController::class);
    Route::post('extensions/{extension}/sync', [ExtensionController::class, 'syncToFreeswitch']);
    
    // DIDs
    Route::apiResource('dids', DIDController::class);
    
    // IVR
    Route::apiResource('ivr', IVRController::class);
    Route::post('ivr/{ivr}/sync', [IVRController::class, 'syncToFreeswitch']);
    
    // Queues
    Route::apiResource('queues', QueueController::class);
    Route::post('queues/{queue}/members', [QueueController::class, 'addMember']);
    Route::delete('queues/{queue}/members/{user}', [QueueController::class, 'removeMember']);
    
    // Campaigns
    Route::apiResource('campaigns', CampaignController::class);
    Route::post('campaigns/{campaign}/contacts/import', [CampaignController::class, 'importContacts']);
    Route::post('campaigns/{campaign}/start', [CampaignController::class, 'start']);
    Route::post('campaigns/{campaign}/pause', [CampaignController::class, 'pause']);
    Route::post('campaigns/{campaign}/stop', [CampaignController::class, 'stop']);
    
    // CDR
    Route::get('cdr', [CDRController::class, 'index']);
    Route::get('cdr/{cdr}', [CDRController::class, 'show']);
    Route::get('cdr/{cdr}/recording', [CDRController::class, 'getRecording']);
    
    // Live Calls
    Route::get('calls/live', [CallController::class, 'live']);
    Route::post('calls/{uuid}/hangup', [CallController::class, 'hangup']);
    Route::post('calls/originate', [CallController::class, 'originate']);
    
    // Conferences
    Route::apiResource('conferences', ConferenceController::class);
    Route::get('conferences/{conference}/participants', [ConferenceController::class, 'participants']);
    
    // Gateways
    Route::apiResource('gateways', GatewayController::class);
    Route::post('gateways/{gateway}/sync', [GatewayController::class, 'syncToFreeswitch']);
    
    // Dialers
    Route::apiResource('dialers', DialerController::class);
    Route::post('dialers/{dialer}/start', [DialerController::class, 'start']);
    Route::post('dialers/{dialer}/stop', [DialerController::class, 'stop']);
});
