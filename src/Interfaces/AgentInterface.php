<?php
/**
 * Class AgentInterface
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka\Interfaces;


use Swoft\Eureka\Exception\ClientException;
use Swoft\Eureka\Exception\ServerException;
use Swoft\Eureka\Response;

interface AgentInterface
{
    /**
     * @param string $appName
     * @param array $options
     * @return Response
     */
    public function register(string $appName,array $options = []): Response;

    /**
     * @param string $appName
     * @param array $options
     * @return Response
     */
    public function deRegister(string $appName,array $options = []): Response;

    /**
     * Eureka whether is to register
     * @param string $appName
     * @param array $options
     * @return Response
     * @throws ClientException
     * @throws ServerException
     */
    public function isRegister(string $appName,array $options =[]): Response;

    /**
     *
     * check heartbeat
     * @param string $appName
     * @param array $options
     * @return Response
     * @throws ClientException
     * @throws ServerException
     */
    public function heartbeat(string $appName,array $options = []): Response;

    /**
     * get instance list data
     * @param string $appName
     * @param array $options
     * @return Response
     */
    public function fetchInstance(string $appName,array $options = []): Response;

}
