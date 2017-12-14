<?php declare(strict_types = 1);

namespace Cronitor\Component\Notification;

class WebhookNotification extends AbstractNotification
{
    const TYPE = "webhooks";

    public function validate ($data): bool
    {
        $flags = FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED | FILTER_FLAG_PATH_REQUIRED;
        if (filter_var($data, FILTER_VALIDATE_URL, $flags) === false)
            throw new \LogicException("The provided webhook {$data} is not a valid URL format.");

        $urlComponents = parse_url(strtolower($data));
        if ($urlComponents["path"] === "/")
            throw new \LogicException("The provided webhook path is too short to be a valid webhook.");
        if ($urlComponents["scheme"] === "http")
            throw new \LogicException("Please correct your webhook protocol from HTTP to HTTPS.");

        return true;
    }
}
