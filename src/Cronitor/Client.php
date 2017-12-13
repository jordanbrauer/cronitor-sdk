<?php declare(strict_types = 1);

namespace Cronitor;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;

/**
 * @version 2.0.0
 * @since 0.0.1
 *
 * @author Jordan Brauer <jbrauer.inc@gmail.com>
 */
class Client
{
    const API_URL = "https://cronitor.io/";

    const PING_URL = "https://cronitor.link/";

    private $client;
    private $apiKey;
    private $authKey;
    private $url;
    private $secure;

    public function __construct (array $settings = [])
    {
        $this->client = new GuzzleClient([
            "base_uri" => $settings["base_uri"],
            "headers" => $settings["headers"] ?? ["Content-Type" => "application/json"],
            "handler" => $settings["handler"] ?? HandlerStack::create(),
        ]);
    }
}
