<?php declare(strict_types = 1);

namespace Cronitor\Monitor\Notifications;

use LogicException;

class SlackNotification extends WebhookNotification
{
    const TYPE = "slack";

    /**
     * Wrapper method for parent ::getWebhook
     */
    public function getSlack ()
    {
        return parent::getWebhook();
    }

    public function validate ($webhook): bool
    {
        parent::validate($webhook);

        $urlComponents = parse_url(strtolower($webhook));
        if ($urlComponents["host"] !== "slack.com")
            throw new LogicException("The provided Slack webhook domain is invalid. Expected slack.com, was {$urlComponents['host']}");

        return true;
    }
}
