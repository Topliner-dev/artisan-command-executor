<?php

use Topliner\ArtisanCommandExecutor\Http\Controllers\ArtisanExecuteCommandController;
use Illuminate\Support\Facades\Route;

Route::post('api/tools/execute-command', [ArtisanExecuteCommandController::class, 'executeCommand']);