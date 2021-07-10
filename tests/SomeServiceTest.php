<?php

namespace App\Tests;

use App\Service\SomeService;
use MetroMarkets\FFBundle\FeatureFlagService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SomeServiceTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());

        $this->assertEquals(
            'Yo! It\'s on!',
            (new SomeService($this->getMock(true)))->doSomething()
        );

        $this->assertEquals(
            'Old is always better',
            (new SomeService($this->getMock(false)))->doSomething()
        );
    }

    private function getMock(bool $returnValue)
    {
        $featureFlagServiceMock = $this->getMockBuilder(FeatureFlagService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $featureFlagServiceMock->method('isEnabled')->willReturn($returnValue);

        return $featureFlagServiceMock;
    }
}
