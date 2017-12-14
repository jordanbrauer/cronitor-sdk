<?php declare (strict_types = 1);

namespace Cronitor\Component\Monitor;

use Cronitor\Component\Notification\MonitorNotifications;
use Cronitor\Component\Tag\MonitorTag;
use Cronitor\Component\Rule\MonitorRule;

abstract class AbstractMonitor
{
    /**
     * @const string TYPE Sets the monitor's type when overriden by the extending class.
     *
     * @NOTE Options:
     * - `heartbeat` (to make outgoing heartbeat pings to Cronitor)
     * - `healthcheck` (to receiving incoming healthcheck pings from Cronitor)
     */
    const TYPE = null;

    /**
     * @var string $name The name of your monitor.
     */
    protected $name;

    /**
     * @var string $type The type of monitor.
     */
    protected $type;

    /**
     * @var MonitorNotifications $notifications An instance of MonitorNotifications that
     * determines where/how you wish to be contacted when a monitor's alerting is triggered.
     */
    protected $notifications;

    /**
     * @var MontiorRule[] $rules An array specifying the rules that will trigger alerts to be sent.
     */
    protected $rules;

    /**
     * @var MonitorTag[] $tags An optional array containing tags to help identify the monitor.
     */
    protected $tags;

    /**
     * @var string $note A note that you would like to have included in alerts. Useful if
     * you'd like to include context/tips for receiving alerts.
     */
    protected $note;

    public function __construct (array $settings = [])
    {
        if (static::TYPE === null)
            throw new \LogicException("A monitor must have a type. Please override the TYPE constant in ".get_called_class());
        $this->type = static::TYPE;

        # Required settings
        $this->name = $settings["name"] ?? null;
        $this->notifications = $settings["notifications"] ?? null;
        $this->rules = $settings["rules"] ?? null;

        # Optional settings
        $this->tags = $settings["tags"] ?? [];
        $this->note = $settings["note"] ?? "";
    }

    /**
     * Sets the monitor name.
     *
     * @NOTE All of your monitors must have a unique name.
     *
     * @param string $name The name of your monitor.
     * @return $this
     */
    public function setName (string $name): AbstractMonitor
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the name of your monitor.
     *
     * @return string
     */
    public function getName (): string
    {
        return $this->name;
    }

    /**
     * Returns the type of monitor that your monitor is.
     *
     * @return string
     */
    public function getType (): string
    {
        return $this->type;
    }

    /**
     * Sets the monitors notification methods.
     *
     * @NOTE When extending notification template(s), passing an empty array will overload
     * the templated notification settings for that key.
     *
     * @param MonitorNotifications $notifications
     * @return $this
     */
    public function setNotifications (MonitorNotifications $notifications): AbstractMonitor
    {
        $this->notifications = $notifications;
        return $this;
    }

    /**
     * Returns an object containining the settings for where/how
     * you wish to be contacted when a monitor's alerting is triggered.
     *
     * @return MonitorNotifications
     */
    public function getNotifications (): MonitorNotifications
    {
        return $this->notifications;
    }

    /**
     * Sets the monitors alert rules.
     *
     * @param MonitorRule[] $rules
     * @return $this
     */
    public function setRules (array $rules): AbstractMonitor
    {
        foreach ($rules as $rule) $this->addRule($rule);
        return $this;
    }

    /**
     * Add a single rule to the monitor
     *
     * @return void
     */
    public function addRule (MonitorRule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * Returns a list of the rules that will trigger alerts to be sent
     * via the methods defiend in Notifications.
     *
     * @return MonitorRule[]
     */
    public function getRules (): array
    {
        return $this->rules;
    }

    /**
     * Sets the monitors list of tags.
     *
     * @param MonitorTag[] $tags
     * @return $this
     */
    public function setTags (array $tags): AbstractMonitor
    {
        foreach ($tags as $tag) $this->addTag($tag);
        return $this;
    }

    /**
     * Add a single tag to the monitor
     *
     * @return void
     */
    public function addTag (MonitorTag $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * Returns a list of the monitor tags.
     *
     * @return
     */
    public function getTags (): array
    {
        return $this->tags;
    }

    /**
     * Sets the monitors note.
     *
     * @param string $note
     * @return $this
     */
    public function setNote (string $note): AbstractMonitor
    {
        $this->note = $note;
        return $this;
    }

    /**
     * Returns the monitors note.
     *
     * @return string
     */
    public function getNote (): string
    {
        return $this->note;
    }
}
