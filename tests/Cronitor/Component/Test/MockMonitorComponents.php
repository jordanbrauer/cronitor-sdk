<?php declare (strict_types = 1);

namespace Cronitor\Component\Test;

use Cronitor\Component\Notification\MonitorNotifications;
use Cronitor\Component\Rule\MonitorRule;
use Cronitor\Component\Tag\MonitorTag;

trait MockMonitorComponents
{
    public function getMockMonitorNotifications ()
    {
        return $this->getMockBuilder(MonitorNotifications::class)
            ->disableOriginalConstructor()->getMock();
    }

    public function getMockMonitorRule ()
    {
        return $this->getMockBuilder(MonitorRule::class)
            ->disableOriginalConstructor()->getMock();
    }

    public function getMockMonitorTag (...$args)
    {
        $mock = $this->getMockBuilder(MonitorTag::class)
            ->setConstructorArgs($args)->getMock();
        $mock->method("getLabel")->willReturn($args[0]);
        return $mock;
    }
}
