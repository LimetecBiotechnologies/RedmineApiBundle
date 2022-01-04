<?php
use LimetecBiotechnologies\RedmineApiBundle\DependencyInjection\RedmineApiExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 08.06.17
 * Time: 14:42
 */
class RedmineApiExtensionTest extends PHPUnit_Framework_TestCase {
    /**
     * @var ContainerBuilder
     */
    private $container;
    /**
     * @var RedmineApiExtension
     */
    private $extension;

    protected function setUp () {
        parent::setUp();
        $this->container = new ContainerBuilder();
        $this->extension = new RedmineApiExtension();
    }

    /**
     * @test
     */
    public function createClients(){
       $config = [
           'redmine_api' => ['clients' => [
               'firstclient' => ['token'=>'123','url'=>'http://example.org/api/v3/'],
               'secondclient' => ['token'=>'234','url'=>'http://example.com/api/v3/']
           ]]
        ];

       $this->extension->load($config,$this->container);

       $this->assertTrue($this->container->hasAlias('redmineapi.client.default'));
       $this->assertTrue($this->container->has('redmine_api'));
       $this->assertTrue($this->container->has('redmineapi.client.firstclient'));
       $this->assertTrue($this->container->has('redmineapi.client.secondclient'));

       $this->assertInstanceOf('Redmine\Client\Client', $this->container->get('redmineapi.client.default'));
       $this->assertInstanceOf('Redmine\Client\Client', $this->container->get('redmineapi.client.firstclient'));
       $this->assertInstanceOf('Redmine\Client\Client', $this->container->get('redmineapi.client.secondclient'));
       $this->assertNotSame(
           $this->container->get('redmineapi.client.firstclient'),
           $this->container->get('redmineapi.client.secondclient')
        );
    }
}
