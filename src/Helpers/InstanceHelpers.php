<?php
/**
 * Class InstanceHeplers
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka\Helpers;

use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class InstanceHelpers
 * @package Swoft\Eureka\Helpers
 * @Bean()
 */
class InstanceHelpers
{
    /**
     * @param array $instances
     * @return array
     */
    public static function getInstanceInfo(array $instances = []): array
    {
        $result = [];
        if ($instances && is_array($instances)){
            $instancesInstanceId = array_column($instances,"instanceId");
            $instancesPort = array_column($instances,"port","instanceId");
            $instancesIpAddr = array_column($instances,"ipAddr","instanceId");
            // 处理数据
            foreach ($instancesInstanceId as $instanceId){
                $data["port"]  = $instancesPort[$instanceId]["$"];
                $data["host"]  = $instancesIpAddr[$instanceId];
                $data["ssl"]  = $instancesPort[$instanceId]["@enabled"];
                $data["instanceId"] = $instanceId;
                $result[$instanceId] = $data;
                unset($data);
            }
        }
        return $result;
    }

    /***
     * 获取随机的ip的信息
     * @param array $data
     * @param string $instanceId
     * @return array
     */
    public static function getRandomInstance(array $data = [],string $instanceId = ""): array
    {
        $result = [];
        $instances = self::getInstanceInfo($data);
        if ($instances){
            if ($instanceId) unset($instances[$instanceId]);
            /** @var  key array  提取  $hostArr */
            $hostArr = array_keys($instances);
            if ($hostArr){
                $arrLen = array_rand($hostArr,1);
                $randomKeys = $hostArr[$arrLen];
                $result = $instances[$randomKeys];
            }
        }
        return $result;
    }
}
