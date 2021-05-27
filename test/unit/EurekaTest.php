<?php

namespace SwoftTest\Eureka\Unit;

use PHPUnit\Framework\TestCase;
use Swoft\Bean\BeanFactory;
use Swoft\Eureka\Agent;
use Swoft\Eureka\Eureka;
use Swoft\Eureka\Exception\ClientException;
use Swoft\Eureka\Exception\ServerException;
use Swoft\Eureka\Helpers\InstanceHelpers;

/**
 * Class EurekaTest
 * author:costalong
 * Email:longqiuhong@163.com
 */

class EurekaTest extends TestCase
{
    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testClient(){
        /** @var Agent $eureka */
        $eureka =  BeanFactory::getBean(Agent::class);
        $eureka->register();
    }


    public function testDeRegister()
    {
        /** @var Agent $eureka */
        $eureka =  BeanFactory::getBean(Agent::class);
        $eureka->deRegister();
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testIsRegister()
    {
        /** @var Agent $eureka */
        $eureka =  BeanFactory::getBean(Agent::class);
        $eureka->isRegister();
    }


    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testHeartbeat()
    {
        /** @var Agent $eureka */
        $eureka =  BeanFactory::getBean(Agent::class);
        $eureka->heartbeat();
    }

    /**
     * @throws ClientException
     * @throws ServerException
     */
    public function testFetchInstance()
    {
        $config = $this->getConfig();
        /** @var Agent $eureka */
        $eureka =  BeanFactory::getBean(Agent::class);
        $rs = $eureka->fetchInstance($config["appName"]);
        $instance = $rs->getResult()["application"]["instance"];
        $serviceArr = InstanceHelpers::getRandomInstance($instance);
        $serviceArr = InstanceHelpers::getRandomInstance($instance,$serviceArr["instanceId"]);


    }



    /**
     *
     */
    public function getConfig(): array
    {
        return [
            'eurekaDefaultUrl' => 'http://localhost:8761/eureka',
            'hostName' => 'test.hamid.work1',
            'appName' => 'test',
            'ip' => '127.0.0.2',
            'port' => ['18311', true],
            'homePageUrl' => 'http://127.0.0.2:18311',
            'statusPageUrl' => 'http://127.0.0.2:18311/info',
            'healthCheckUrl' => 'http://127.0.0.2:18311/health'
        ];
    }
}
