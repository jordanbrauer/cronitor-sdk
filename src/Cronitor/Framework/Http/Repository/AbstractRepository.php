<?php declare (strict_types = 1);

namespace Cronitor\Framework\Http\Repository;

use Cronitor\Framework\Http\Client\AbstractClient;

abstract class AbstractRepository
{
    /**
     * @var AbstractClient $client
     */
    private $client;

    /**
     * Public constructor function.
     *
     * @param AbstractClient $client
     */
    public function __construct (AbstractClient $client)
    {
        $this->client = $client;
    }
}
