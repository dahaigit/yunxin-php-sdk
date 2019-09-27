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
        return $this->getBody(__FUNCTION__, $url, $data);
    }

    public function post($url,array $data)
    {
        return $this->getBody(__FUNCTION__, $url, $data);
    }

    public function put($url,array $data)
    {
        return $this->getBody(__FUNCTION__, $url, $data);
    }

    public function delete($url,array $data)
    {
        return $this->getBody(__FUNCTION__, $url, $data);
    }

    /**
     * Notes: 获取内容
     * User: mhl
     * @param $method
     * @param string $url
     * @param array $data
     * @return null
     */
    private function getBody($method, string $url,array $data)
    {
        $output = $this->http->$method($url, $data);
        return isset($output['body']) ? $output['body'] : null;
    }
}