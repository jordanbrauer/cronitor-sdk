<?php declare (strict_types = 1);

namespace Cronitor\Repository\Monitor;

class MonitorRepository
{
    const VERSION = "v3";

    private $client;

    /**
     * Public constructor method.
     *
     * @param Client $client
     */
    public function __construct (Client $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a new service monitor.
     *
     * @param array $data
     * @return ResponseInterface
     */
    public function createMonitor(array $data)
    {
        return $this->client->post("monitors", [
            "headers" => ["Authorization" => "Bearer {$this->client->getAuthKey()}"],
            "json" => $data
        ]);
    }
}
