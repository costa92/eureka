<?php declare(strict_types=1);
/**
 * Class Eureka
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Eureka\Exception\ClientException;
use Swoft\Eureka\Exception\ServerException;
use Swoft\Eureka\Interfaces\EurekaInterface;


/**
 * Class Eureka
 * @since 2.0
 * @method get(string $uri,array $options = [])
 * @method post(string $uri,array $options = [])
 * @method delete(string $uri,array $options = [])
 * @method patch(string $uri,array $options = [])
 * @method put(string $uri,array $options = [])
 * @method head(string $uri,array $options = [])
 * @method options(string $uri,array $options = [])
 *
 * @Bean("eureka")
 */
class Eureka implements EurekaInterface
{
    /**
     * @Inject()
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    private $eurekaHost = "127.0.0.11";
    /**
     * @var int
     */
    private $eurekaPort = 8761;
    /**
     * @var string
     */
    private $timeout= 1;

    /**
     * @var array
     */
    private $service = [];

    /**
     * @return string
     */
    public function getEurekaHost(): string
    {
        return $this->eurekaHost;
    }

    /**
     * @param string $eurekaHost
     */
    public function setEurekaHost(string $eurekaHost): void
    {
        $this->eurekaHost = $eurekaHost;
    }

    /**
     * @return int
     */
    public function getEurekaPort(): int
    {
        return $this->eurekaPort;
    }

    /**
     * @param int $eurekaPort
     */
    public function setEurekaPort(int $eurekaPort): void
    {
        $this->eurekaPort = $eurekaPort;
    }


    /**
     * @return int|string
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     */
    public function setTimeout($timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * @return array
     */
    public function getService(): array
    {
        return $this->service;
    }

    /**
     * @param array $service
     */
    public function setService(array $service): void
    {
        $this->service = $service;
    }

    /**
     * get request method name
     * @return string[]
     */
    protected function getRequestMethod(): array
    {
        return ["get","post",'delete','patch','put','head','options'];
    }

    /***
     * @param string $name
     * @param array $arguments
     * @return Response
     * @throws ClientException
     * @throws ServerException
     */
    public function __call(string $name,array $arguments)
    {
        $methods = $this->getRequestMethod();
        if (in_array($name,$methods)){
            $methodName = strtoupper($name);
            $this->request->setHost($this->getEurekaHost());
            $this->request->setPort($this->getEurekaPort());
            $this->request->setTimeout($this->getTimeout());
            return $this->request->request($methodName,...$arguments);
        }
    }
}
