<?php

declare(strict_types=1);

namespace App;

class Logger
{
    public function log(string $loginfo): void
    {
        var_dump("LOGGING FICTIF : " . $loginfo);
    }
}
