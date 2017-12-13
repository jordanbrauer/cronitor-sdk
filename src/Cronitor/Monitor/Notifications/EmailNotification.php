<?php declare(strict_types = 1);

namespace Cronitor\Monitor\Notifications;

use LogicException;

class EmailNotification implements NotificationInterface
{
    const TYPE = "emails";

    /**
     * @var string $email The notification email to be used.
     */
    protected $email;

    /**
     * Public constructor function
     *
     * @param string $email The notification email to be used.
     */
    public function __construct (string $email)
    {
        $this->validate($email);
        $this->email = $email;
    }

    /**
     * Returns the email to be notified.
     *
     * @return string
     */
    public function getEmail ()
    {
        return $this->email;
    }

    public function validate ($entry): bool
    {
        if (filter_var($entry, FILTER_VALIDATE_EMAIL) === false)
            throw new LogicException("The provided email {$entry} is not a valid email format.");

        return true;
    }
}
