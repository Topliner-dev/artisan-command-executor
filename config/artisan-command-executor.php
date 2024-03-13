<?php

declare(strict_types=1);

return [
    "command_filter" => env('ARTISAN_COMMAND_EXECUTOR_COMMAND_FILTER', 'db,env,event,ide-helper,horizon,jwt,key,l5-swagger,lang,make,migrate,model,notifications,queue,storage,stub,vendor')
];