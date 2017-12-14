<?php declare (strict_types = 1);

namespace Cronitor\Framework\Test;

trait CronitorFixtures
{
    protected function getFixtureDir ()
    {
        return realpath(__DIR__."/../../../fixtures");
    }

    public function getFixtureContents (string $fixture)
    {
        $file = "{$this->getFixtureDir()}/{$fixture}";
        if (file_exists($file) === false)
            throw new \LogicException("Trying to load a non-existent test fixture {$fixture} from {$this->getFixtureDir()}");

        return trim(file_get_contents($file));
    }
}
