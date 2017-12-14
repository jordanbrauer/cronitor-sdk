<?php declare(strict_types = 1);

namespace Cronitor\Framework\Settings;

use LogicException;
use Symfony\Component\OptionsResolver\OptionsResolver;

trait SettingsResolver
{
    private $settings;

    protected function getDefaultSettings (OptionsResolver $resolver): array
    {
        throw new LogicException("Please define the default settings for ".get_called_class()." by overriding the ".__FUNCTION__." method");
    }

    protected function getRequiredSettings (OptionsResolver $resolver): array
    {
        return [];
    }

    protected function configureSettings (array $userSettings = [], array $definedSettings = []): array
    {
        $resolver = new OptionsResolver;
        # define valid settings w/o defaults
        if (count($definedSettings) > 0)
            foreach ($definedSettings as $setting)
                $resolver->setDefined($setting);
        # define default & required settings
        $resolver->setDefaults($this->getDefaultSettings($resolver));
        $resolver->setRequired($this->getRequiredSettings($resolver));
        return $resolver->resolve($userSettings);
    }
}
