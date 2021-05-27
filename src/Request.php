<?php
/**
 * Class Request
 * author:costalong
 * Email:longqiuhong@163.com
 */

namespace Swoft\Eureka;


use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Eureka\Exception\ClientException;
use Swoft\Eureka\Exception\EurekaException;

use Swoft\Eureka\Exception\ServerException;
use Swoft\Log\Helper\Log;
use Swoft\Stdlib\Helper\JsonHelper;
use Swoole\Coroutine\Http\Client;

/**
 * Class Request
 * @package Swoft\Eureka
 * @Bean()
 */
class Request
{
    /**
     * @var
     */
    private $host = "";

    /**
     * @var
     */
    private $port = 8761;
    /**
     * @var
     */
    private $timeout = 1;

    /**
     * @return mixed
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * @param $method
     * @param $uri
     * @param $options
     *
     * @return Response
     * @throws ClientException
     * @throws ServerException
     */
    public function request($method, $uri, $options): Response
    {
        $body = $options['body'] ?? '';
        if (is_array($body)) {
            $body = JsonHelper::encode($body, JSON_UNESCAPED_UNICODE);
        }
        $query = $options['query'] ?? [];
        if (!empty($query)) {
            $query = http_build_query($query);
            $uri   = sprintf('%s?%s', $uri, $query);
        }
        Log::debug('Requesting %s %s %s', $method, $uri, JsonHelper::encode($options));
        try {
            Log::profileStart($uri);
            // Http request
            $client = new Client($this->getHost(), $this->getPort());
            $client->setMethod($method);
            $client->set(['timeout' => $this->getTimeout()]);
            if (!empty($options["headers"])){
                $client->setHeaders($options["headers"]);
            }
            // Set body
            if (!empty($body)) {
                $client->setData($body);
            }
            $client->execute($uri);
            // Response
            $headers    = $client->headers;
            $statusCode = $client->statusCode;
            $body       = $client->body;
            // Close
            $client->close();

            Log::profileEnd($uri);
            if ($statusCode == -1 || $statusCode == -2 || $statusCode == -3) {
                throw new EurekaException(sprintf(
                    'Request timeout!(host=%s, port=%d timeout=%d)',
                    $this->getHost(),
                    $this->getPort(),
                    $this->getTimeout()
                ));
            }
        } catch (\Throwable $e) {
            $message = sprintf('Eureka is fail! (uri=%s status=%s body=%s).', $uri, $e->getMessage(), $body);
            Log::error($message);
            throw new ServerException($message);
        }
        if (400 <= $statusCode) {
            $message = sprintf('Eureka is fail! (uri=%s status=%s  body=%s)', $uri, $statusCode, $body);
            if (500 <= $statusCode) {
                Log::error($message);
                throw new ServerException($message, $statusCode);
            }
            Log::error($message);
            throw new ClientException($message, $statusCode);
        }
        return Response::new($headers, $body, $statusCode);
    }
}
