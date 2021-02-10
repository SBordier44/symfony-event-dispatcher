<?php

declare(strict_types=1);

namespace App;

use App\Model\Order;

class Database
{
    public function insertOrder(Order $order): void
    {
        var_dump("------------", "DEBUT D'INSERTION FICTIVE EN BDD : ", $order, "FIN D'INSERTION FICTIVE");
    }
}
