<?php

namespace App\Listeners;

use App\Events\AccountCreated;

final class SendWelcomeEmailNotification
{
    public function __construct()
    {
        //
    }

    public function handle(AccountCreated $event): void
    {
        $event->user->notify(
            new \App\Notifications\AccountCreated($event->user)
        );
    }
}
