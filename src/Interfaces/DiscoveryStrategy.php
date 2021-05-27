<?php
/**
 * Class DiscoveryStrategy
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka\Interfaces;

use Swoft\Bean\Annotation\Mapping\Bean;

/***
 * Interface DiscoveryStrategy
 * @package Swoft\Eureka\Interfaces
 * @Bean()
 */
interface DiscoveryStrategy
{
    /**
     * @param array $instances
     * @return mixed
     */
    public function getInstance(array $instances);
}
