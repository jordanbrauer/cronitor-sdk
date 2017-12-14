<?php declare (strict_types = 1);

namespace Cronitor\Component\Rule;

/**
 * Monitor rule object.
 *
 * @since 0.2.0
 * @version 1.0.0
 *
 * @author Jordan Brauer <jbrauer.inc@gmail.com>
 */
class MonitorRule
{
    const NOT_ON_SCHEDULE = "not_on_schedule";

    const RAN_LESS_THAN = "ran_less_than";

    const RAN_LONGER_THAN = "ran_longer_than";

    const RUN_PING_RECEIVED = "run_ping_received";

    const RUN_PING_NOT_RECEIVED = "run_ping_not_received";

    const COMPLETE_PING_RECIEVED = "complete_ping_received";

    const COMPLETE_PING_NOT_RECEIVED = "complete_ping_not_received";

    const SECONDS = "seconds";

    const MINUTES = "minutes";

    const HOURS = "hours";

    const DAYS = "dats";

    const WEEKS = "weeks";

    private static $ruleTypes = [
        self::NOT_ON_SCHEDULE,
        self::RAN_LESS_THAN,
        self::RAN_LONGER_THAN,
        self::RUN_PING_RECEIVED,
        self::RUN_PING_NOT_RECEIVED,
        self::COMPLETE_PING_RECIEVED,
        self::COMPLETE_PING_NOT_RECEIVED,
    ];

    private static $timeUnits = [
        self::SECONDS,
        self::MINUTES,
        self::HOURS,
        self::DAYS,
        self::WEEKS,
    ];

    /**
     * @var string $ruleType See MonitorRule class constants
     */
    protected $ruleType;

    /**
     * @var mixed $value
     * For not_on_schedule rules, this should be a cron expression like `10 * * * 1-5`.
     * For run_ping_received and complete_ping_received, no value or time_unit is accepted.
     * For all other rule types, this should be a number that is combined with with time_unit to specify a time interval.
     */
    protected $value;

    /**
     * @var string $timeUnit Not required for not_on_schedule rules. Options are: seconds, minutes, hours, days, weeks
     */
    protected $timeUnit;

    /**
     * @var int $hoursToFollowupAlert how long to wait between sending you follow up alerts. The minimum value that you may set this to is 1 hour.
     * By default Cronitor will wait 4 hours before sending a second round of alerts.
     */
    protected $hoursToFollowupAlert;

    /**
     * @var int $graceSeconds Specify a grace period for evaluation of this rule.
     * For not_on_schedule rules, this is used when evaluating start time and total runtime duration.
     */
    protected $graceSeconds;

    public function __construct (array $settings = [])
    {
        $this->ruleType = $settings["rule_type"] ?? null;
        $this->timeUnit = $settings["time_unit"] ?? null;
        $this->value = $settings["value"] ?? null;
        $this->hoursToFollowupAlert = $settings["hours_to_followup_alert"] ?? null;
        $this->graceSeconds = $settings["grace_seconds"] ?? null;
    }

    /**
     * Sets the monitor rule type
     *
     * @throws OutOfBoundsException Thrown when an invalid rule type is attempted to be set.
     *
     * @param string $ruleType One of the valid monitor rule types. See the class constants for options.
     * @return $this
     */
    public function setRuleType (string $ruleType): MonitorRule
    {
        if (in_array($ruleType, self::$ruleTypes) === false)
            throw new \OutOfBoundsException("Unknown monitor rule type {$ruleType}. Use one of ".implode(", ", self::$ruleTypes));
        $this->ruleType = $ruleType;
        return $this;
    }

    /**
     * Returns the rule type
     *
     * @return string
     */
    public function getRuleType (): string
    {
        return $this->ruleType;
    }

    /**
     * Sets the monitor rule time unit.
     *
     * @throws OutOfBoundsException Thrown when an invalid time unit is attempted to be set.
     *
     * @param string $timeUnit A valid time unit option.
     * @return $this
     */
    public function setTimeUnit (string $timeUnit): MonitorRule
    {
        if (in_array($timeUnit, self::$timeUnits) === false)
            throw new \OutOfBoundsException("Unknown monitor time unit {$timeUnit}. Use one of ".implode(", ", self::$timeUnits));
        $this->timeUnit = $timeUnit;
        return $this;
    }

    /**
     * Returns the rule time unit
     *
     * @return string
     */
    public function getTimeUnit (): string
    {
        return $this->timeUnit;
    }

    /**
     * Sets the hours to follow up between alerts.
     *
     * @param int $hoursToFollowupAlert An amount in hours.
     * @return $this
     */
    public function setHoursToFollowupAlert (int $hoursToFollowupAlert): MonitorRule
    {
        $this->hoursToFollowupAlert = $hoursToFollowupAlert;
        return $this;
    }

    /**
     * Returns the hours to follow up between alerts.
     *
     * @return int
     */
    public function getHoursToFollowupAlert (): int
    {
        return $this->hoursToFollowupAlert;
    }

    /**
     * Sets the rule value
     *
     * @param int $value
     * @return $this
     */
    public function setValue (int $value): MonitorRule
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Returns the rule value.
     *
     * @return int
     */
    public function getValue (): int
    {
        return $this->value;
    }

    /**
     * Sets the rule grace second period
     *
     * @param int $graceSeconds
     * @return $this
     */
    public function setGraceSeconds (int $graceSeconds): MonitorRule
    {
        $this->graceSeconds = $graceSeconds;
        return $this;
    }

    /**
     * Returns the rule grace second period.
     *
     * @return int
     */
    public function getGraceSeconds (): int
    {
        return $this->graceSeconds;
    }
}
