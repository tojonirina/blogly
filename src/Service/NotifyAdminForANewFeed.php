<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NotifyAdminForANewFeed
{
    private static $mailer;

    public function __construct(MailerInterface $mailer)
    {
        static::$mailer = $mailer;
    }

    public static function send($from = 'fake@gmail.com', $to = '', $feedInfo = '')
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject('New feed in your application')
            ->text('There is a new feed in your application')
            ->html('<p>' . $feedInfo . '</p>');

        static::$mailer->send($email);
    }
}
