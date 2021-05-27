<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace SwoftTest\Eureka\Testing;

use Swoft\Eureka\Eureka;
use Swoft\SwoftComponent;

class AutoLoader extends SwoftComponent
{
    /**
     * Get namespace and dirs
     *
     * @return array
     */
    public function getPrefixDirs(): array
    {
        return [
            __NAMESPACE__ => __DIR__,
        ];
    }

    /**
     * @return array
     */
    public function metadata(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function beans(): array
    {
        return [
            'eureka' => [
                'class'       => Eureka::class,
                'host' => '127.0.0.1',
                'port' => 87611,
                'ssl'  => true,

                'service' =>  [
                    'appName' => 'test',
                ],
                'client' => [

                ]
            ]
        ];
    }
}