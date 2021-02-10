<?php

declare(strict_types=1);

namespace App\Mailer;

class Mailer
{
    public function send(Email $email): void
    {
        var_dump("------------", "DEBUT D'ENVOI D'EMAIL FICTIF : ", $email, "FIN D'ENVOI D'EMAIL FICTIF");
    }
}
