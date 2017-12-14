<?php declare (strict_types = 1);

namespace Cronitor\Tests\Monitor\Notifications;

use Cronitor\Component\Notification\AbstractNotification;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Cronitor\Monitor\Notifications\EmailNotification
 */
final class AbstractNotificationSpec extends TestCase
{
    protected function setUp ()
    {
        $this->notificationData = "sample@test.data";
        $this->notification = new class ($this->notificationData) extends AbstractNotification {
            const TYPE = "test";
            public function validate ($data): bool
            {
                return true;
            }
        };
    }

    protected function tearDown ()
    {
        unset($this->notification);
    }

    /**
     * @test
     */
    public function assertNotificationExists ()
    {
        $this->assertInternalType("object", $this->notification);
        $this->assertInstanceOf(AbstractNotification::class, $this->notification);
    }

    /**
     * @test
     */
    public function assertProperMagicMethodCallsWorkAsExpected ()
    {
        $expected = $this->notificationData;
        $received = $this->notification->getTest();
        $this->assertEquals($expected, $received);
    }

    /**
     * @test
     */
    public function assertBadMagicMethodCallsThrowExceptions ()
    {
        $this->expectException("BadMethodCallException");
        $this->notification->getTests();
    }
}
