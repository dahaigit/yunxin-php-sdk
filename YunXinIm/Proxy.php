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
        'DEL' => 'del',
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

    public function __call($name, $arguments) {
        if (in_array($name, self::REQUEST_METHODS)) {
            if (count($arguments) != 2) {
                throw new \Exception('参数数量错误！');
            }
            $this->getBody($this->http->$name($arguments[0], $arguments[1]));
        } else {
            throw new \Exception('方法不存在！');
        }
    }

    private function getBody($output)
    {
        return isset($output['body']) ? $output['body'] : null;
    }
}