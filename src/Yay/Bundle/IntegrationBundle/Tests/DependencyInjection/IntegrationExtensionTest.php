<?php

namespace Yay\Bundle\IntegrationBundle\Tests\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Yay\Bundle\IntegrationBundle\DependencyInjection\IntegrationExtension;

class IntegrationExtensionTest extends WebTestCase
{
    /**
     * @test
     */
    public function load()
    {
        $builder = $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['getParameter'])
            ->getMock();

        $builder->expects($this->once())
            ->method('getParameter')
            ->willReturn('test');

        (new IntegrationExtension())->load([], $builder);
    }
}