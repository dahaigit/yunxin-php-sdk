<?php
namespace YunXinIm;

class Proxy
{
    /**
     * @var Http Http对象
     */
    private $http;

    /**
     * @var string 请求基础url
     */
    protected $baseUrl = 'https://api.netease.im/';

    /**
     * IM 请求代理
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
     * @return array
     * @throws \Exception
     */
    private function getContent($method, string $url,array $data)
    {
        try {
            $response = $this->http->$method($url, $data);
            if (isset($response['body'])) {
                if ($response['body']['code'] != 200) {
                    throw new YunXinImException($response['body']['code'] . "|" .$response['body']['desc']);
                }
                return $response['body'];
            } else {
                throw new YunXinImException('未获取内容');
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}