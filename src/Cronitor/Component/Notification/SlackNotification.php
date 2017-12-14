<?php declare(strict_types = 1);

namespace Cronitor\Component\Notification;

class SlackNotification extends WebhookNotification
{
    const TYPE = "slack";

    public function validate ($data): bool
    {
        parent::validate($data);

        $urlComponents = parse_url(strtolower($data));
        if ($urlComponents["host"] !== "slack.com")
            throw new \LogicException("The provided Slack webhook domain is invalid. Expected slack.com, was {$urlComponents['host']}");

        return true;
    }
}
