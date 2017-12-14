<?php declare (strict_types = 1);

namespace Cronitor\Framework\Serializer\Normalizer\Tests;

use Cronitor\Component\Monitor\HeartbeatMonitor;
use Cronitor\Component\Monitor\HealthcheckMonitor;
use Cronitor\Component\Notification\MonitorNotifications;
use Cronitor\Component\Notification\EmailNotification;
use Cronitor\Component\Rule\MonitorRule;
use Cronitor\Component\Tag\MonitorTag;
use Cronitor\Framework\Serializer\Normalizer\ObjectNormalizer;
use Cronitor\Framework\Test\CronitorFixtures;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

final class ObjectNormalizerSpec extends TestCase
{
    use CronitorFixtures;
    use VarDumperTestTrait;

    protected function setUp ()
    {
        $this->serializer = new Serializer(
            [
                new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter, null, new ReflectionExtractor),
                new ArrayDenormalizer,
                new PropertyNormalizer,
            ],
            [new JsonEncoder()]
        );

        $this->notifications = new MonitorNotifications;
        $this->notifications->addNotification("email", "test@example.tld");
        $this->rules = [
            new MonitorRule([
                "rule_type" => MonitorRule::NOT_ON_SCHEDULE,
                "time_unit" => MonitorRule::HOURS,
                "value" => 10,
                "hours_to_followup_alert" => 1,
                "grace_seconds" => 69,
            ]),
        ];
        $this->tags = [new MonitorTag("foo"), new MonitorTag("bar")];
        $this->monitor = (new HeartbeatMonitor)
            ->setName("monitor")
            ->setNotifications($this->notifications)
            ->setRules($this->rules)
            ->setTags($this->tags)
            ->setNote("Hello World!")
            ;
    }

    protected function tearDown ()
    {
        unset($this->serializer);
        unset($this->notifications);
        unset($this->rules);
        unset($this->tags);
        unset($this->monitor);
    }

    /**
     * @test
     */
    public function assertDataSerializesCorrectlyForPostingDataToTheApi ()
    {
        $expected = $this->getFixtureContents("dumps/postMonitor.txt");
        $received = $this->serializer->serialize($this->monitor, "json");

        $this->assertDumpEquals($expected, $received);
    }

    /**
     * @test
     */
    public function assertDataDeserializesCorrectlyForGettingDataFromTheApi ()
    {
        $expected = $this->getFixtureContents("dumps/getMonitor.txt");
        $received = $this->serializer->deserialize(
            $this->getFixtureContents("responses/getMonitor.json"),
            HeartbeatMonitor::class,
            "json"
        );

        $this->assertDumpEquals($expected, $received);
    }
}
