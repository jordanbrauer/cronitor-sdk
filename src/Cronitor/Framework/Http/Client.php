<?php declare(strict_types = 1);

namespace Cronitor\Framework\Http;

use Cronitor\Framework\Settings\SettingsResolver;
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
    use SettingsResolver;

    const API_URL = "https://cronitor.io/";

    const PING_URL = "https://cronitor.link/";

    /**
     * @var ClientInterface $client
     */
    private $client;

    /**
     * @var string $apiKey
     */
    private $apiKey;

    /**
     * @var string $authKey
     */
    private $authKey;

    public function __construct (array $settings = [])
    {
        $this->settings = $this->configureSettings($settings);
        $this->client = new GuzzleClient([
            "base_uri" => $this->settings["base_uri"],
            "headers" => $this->settings["headers"],
            "handler" => $this->settings["handler"],
        ]);
    }

    protected function getDefaultSettings (): array
    {
        return [
            "base_uri" => self::API_URL,
            "headers" => [
                "Content-Type" => "application/json",
            ],
            "handler" => HandlerStack::create(),
        ];
    }
}
