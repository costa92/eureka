<?php
/**
 * Class InstanceProvider
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka\Interfaces;


interface InstanceProvider
{
    public function getInstances($appName);
}
