<?php

declare(strict_types=1);

namespace Topliner\ArtisanCommandExecutor\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Topliner\ArtisanCommandExecutor\Http\Requests\ArtisanExecuteCommandRequest;
use Topliner\ArtisanCommandExecutor\Services\ArtisanExecuteCommandService;

class ArtisanExecuteCommandController extends Controller
{
    private ArtisanExecuteCommandService $artisanExecuteCommandService;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->artisanExecuteCommandService = app()->make(ArtisanExecuteCommandService::class);
    }

    /**
     * @throws Exception
     */
    public function executeCommand(ArtisanExecuteCommandRequest $request): array
    {
        # увеличить лимит работы скрипта

        $validated = $request->validated();

        return $this->artisanExecuteCommandService->executeCommand($validated);
    }
}