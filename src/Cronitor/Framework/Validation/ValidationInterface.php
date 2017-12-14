<?php declare(strict_types = 1);

namespace Cronitor\Framework\Validation;

interface ValidationInterface
{
    /**
     * Return boolean on the given entry.
     *
     * @throws LogicException If a value is not valid.
     *
     * @param mixed $data The value being validated.
     * @return bool
     */
    public function validate ($data): bool;
}
