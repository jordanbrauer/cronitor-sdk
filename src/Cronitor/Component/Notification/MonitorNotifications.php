<?php declare (strict_types = 1);

namespace Cronitor\Component\Notification;

class MonitorNotifications
{
    protected $templates;
    protected $emails;
    protected $slack;
    protected $webhooks;

    public function __construct ()
    {
        $this->templates = [];
        $this->emails = [];
        $this->slack = [];
        $this->webhooks = [];
    }

    /**
     * Adds a notification of the specified type to the monitor.
     *
     * @param string $type
     * @param string $value
     * @return void
     */
    public function addNotification (string $type, string $value)
    {
        $notificationClass = __NAMESPACE__."\\".ucfirst(rtrim($type, "s"))."Notification";
        $notification = new $notificationClass($value);
        $notificationMethod = "get".ucfirst(rtrim($notification::TYPE, "s"));
        $this->{$notification::TYPE}[] = $notification->{$notificationMethod}();
    }

    /**
     * Lists the monitor notifications. Optionally, list a specific set of
     * notifications if the `$type` paramter is passed.
     *
     * @param string $type
     * @return array
     */
    public function listNotifications (string $type = null): array
    {
        $notifTypes = get_object_vars($this);
        unset($notifTypes["templates"]);

        if ($type) {
            $notifTypes = array_keys($notifTypes);
            if (in_array($type, $notifTypes) === false)
                throw new \OutOfBoundsException("Trying to list notifications for unknown notification type {$type}. Use one of ".implode(", ", $notifTypes));
            return $this->{$type};
        }

        return $notifTypes;
    }

    /**
     * Sets the monitor notification template list.
     *
     * @param array $templates A list of email notification templates.
     * @return $this
     */
    public function setTemplates (array $templates = []): MonitorNotifications
    {
        $this->templates = $templates;
        return $this;
    }

    /**
     * Returns the monitor notification template list.
     *
     * @return array
     */
    public function getTemplates (): array
    {
        return $this->templates;
    }

    /**
     * Sets the monitor notification email list.
     *
     * @param array $emails A list of email notifications.
     * @return $this
     */
    public function setEmails (array $emails = []): MonitorNotifications
    {
        $this->emails = $emails;
        return $this;
    }

    /**
     * Returns the monitor notification email list.
     *
     * @return array
     */
    public function getEmails (): array
    {
        return $this->emails;
    }

    /**
     * Sets the monitor notification slack channel list.
     *
     * @param array $slack A list of slack webhook notifications.
     * @return $this
     */
    public function setSlack (array $slack = []): MonitorNotifications
    {
        $this->slack = $slack;
        return $this;
    }

    /**
     * Returns the monitor notification slack channel list.
     *
     * @return array
     */
    public function getSlack (): array
    {
        return $this->slack;
    }

    /**
     * Sets the monitor notification webhook list.
     *
     * @param array $webhooks A list of webhook notifications.
     * @return $this
     */
    public function setWebhooks (array $webhooks = []): MonitorNotifications
    {
        $this->webhooks = $webhooks;
        return $this;
    }

    /**
     * Returns the monitor notification webhook list.
     *
     * @return array
     */
    public function getWebhooks (): array
    {
        return $this->webhooks;
    }
}
