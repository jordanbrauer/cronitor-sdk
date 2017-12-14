<?php declare (strict_types = 1);

namespace Cronitor\Tests\Monitor;

use Cronitor\Component\Tag\MonitorTag;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Cronitor\Monitor\MonitorTag
 */
final class MonitorTagSpec extends TestCase
{
    /**
     * @test
     * @covers ::validate
     */
    public function assertTagThrowsExcpetionForInvalidLabels ()
    {
        $this->expectException("LogicException");
        $str50 = str_repeat("i", 51);
        $tag = new MonitorTag($str50);
    }

    /**
     * @test
     * @covers ::getLabel
     */
    public function assertTagIsAccessible ()
    {
        $expected = "testing";
        $tag = new MonitorTag($expected);
        $actual = $tag->getLabel();

        $this->assertEquals($expected, $actual);
        $this->assertInternalType("string", "actual");
    }
}
