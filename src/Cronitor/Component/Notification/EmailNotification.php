<?php declare(strict_types = 1);

namespace Cronitor\Component\Notification;

class EmailNotification extends AbstractNotification
{
    const TYPE = "emails";

    public function validate ($data): bool
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL) === false)
            throw new \LogicException("The provided email {$data} is not a valid email format.");

        return true;
    }
}
