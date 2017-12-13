<?php declare (strict_types = 1);

namespace Cronitor\Tests\Monitor\Notifications;

use Cronitor\Monitor\Notifications\MonitorNotifications;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Cronitor\Monitor\MonitorNotifications
 */
final class MonitorNotificationsSpec extends TestCase
{
    protected function setUp ()
    {
        $this->notifications = new MonitorNotifications;
    }

    protected function tearDown ()
    {
        unset($this->notifications);
    }

    /**
     * @test
     */
    public function assertNotificationsExist ()
    {
        $this->assertInternalType("object", $this->notifications);
        $this->assertInstanceOf(MonitorNotifications::class, $this->notifications);
    }

    /**
     * @test
     * @covers ::addNotification
     * @uses ::listNotifications
     */
    public function assertNotificationsCanBeAdded ()
    {
        $notifications = $this->notifications->listNotifications();
        foreach ($notifications as $type)
            $this->assertEmpty($type);

        foreach ([
            "emails" => "joetest@somedomain.tld",
            "slack" => "https://slack.com/that/WEBHOOK",
            "webhooks" => "https://somesite.tld/that/WEBHOOK.php",
        ] as $type => $value)
            $this->notifications->addNotification($type, $value);

        $notifications = $this->notifications->listNotifications();
        foreach ($notifications as $type)
            $this->assertNotEmpty($type);
    }
}
