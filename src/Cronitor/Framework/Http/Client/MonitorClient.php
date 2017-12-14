<?php declare(strict_types = 1);

namespace Cronitor\Framework\Http\Client;

use Cronitor\Framework\Http\Client\AbstractClient;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @version 2.0.0
 * @since 0.0.1
 *
 * @author Jordan Brauer <jbrauer.inc@gmail.com>
 */
class MonitorClient extends AbstractClient
{
    const BASE_URL = "cronitor.link";

    protected function configureSettings (array $settings = [], OptionsResolver $resolver): array
    {
        if ($settings["secure"] === true)
            $resolver->setRequired("auth_key");
        $resolver->setDefined(["id"]);
        $settings = parent::configureSettings($settings, $resolver);
        return $resolver->resolve($settings);
    }
}
