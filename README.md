# Eureka

Eureka component for swoft framework

## Install

- install by composer

```bash
composer require swoft/eureka
```

- 修改配置信息 app/bean.php 文件

```bash
 'eureka' => [
        'class'=> \Swoft\Eureka\Eureka::class,
        'eurekaHost' => config("eureka.ip"),
        'eurekaPort' => config("eureka.port"),
        'ssl'  => true,
        'service' =>  [
            'appName' => config("eureka.appName"),
            'hostName' => '',
            'ip' => config("bases.listen_ip"),
            'port' => [config("bases.http.port"), false],
            'homePageUrl' => "actuator/info",
            'statusPageUrl' => "actuator/info",
            'healthCheckUrl' => "actuator/info"
        ],
    ]
```

- 注册方法

```bash
  /** @var Agent $eureka */
  $eureka =  BeanFactory::getBean(Agent::class);
  $eureka->register();
```

- 注销方法

```bash
/** @var Agent $eureka */
$eureka =  BeanFactory::getBean(Agent::class);
$eureka->deRegister();
```
- 是否注册
```bash
/** @var Agent $eureka */
$eureka =  BeanFactory::getBean(Agent::class);
$eureka->isRegister();
```
- 获取服务信息
```bash
       /** @var Agent $eureka */
        $eureka =  BeanFactory::getBean(Agent::class);
        $rs = $eureka->fetchInstance($config["appName"]);
        $instance = $rs->getResult()["application"]["instance"];
        // 获取注册服务信息
        $serviceArr = InstanceHelpers::getRandomInstance($instance);
        // 多个服务，如果第一个服务失败，可以获取另外的
        $serviceArr = InstanceHelpers::getRandomInstance($instance,$serviceArr["instanceId"]);
```

- 心跳机制
```bash
/** @var Agent $eureka */
$eureka =  BeanFactory::getBean(Agent::class);
$eureka->heartbeat();
```

## LICENSE

The Component is open-sourced software licensed under the [Apache license](LICENSE).
