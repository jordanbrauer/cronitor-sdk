<?php declare(strict_types = 1);

namespace Cronitor;

use Symfony\Component\OptionsResolver\OptionsResolver;

trait SettingsResolver
{
    protected $settings;

    protected function getDefaultSettings (): array
    {
        throw new LogicException("Please define the default settings for ".get_called_class()." by overriding the ".__FUNCTION__." method");
    }

    protected function configureSettings (array $settings = []): array
    {
        $resolver = new OptionsResolver;
        $resolver->setDefaults($this->getDefaultSettings());
        return $resolver->resolve($settings);
    }
}
