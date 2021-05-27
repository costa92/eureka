<?php
/**
 * Class RandomStrategy
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka\Discovery;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Eureka\Interfaces\DiscoveryStrategy;

/**
 * Class RandomStrategy
 * @package Swoft\Eureka\Discovery
 * @Bean()
 */
class RandomStrategy implements DiscoveryStrategy {

    /**
     * @param array $instances
     * @return mixed|null
     */
    public function getInstance(array $instances)
    {
        if(count($instances) == 0)
            return null;

        return $instances[rand(0, count($instances) - 1)];
    }
}
