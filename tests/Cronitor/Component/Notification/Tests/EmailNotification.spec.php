<?php declare (strict_types = 1);

namespace Cronitor\Tests\Monitor\Notifications;

use Cronitor\Component\Notification\EmailNotification;
use Cronitor\Component\Notification\AbstractNotification;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Cronitor\Monitor\Notifications\EmailNotification
 */
final class EmailNotificationSpec extends TestCase
{
    /**
     * @test
     */
    public function assertEmailNotificationExists ()
    {
        $emailNotification = new EmailNotification("example@email.tld");
        $this->assertInternalType("object", $emailNotification);
        $this->assertInstanceOf(AbstractNotification::class, $emailNotification);
    }

    /**
     * @test
     * @covers ::validate
     */
    public function assertNotificationThrowsExceptionForInvalidEntries ()
    {
        $this->expectException("LogicException");
        $emailNotification = new EmailNotification("asdf. @ a.c");
    }

    /**
     * @test
     * @covers ::getEmail
     */
    public function assertEmailValueIsAccessible ()
    {
        $expected = "test@email.tld";
        $emailNotification = new EmailNotification($expected);
        $actual = $emailNotification->getEmail();
        $this->assertEquals($expected, $actual);
        $this->assertInternalType("string", $actual);
    }
}
