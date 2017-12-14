<?php declare (strict_types = 1);

namespace Cronitor\Tests\Monitor\Notifications;

use Cronitor\Component\Notification\WebhookNotification;
use Cronitor\Component\Notification\AbstractNotification;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Cronitor\Monitor\Notifications\WebhookNotification
 */
final class WebhookNotificationSpec extends TestCase
{
    /**
     * @test
     */
    public function assertWebhookNotificationExists ()
    {
        $webhookNotification = new WebhookNotification("https://example.com/that/path/HOOK.php");
        $this->assertInternalType("object", $webhookNotification);
        $this->assertInstanceOf(AbstractNotification::class, $webhookNotification);
    }

    /**
     * @test
     * @covers ::validate
     */
    public function assertNotificationThrowsExceptionForInvalidEntries ()
    {
        $this->expectException("LogicException");
        $webhookNotification = new WebhookNotification("1 asdf. @ a.c");
    }

    /**
     * @test
     * @covers ::getWebhook
     */
    public function assertWebhookValueIsAccessible ()
    {
        $expected = "https://slack.com/team/webhook";
        $webhookNotification = new WebhookNotification($expected);
        $actual = $webhookNotification->getWebhook();
        $this->assertEquals($expected, $actual);
        $this->assertInternalType("string", $actual);
    }
}
