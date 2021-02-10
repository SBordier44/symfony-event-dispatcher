<?php

declare(strict_types=1);

namespace App\Texter;

class SmsTexter
{
    public function send(Sms $sms): void
    {
        var_dump("-------------", "DEBUT DE SMS TEXTER FICTIF : ", $sms, "FIN DE SMS TEXTER FICTIF");
    }
}
