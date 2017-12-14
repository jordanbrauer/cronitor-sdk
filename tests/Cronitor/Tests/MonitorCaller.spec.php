<?php declare (strict_types = 1);

namespace Cronitor\Tests;

use Cronitor\MonitorCaller;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

final class MonitorCallerSpec extends TestCase
{
    use VarDumperTestTrait;

    /**
     * @test
     */
    public function assertMonitorCallerExists ()
    {
        # Set up a caller using regular HTTP
        $caller = new MonitorCaller([
            "id" => "t17i35",
            "auth_key" => "super_secret_authorization_key",
        ]);
        $this->assertInternalType("object", $caller);
        $this->assertInstanceOf(MonitorCaller::class, $caller);
    }

    /**
     * @test
     */
    public function assertUnsecureMonitorThrowsExceptionWithAuthKeyPresent ()
    {
        $this->expectException("InvalidArgumentException");
        $caller = new MonitorCaller([
            "id" => "f00b4r",
            "secure" => false,
            "auth_key" => "unsecure_monitor_key_causes_exception",
        ]);
    }

    /**
     * @test
     */
    public function assertSecureMonitorThrowsExceptionWithoutAuthKeyPresent ()
    {
        $this->expectException("InvalidArgumentException");
        $secureCaller = new MonitorCaller([
            "id" => "84zqux",
            "secure" => true
            # @NOTE MISSING auth_key to test for error!
        ]);
    }
}
