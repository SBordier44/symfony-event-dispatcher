<?php

declare(strict_types=1);

namespace App\Event;

use App\Model\Order;
use Symfony\Contracts\EventDispatcher\Event;

class OrderEvent extends Event
{
    public const AFTER_INSERT = 'order.after_insert';
    public const BEFORE_INSERT = 'order.before_insert';

    public function __construct(protected Order $order)
    {
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
