<?php declare (strict_types = 1);

namespace Cronitor\Monitor;

use LogicException;

/**
 * Monitor tag object.
 *
 * @since 0.2.0
 * @version 1.0.0
 *
 * @author Jordan Brauer <jbrauer.inc@gmail.com>
 */
class MonitorTag
{
    const MAX_LENGTH = 50;

    /**
     * @var string $label
     */
    protected $label;

    /**
     * Public constructor function.
     *
     * @param string $label The string being applied to the monitor tag.
     */
    public function __construct (string $label)
    {
        $this->validate($label);
        $this->label = $label;
    }

    /**
     * Returns the tag string
     *
     * @return string
     */
    public function getLabel ()
    {
        return $this->label;
    }

    /**
     * Checks that a tag's label is less than or equal to 50 characters.
     *
     * @throws LogicException Thrown if a label is too long.
     *
     * @param string $label The label being validated.
     * @return bool
     */
    protected function validate (string $label): bool
    {
        $taglen = strlen($label);
        $maxlen = self::MAX_LENGTH;
        if ($taglen > $maxlen)
            throw new LogicException("Monitor tags cannot be longer than {$maxlen} characters. Yours was {$taglen}.");

        return true;
    }
}
