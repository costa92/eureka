<?php
/**
 * Class Anget
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\BeanFactory;
use Swoft\Eureka\Interfaces\AgentInterface;
use Swoft\Http\Server\HttpServer;
use Swoole\Http\Server;

/**
 * Class Agent
 * @package Swoft\Eureka
 * @Bean()
 */
class Agent implements AgentInterface
{

    /**
     * @var EurekaConfig
     */
    protected $eurekaConfig;

    /**
     * @var string
     */
    protected $appName;

    /**
     * @return string
     */
    public function getAppName(): string
    {
        return $this->appName;
    }

    /**
     * @param string $appName
     */
    public function setAppName(string $appName): void
    {
        $this->appName = $appName;
    }




    /**
     * Service info register to eureka
     * @param string $appName
     * @param array $options
     * @return Response
     */
    public function register(string $appName = "" ,array $options = []): Response
    {
        $config = $this->getEurekaRegisterConfigInfo();
        if ($this->getAppName()){
            $appName = $this->getAppName();
        }
        $options["body"] = $config;
        $options = $this->getHeaders($options);
        $uri =  '/eureka/apps/' .$appName;
        return $this->getEureka()->post($uri,$options);
    }

    /**
     * Service cancel register eureka
     * @param string $appName
     * @param array $options
     * @return Response
     */
    public function deRegister(string $appName = "",array $options = []): Response
    {
        $this->getEurekaRegisterConfigInfo();
        if ($this->getAppName()){
            $appName = $this->getAppName();
        }
        // set request headers
        $options = $this->getHeaders($options);
        $uri = '/eureka/apps/' . $appName . '/' . $this->eurekaConfig->getInstanceId();

        return $this->getEureka()->delete($uri,$options);
    }

    /**
     * Eureka whether is to register
     * @param string $appName
     * @param array $options
     * @return Response
     */
    public function isRegister(string $appName  = "" ,array $options =[]): Response
    {
        $this->getEurekaRegisterConfigInfo();
        if ($this->getAppName()){
            $appName = $this->getAppName();
        }
        $uri =  '/eureka/apps/' . $appName. '/' . $this->eurekaConfig->getInstanceId();
        $options = $this->getHeaders($options);
        return $this->getEureka()->get($uri,$options);
    }

    /**
     * check heartbeat
     * @param string $appName
     * @param array $options
     * @return Response
     */
    public function heartbeat(string $appName = "" ,array $options = []): Response
    {
        $this->getEurekaRegisterConfigInfo();
        if ($this->getAppName()){
            $appName = $this->getAppName();
        }
        $uri =  '/eureka/apps/' .$appName . '/' . $this->eurekaConfig->getInstanceId();
        $options = $this->getHeaders($options);
        return $this->getEureka()->put($uri,$options);
    }

    /**
     * get service data list
     * @param string $appName
     * @param array $options
     * @return Response
     */
    public function fetchInstance(string $appName = "",array $options = []): Response
    {
        $this->getEurekaRegisterConfigInfo();
        if ($this->getAppName()){
            $appName = $this->getAppName();
        }
        $uri =  '/eureka/apps/' .$appName;
        $options = $this->getHeaders($options);
        return $this->getEureka()->get($uri,$options);
    }

    /**
     * default header array
     * @return string[]
     */
    protected function getDefaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /***
     * request header data
     * @param array $options
     * @return array
     */
    protected  function getHeaders(array $options =[]): array
    {
        $headers = $this->getDefaultHeaders();
        if (isset($options["headers"])){
            $options["headers"] = array_merge($options["headers"],$headers);
        }else{
            $options["headers"] = $headers;
        }
        return $options;
    }

    /**
     * @return Eureka
     */
    protected function getEureka(): Eureka
    {
        return BeanFactory::getBean(Eureka::class);
    }


    /**
     * get eureka config info
     * @return array
     */
    public function getEurekaRegisterConfigInfo(): array
    {
        $serviceConfig = [];
        $eureka = $this->getEureka();
        $registerConfigInfo =  $eureka->getService();
        if ($registerConfigInfo){
            $this->eurekaConfig  =  BeanFactory::getBean(EurekaConfig::class);
            /** @var array $serviceConfig */
            $this->eurekaConfig->initConfig($registerConfigInfo);
            // is service ip config
            if (empty($this->eurekaConfig->getIp())){
                $ip = $this->getServiceIp();
                $this->eurekaConfig->setIp($ip);
            } else {
                $ip = $this->eurekaConfig->getIp();
            }

            // defaults
            if(empty($this->eurekaConfig->getHostName())) {
                $this->eurekaConfig->setHostName($this->eurekaConfig->getIp());
            }

            // is HttpServer info
            if (!empty($this->eurekaConfig->getPort()) && is_null(HttpServer::getServer()) == false ){
                $servicePort = HttpServer::getServer()->getPort();
                $port = $this->eurekaConfig->getPort();
                $port[0] = $servicePort;
                $this->eurekaConfig->setPort($port);
            }else{
                $port = $this->eurekaConfig->getPort();
            }
            $listenPost = $port[0];
            $protocol ="http://";
            if (!empty($port[1]) && $port[1] == true){
                $protocol = "https://";
            }
            // 注册信息
            $registerHostname = $protocol.$ip.":".$listenPost."/";

            $this->eurekaConfig->setHomePageUrl($registerHostname.$this->eurekaConfig->getHomePageUrl());
            $this->eurekaConfig->setHealthCheckUrl($registerHostname.$this->eurekaConfig->getHealthCheckUrl());
            $this->eurekaConfig->setStatusPageUrl($registerHostname.$this->eurekaConfig->getStatusPageUrl());

            $serviceConfig =  $this->eurekaConfig->getRegistrationConfig();
            // set appName
            if (!empty($serviceConfig["instance"]["app"])){
                $this->setAppName($serviceConfig["instance"]["app"]);
            }
        }
        return $serviceConfig;
    }

    /**
     * get service ip info
     */
    public function getServiceIp()
    {
        $ips = swoole_get_local_ip();
        return array_shift($ips);
    }
}
