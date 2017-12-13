<?php declare(strict_types = 1);

namespace Cronitor\Monitor\Notifications;

use LogicException;

class WebhookNotification implements NotificationInterface
{
    const TYPE = "webhooks";

    /**
     * @var string $webhook The notification channel webhook to be used.
     */
    protected $webhook;

    /**
     * Public constructor function
     *
     * @param string $webhook The notification channel webhook to be used.
     */
    public function __construct (string $webhook)
    {
        $this->validate($webhook);
        $this->webhook = $webhook;
    }

    /**
     * Returns the Webhook webhook to be notified.
     *
     * @return string
     */
    public function getWebhook ()
    {
        return $this->webhook;
    }

    public function validate ($webhook): bool
    {
        $flags = FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED | FILTER_FLAG_PATH_REQUIRED;
        if (filter_var($webhook, FILTER_VALIDATE_URL, $flags) === false)
            throw new LogicException("The provided webhook {$webhook} is not a valid URL format.");

        $urlComponents = parse_url(strtolower($webhook));
        if ($urlComponents["path"] === "/")
            throw new LogicException("The provided webhook path is too short to be a valid webhook.");
        if ($urlComponents["scheme"] === "http")
            throw new LogicException("Please correct your webhook protocol from HTTP to HTTPS.");

        return true;
    }
}
