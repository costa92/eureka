<?php declare(strict_types=1);

namespace Swoft\Eureka;

use Swoft\Helper\ComposerJSON;
use Swoft\Redis\Pool;
use Swoft\Redis\RedisDb;
use Swoft\SwoftComponent;
use function dirname;

/**
 * Class AutoLoader
 */
class AutoLoader extends SwoftComponent
{
    /**
     * Get namespace and dir
     *
     * @return array
     * [
     *     namespace => dir path
     * ]
     */
    public function getPrefixDirs(): array
    {
        return [
            __NAMESPACE__ => __DIR__,
        ];
    }

    /**
     * Metadata information for the component.
     *
     * @return array
     * @see ComponentInterface::getMetadata()
     */
    public function metadata(): array
    {
        $jsonFile = dirname(__DIR__) . '/composer.json';

        return ComposerJSON::open($jsonFile)->getMetadata();
    }

    /**
     * @return array
     */
    public function beans(): array
    {
        return [
            'eureka' => [
                'class' => Eureka::class,
                'eurekaHost' => '127.0.0.1',
                'eurekaPort' => 8761,
                'eurekaSsl' => false,
                'service' => [
                    'appName' => 'test',
                ],
                'client' => [

                ]
            ]
        ];
    }
}
