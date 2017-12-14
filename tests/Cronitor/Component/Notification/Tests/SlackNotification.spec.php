<?php declare (strict_types = 1);

namespace Cronitor\Tests\Monitor\Notifications;

use Cronitor\Component\Notification\SlackNotification;
use Cronitor\Component\Notification\AbstractNotification;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Cronitor\Monitor\Notifications\SlackNotification
 */
final class SlackNotificationSpec extends TestCase
{
    /**
     * @test
     */
    public function assertSlackNotificationExists ()
    {
        $slackNotification = new SlackNotification("https://slack.com/that/path/HOOK");
        $this->assertInternalType("object", $slackNotification);
        $this->assertInstanceOf(AbstractNotification::class, $slackNotification);
    }

    /**
     * @test
     * @covers ::validate
     */
    public function assertNotificationThrowsExceptionForInvalidEntries ()
    {
        $this->expectException("LogicException");
        $slackNotification = new SlackNotification("1 asdf. @ a.c");
    }

    /**
     * @test
     * @covers ::getWebhook
     */
    public function assertSlackValueIsAccessible ()
    {
        $expected = "https://slack.com/team/webhook";
        $slackNotification = new SlackNotification($expected);
        $actual = $slackNotification->getSlack();
        $this->assertEquals($expected, $actual);
        $this->assertInternalType("string", $actual);
    }
}
