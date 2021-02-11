<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\OrderEvent;
use App\Logger;
use App\Mailer\Email;
use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderEmailSubscriber implements EventSubscriberInterface
{
    public function __construct(private Mailer $mailer, private Logger $logger)
    {
    }

    #[\JetBrains\PhpStorm\ArrayShape([
        OrderEvent::BEFORE_INSERT => 'string[]',
        OrderEvent::AFTER_INSERT => 'array[]'
    ])]
    public static function getSubscribedEvents(): array
    {
        return [
            OrderEvent::BEFORE_INSERT => ['sendToStock'],
            OrderEvent::AFTER_INSERT => [
                ['sendToCustomer', 5]
            ]
        ];
    }

    public function sendToStock(OrderEvent $event): void
    {
        $order = $event->getOrder();
        $email = new Email();
        $email->setSubject('Commande en cours')
            ->setBody(
                "Merci de vérifier le stock pour le produit {$order->getProduct()} 
                et la quantité {$order->getQuantity()} !"
            )
            ->setTo('stock@maboutique.com')
            ->setFrom('web@maboutique.com');

        $this->mailer->send($email);

        $this->logger->log("Commande en cours pour {$order->getQuantity()} {$order->getProduct()}");
    }

    public function sendToCustomer(OrderEvent $event): void
    {
        $order = $event->getOrder();

        $email = new Email();
        $email->setSubject('Commande confirmée')
            ->setBody("Merci pour votre commande de {$order->getQuantity()} {$order->getProduct()} !")
            ->setFrom('web@maboutique.com')
            ->setTo($order->getEmail());

        $this->mailer->send($email);

        $this->logger->log("Email de confirmation envoyé à {$order->getEmail()} !");
    }
}
