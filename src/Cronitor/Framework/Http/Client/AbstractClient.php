<?php declare(strict_types = 1);

namespace Cronitor\Framework\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @version 2.0.0
 * @since 0.0.1
 *
 * @author Jordan Brauer <jbrauer.inc@gmail.com>
 */
abstract class AbstractClient
{
    const BASE_URL = null;

    /** @var ClientInterface $client */
    private $client;

    /**
     * Public constructor function.
     *
     * @param array $settings
     */
    public function __construct (array $settings = [])
    {
        $settings = $this->configureSettings($settings, new OptionsResolver);
        $this->client = new Client([
            "base_uri" => $settings["base_uri"],
            "headers" => $settings["headers"],
            "handler" => $settings["handler"],
        ]);
    }

    protected function configureSettings (array $settings = [], OptionsResolver $resolver): array
    {
        $resolver->setDefaults([
            "secure" => true,
            "base_uri" => static::BASE_URL,
            "headers" => [
                "Content-Type" => "application/json",
            ],
            "handler" => HandlerStack::create(),
        ]);
        return $resolver->resolve($settings);
    }
}
