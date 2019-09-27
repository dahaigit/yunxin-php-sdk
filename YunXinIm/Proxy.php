<?php
namespace YunXinIm;

class Proxy
{
    private $http;

    protected $baseUrl = 'https://api.netease.im/';

    /**
     * 请求方式
     */
    const REQUEST_METHODS = [
        'GET' => 'get',
        'POST' => 'post',
        'PUT' => 'put',
        'DELETE' => 'delete',
    ];

    /**
     * IM 请求的代理
     * @param YunXinImClient $client
     */
    public function __construct(YunXinImClient $client)
    {
        $httpOptions = [
            'http_header' => $client->getHttpHeaders()
        ];
        $this->http = Http::getInstance($httpOptions);
    }

    public function get($url,array $data)
    {
        return $this->getContent(__FUNCTION__, $url, $data);
    }

    public function post($url,array $data)
    {
        return $this->getContent(__FUNCTION__, $url, $data);
    }

    public function put($url,array $data)
    {
        return $this->getContent(__FUNCTION__, $url, $data);
    }

    public function delete($url,array $data)
    {
        return $this->getContent(__FUNCTION__, $url, $data);
    }

    /**
     * Notes: 获取内容
     * User: mhl
     * @param $method 请求方法
     * @param string $url 请求地址
     * @param array $data 请求数据
     * @return array|null
     * @throws \Exception
     */
    private function getContent($method, string $url,array $data)
    {
        try {
            $response = $this->http->$method($url, $data);
            return isset($response['body']) ? $response['body'] : null;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}