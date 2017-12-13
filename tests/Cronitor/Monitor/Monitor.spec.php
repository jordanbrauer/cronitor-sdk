<?php declare (strict_types = 1);

namespace Cronitor\Tests\Monitor;

use Cronitor\Monitor\AbstractMonitor;
use Cronitor\Monitor\Notifications\MonitorNotifications;
use Cronitor\Monitor\MonitorRule;
use Cronitor\Monitor\MonitorTag;
use Cronitor\Tests\MockMonitorComponents;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Cronitor\Monitor\AbstractMonitor
 */
final class MonitorSpec extends TestCase
{
    use MockMonitorComponents;

    protected function setUp ()
    {
        $this->mockNotifications = $this->getMockMonitorNotifications();
        $this->mockRule = $this->getMockMonitorRule();
        $this->mockTag = $this->getMockMonitorTag("test");

        $this->monitor = new class ([
            "name" => "test",
            "notifications" => $this->mockNotifications,
            "rules" => [ $this->mockRule ],
        ]) extends AbstractMonitor {
            const TYPE = "foobar";
        };
    }

    protected function tearDown ()
    {
        unset($this->mockNotifications);
        unset($this->mockRule);
        unset($this->mockTag);
        unset($this->monitor);
    }

    /**
     * @test
     */
    public function assertMonitorExists ()
    {
        $this->assertInternalType("object", $this->monitor);
        $this->assertInstanceOf(AbstractMonitor::class, $this->monitor);
    }

    /**
     * @test
     * @covers ::getName
     */
    public function assertMonitorHasName ()
    {
        $actual = $this->monitor->getName();
        $this->assertNotNull($actual);
        $this->assertInternalType("string", $actual);
    }

    /**
     * @test
     * @covers ::getType
     */
    public function assertMonitorHasType ()
    {
        $actual = $this->monitor->getType();
        $this->assertNotNull($actual);
        $this->assertInternalType("string", $actual);
    }

    /**
     * @test
     * @covers ::getNotifications
     */
    public function assertMonitorHasNotifications ()
    {
        $actual = $this->monitor->getNotifications();
        $this->assertNotNull($actual);
        $this->assertInternalType("object", $actual);
        $this->assertInstanceOf(MonitorNotifications::class, $actual);
    }

    /**
     * @test
     * @covers ::getRules
     */
    public function assertMonitorHasRules ()
    {
        $actual = $this->monitor->getRules();
        $this->assertNotNull($actual);
        $this->assertInternalType("array", $actual);
    }

    /**
     * @test
     * @uses ::getRules
     */
    public function assertMonitorHasValidRules ()
    {
        $actual = $this->monitor->getRules();
        foreach ($actual as $rule) {
            $this->assertInternalType("object", $rule);
            $this->assertInstanceOf(MonitorRule::class, $rule);
        }
    }

    /**
     * @test
     * @covers ::setTags
     * @covers ::getTags
     */
    public function assertMonitorCanHaveTags ()
    {
        $actual = $this->monitor->getTags();
        $this->assertNotNull($actual);
        $this->assertEmpty($actual);
        $this->assertInternalType("array", $actual);

        $this->monitor->setTags([$this->mockTag]);
        $actual = $this->monitor->getTags();
        $this->assertNotEmpty($actual);
        foreach ($actual as $tag) {
            $this->assertInternalType("object", $tag);
            $this->assertInstanceOf(MonitorTag::class, $tag);
        }
    }

    /**
     * @test
     * @covers ::setNote
     * @covers ::getNote
     */
    public function assertMonitorCanHaveANote ()
    {
        $actual = $this->monitor->getNote();
        $this->assertNotNull($actual);
        $this->assertEmpty($actual);
        $this->assertInternalType("string", $actual);

        $this->monitor->setNote("testing that note setting");
        $actual = $this->monitor->getNote();
        $this->assertNotEmpty($actual);
        $this->assertInternalType("string", $actual);
    }
}
