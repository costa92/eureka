<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

return [
    'config' => [
        'path' => __DIR__ . '/config',
    ],
    'logger'            => [
        'flushRequest' => false,
        'enable'       => false,
        'json'         => false,
    ],

    'eureka' => [
        'class'=> \Swoft\Eureka\Eureka::class,
        'eurekaHost' => '127.0.0.1',
        'eurekaPort' => 8761,
        'ssl'  => true,
        'service' =>  [
            'appName' => 'test',
            'hostName' => 'test.hamid.work',
            'ip' => env("LISTEN_IP",""),
            'port' => ['18311', true],
            'homePageUrl' => "actuator/info",
            'statusPageUrl' => "actuator/info",
            'healthCheckUrl' => "actuator/info"
        ],
    ]
];
