<?php declare(strict_types = 1);

namespace Cronitor\Serializer\Normalizer;

use Cronitor\Monitor\MonitorTag;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer as SymfonyObjectNormalizer;

class ObjectNormalizer extends SymfonyObjectNormalizer
{
    public function normalize($object, $format = null, array $context = array())
    {
        if ($object instanceof MonitorTag)
            return $object->getLabel();

        // return parent::normalize($object, $format, $context);
        $data = parent::normalize($object, $format, $context);

        return array_filter($data, function ($value) {
            return null !== $value;
        });
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if ($class === MonitorTag::class)
            return new $class($data);
        return parent::denormalize($data, $class, $format, $context);
    }
}
