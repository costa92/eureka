<?php
/**
 * Class EurekaConfig
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka;


use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Eureka\Discovery\RandomStrategy;
use Swoft\Eureka\Interfaces\DiscoveryStrategy;
use Swoft\Eureka\Interfaces\InstanceProvider;

/**
 * Class EurekaConfig
 * @package Swoft\Eureka
 * @Bean()
 */
class EurekaConfig
{
    private $hostName;
    private $appName;
    private $ip;
    private $status = 'UP';
    private $overriddenStatus = 'UNKNOWN';
    private $port;
    private $securePort = ['443', false];
    private $countryId = '1';
    private $dataCenterInfo = ['com.netflix.appinfo.InstanceInfo$DefaultDataCenterInfo', 'MyOwn' /* keyword */];
    private $homePageUrl;
    private $statusPageUrl;
    private $healthCheckUrl;
    private $vipAddress;
    private $secureVipAddress;

    private $heartbeatInterval = 30;

    /**
     * @Inject()
     * @var DiscoveryStrategy
     */
    private $discoveryStrategy;

    /**
     * @var InstanceProvider
     */
    private $instanceProvider;

    // constructor
    public function initConfig(array $config) {
        foreach ($config as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        if(empty($this->vipAddress)) {
            $this->vipAddress = $this->appName;
        }
        if(empty($this->secureVipAddress)) {
            $this->secureVipAddress = $this->appName;
        }
        if(empty($this->discoveryStrategy)) {
            $this->discoveryStrategy = new RandomStrategy();
        }
    }


    public function getHostName() {
        return $this->hostName;
    }

    public function getAppName() {
        return $this->appName;
    }

    public function getIp() {
        return $this->ip;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getOverriddenStatus(): string
    {
        return $this->overriddenStatus;
    }

    public function getPort() {
        return $this->port;
    }

    public function getSecurePort(): array
    {
        return $this->securePort;
    }

    public function getCountryId(): string
    {
        return $this->countryId;
    }

    public function getDataCenterInfo(): array
    {
        return $this->dataCenterInfo;
    }

    public function getHomePageUrl() {
        return $this->homePageUrl;
    }

    public function getStatusPageUrl() {
        return $this->statusPageUrl;
    }

    public function getHealthCheckUrl() {
        return $this->healthCheckUrl;
    }

    public function getVipAddress() {
        return $this->vipAddress;
    }

    public function getSecureVipAddress() {
        return $this->secureVipAddress;
    }

    public function getHeartbeatInterval(): int
    {
        return $this->heartbeatInterval;
    }

    public function getDiscoveryStrategy(): DiscoveryStrategy
    {
        return $this->discoveryStrategy;
    }

    /**
     * @return InstanceProvider
     */
    public function getInstanceProvider(): InstanceProvider
    {
        return $this->instanceProvider;
    }


    public function setHostName($hostName) {
        $this->hostName = $hostName;
    }

    public function setAppName($appName) {
        $this->appName = $appName;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setOverriddenStatus($overriddenStatus) {
        $this->overriddenStatus = $overriddenStatus;
    }

    public function setPort($port) {
        $this->port = $port;
    }

    public function setSecurePort($securePort) {
        $this->securePort = $securePort;
    }

    public function setCountryId($countryId) {
        $this->countryId = $countryId;
    }

    public function setDataCenterInfo($dataCenterInfo) {
        $this->dataCenterInfo = $dataCenterInfo;
    }

    public function setHomePageUrl($homePageUrl) {
        $this->homePageUrl = $homePageUrl;
    }

    public function setStatusPageUrl($statusPageUrl) {
        $this->statusPageUrl = $statusPageUrl;
    }

    public function setHealthCheckUrl($healthCheckUrl) {
        $this->healthCheckUrl = $healthCheckUrl;
    }

    public function setVipAddress($vipAddress) {
        $this->vipAddress = $vipAddress;
    }

    public function setSecureVipAddress($secureVipAddress) {
        $this->secureVipAddress = $secureVipAddress;
    }

    public function setHeartbeatInterval($heartbeatInterval) {
        $this->heartbeatInterval = $heartbeatInterval;
    }

    public function setDiscoveryStrategy(DiscoveryStrategy $discoveryStrategy) {
        $this->discoveryStrategy = $discoveryStrategy;
    }

    public function setInstanceProvider(InstanceProvider $instanceProvider) {
        $this->instanceProvider = $instanceProvider;
    }

    /**
     * @return array[]
     */
    public function getRegistrationConfig(): array
    {
        return [
            'instance' => [
                'instanceId' => $this->getInstanceId(),
                'hostName' => $this->hostName,
                'app' => $this->appName,
                'ipAddr' => $this->ip,
                'status' => $this->status,
                'overriddenstatus' => $this->overriddenStatus,
                'port' => [
                    '$' => $this->port[0],
                    '@enabled' => $this->port[1]
                ],
                'securePort' => [
                    '$' => $this->securePort[0],
                    '@enabled' => $this->securePort[1]
                ],
                'countryId' => $this->countryId,
                'dataCenterInfo' => [
                    '@class' => $this->dataCenterInfo[0],
                    'name' => $this->dataCenterInfo[1]
                ],
                'homePageUrl' => $this->homePageUrl,
                'statusPageUrl' => $this->statusPageUrl,
                'healthCheckUrl' => $this->healthCheckUrl,
                'vipAddress' => $this->vipAddress,
                'secureVipAddress' => $this->secureVipAddress
            ]
        ];
    }

    /**
     * @return string
     */
    public function getInstanceId(): string
    {
        return $this->getHostName() . ':' . $this->getAppName() . ':' . $this->port[0];
    }
}
