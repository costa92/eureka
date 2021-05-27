<?php
/**
 * Class EurekaController
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka\Controller;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * Class EurekaController
 * @package Swoft\Eureka\Controller
 * @Controller("")
 */
class EurekaController
{
    /**
     * @RequestMapping(route="eureka",method={RequestMethod::GET,RequestMethod::POST,RequestMethod::PUT,RequestMethod::DELETE})
     */
    public function index(): string
    {
        return "up";
    }

    /**
     * @RequestMapping(route="eureka/status",method={RequestMethod::GET,RequestMethod::POST,RequestMethod::PUT,RequestMethod::DELETE})
     */
    public function status(): string
    {
        return "up";
    }

    /**
     * @RequestMapping(route="eureka/health",method={RequestMethod::GET,RequestMethod::POST,RequestMethod::PUT,RequestMethod::DELETE})
     */
    public function health(): string
    {
        return "up";
    }

    /**
     * @RequestMapping(route="actuator/info",method={RequestMethod::GET,RequestMethod::POST,RequestMethod::PUT,RequestMethod::DELETE})
     */
    public function actuator()
    {
        return "up";
    }
}
