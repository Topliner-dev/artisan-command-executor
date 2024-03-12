<?php

use Topliner\ArtisanCommandExecutor\Http\Controllers\ArtisanExecuteCommandController;
use Illuminate\Support\Facades\Route;


Route::post('tools/execute-command', [ArtisanExecuteCommandController::class, 'executeCommand']);