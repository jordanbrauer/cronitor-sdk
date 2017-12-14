<?php declare (strict_types = 1);

namespace Cronitor\Tests;

use Cronitor\MonitorCaller;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

final class MonitorCallerSpec extends TestCase
{
    use VarDumperTestTrait;

    protected function setUp ()
    {
        # Set up a caller using regular HTTP
        $this->httpCaller = new MonitorCaller([
            "id" => "f00b4r",
            "secure" => false,
        ]);

        # Set up a caller using secure HTTPS
        $this->httpsCaller = new MonitorCaller([
            "id" => "b4zqux",
            "auth_key" => "your_super_secret_auth_key",
        ]);
    }

    protected function tearDown ()
    {
        foreach([
            $this->httpCaller,
            $this->httpsCaller,
        ] as $caller) unset($caller);
    }

    /**
     * @test
     */
    public function assertMonitorCallerExists ()
    {
        foreach ([$this->httpCaller, $this->httpsCaller] as $caller) {
            $this->assertInternalType("object", $caller);
            $this->assertInstanceOf(MonitorCaller::class, $caller);
        }
    }

    public function assert ()
    {
    }
}
