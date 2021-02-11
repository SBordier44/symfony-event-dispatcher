<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\OrderEvent;
use App\Logger;
use App\Texter\Sms;
use App\Texter\SmsTexter;

class OrderSmsListener
{
    public function __construct(private SmsTexter $texter, private Logger $logger)
    {
    }

    public function sendSmsToCustomer(OrderEvent $event): void
    {
        $order = $event->getOrder();

        $sms = new Sms();
        $sms->setNumber($order->getPhoneNumber())
            ->setText("Merci pour votre commande de {$order->getQuantity()} {$order->getProduct()} !");

        $this->texter->send($sms);

        $this->logger->log("SMS de confirmation envoyé à {$order->getPhoneNumber()} !");
    }
}
