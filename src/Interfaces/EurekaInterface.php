<?php
/**
 * Class Eureka
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka\Interfaces;


use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Interface EurekaInterface
 * @package Swoft\Eureka\Interfaces
 * @Bean()
 */
interface EurekaInterface
{
    /**
     * @return string
     */
    public function getEurekaHost(): string;

    /**
     * @param string $eurekaHost
     */
    public function setEurekaHost(string $eurekaHost): void;

    /**
     * @return int
     */
    public function getEurekaPort(): int;

    /**
     * @param int $eurekaPort
     */
    public function setEurekaPort(int $eurekaPort): void;

    /**
     * @return mixed
     */
    public function getTimeout();

    /**
     * @param $timeout
     */
    public function setTimeout($timeout): void;

    /**
     * @return array
     */
    public function getService(): array;

    /**
     * @param array $service
     */
    public function setService(array $service): void;
}
