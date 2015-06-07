<?php

namespace Krtv\Bundle\SingleSignOnServiceProviderBundle\DependencyInjection;

use Krtv\Bundle\SingleSignOnServiceProviderBundle\DependencyInjection\Compiler\AddUriSignerSecretPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class AddUriSignerSecretPassTest
 * @package Krtv\Bundle\SingleSignOnServiceProviderBundle\DependencyInjection
 */
class AddUriSignerSecretPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private $container;

    /**
     *
     */
    protected function setUp()
    {
        $this->container = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->getMock();
        $this->container->expects($this->any())
            ->method('getParameter')
            ->willReturnMap(array(
                array('krtv_single_sign_on_service_provider.secret_parameter', 'secret'),
                array('secret', 'secret_is_very_secret'),
            ));

        $encoder = $this->getMockBuilder('Symfony\Component\DependencyInjection\Definition')
            ->getMock();
        $encoder->expects($this->once())
            ->method('replaceArgument')
            ->with(0, 'secret_is_very_secret');

        $this->container->expects($this->any())
            ->method('getDefinition')
            ->willReturnMap(array(
                array('krtv_single_sign_on_service_provider.uri_signer', $encoder),
            ));

        $this->container->expects($this->any())
            ->method('hasDefinition')
            ->willReturnMap(array(
                array('krtv_single_sign_on_service_provider.uri_signer', true),
            ));

    }

    /**
     *
     */
    public function testProcess()
    {
        $pass = new AddUriSignerSecretPass();
        $pass->process($this->container);
    }
}