<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Event\OrderEvent;
use App\Model\Order;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class OrderController
{

    protected Database $database;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        Database $database,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->database = $database;
        $this->dispatcher = $eventDispatcher;
    }

    public function displayOrderForm(): void
    {
        require __DIR__ . '/../../views/form.html.php';
    }

    public function handleOrder(): void
    {
        $order = new Order();
        $order->setProduct($_POST['product'])
            ->setQuantity($_POST['quantity'])
            ->setEmail($_POST['email'])
            ->setPhoneNumber($_POST['phone']);

        $this->dispatcher->dispatch(new OrderEvent($order), OrderEvent::BEFORE_INSERT);

        $this->database->insertOrder($order);

        $this->dispatcher->dispatch(new OrderEvent($order), OrderEvent::AFTER_INSERT);
    }
}
