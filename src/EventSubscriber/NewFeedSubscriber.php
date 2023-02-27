<?php

namespace App\EventSubscriber;

use App\Event\NewFeedEvent;
use App\Service\NotifyAdminForANewFeed;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewFeedSubscriber implements EventSubscriberInterface
{
    public function onNewFeed(NewFeedEvent $event): void
    {
        NotifyAdminForANewFeed::send('from@gmail.com', 'tojo.fr007@gmail.com', $event->getMessage());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'NewFeed' => 'onNewFeed',
        ];
    }
}
