<?php

declare(strict_types=1);

namespace Topliner\ArtisanCommandExecutor\Services;

use Exception;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;

class ArtisanExecuteCommandService
{
    const COMMAND_FILTER_DEFAULT = 'db,env,event,ide-helper,horizon,jwt,key,l5-swagger,lang,make,migrate,model,notifications,queue,storage,stub,vendor';

    /**
     * @throws Exception
     */
    public function executeCommand(array $validated): array
    {
        // убираем ограничение на время работы скрипта
        ini_set('max_execution_time', 0);

        $pattern = '/^(\S+)(.*)/';

        if (preg_match($pattern, $validated['input'], $matches)) {
            $command = $matches[1];

            if (!empty($matches[2])) {
                $argv = explode(' ', trim($matches[2]));
            } else {
                $argv = [];
            }
        } else {
            throw new InvalidArgumentException('command not recognized');
        }

        if (config('app.env') === 'production') {
            throw new InvalidArgumentException('environment not allowed');
        }

        $allowedCommands = $this->getAllowedCommandList();

        if (!in_array($command, $allowedCommands)) {
            throw new InvalidArgumentException('command not allowed');
        }

        $isSuccessful = Artisan::call($command, $argv) === 0;

        $output = Artisan::output();
        $output = str_replace("\n", '<br>', $output);

        $stage = config('app.url');
        $stage = str_replace('http://', '', $stage);
        $stage = str_replace('https://', '', $stage);

        return [
            'isSuccessful' => $isSuccessful,
            'stage' => $stage,
            'output' => $output
        ];
    }

    /**
     * @throws Exception
     */
    private function getAllowedCommandList(): array
    {
        $commandListIsSuccessful = Artisan::call('list');

        if ($commandListIsSuccessful !== 0) {
            throw new Exception('the "list" command is not executed');
        }

        $commandListOutput = Artisan::output();

        $commandList = explode("\n", $commandListOutput);

        foreach ($commandList as $key => &$value) {
            $value = trim($value);

            $pattern = '/^((\S+):\S+)/';
            if (preg_match($pattern, $value, $matches)) {
                if (in_array(
                    $matches[2],
                    explode(',', config('artisan-command-executor.command_filter', self::COMMAND_FILTER_DEFAULT))
                )) {
                    unset($commandList[$key]);
                }
                $value = $matches[0];
            } else {
                unset($commandList[$key]);
            }
        }

        return $commandList;
    }
}