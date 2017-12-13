<?php declare(strict_types = 1);

namespace Cronitor\Monitor\Notifications;

interface NotificationInterface
{
    /**
     * Return boolean on a notification entry.
     *
     * @throws LogicException If a value is not valid.
     *
     * @param mixed $entry The value being validated.
     * @return bool
     */
    public function validate ($entry): bool;
}
