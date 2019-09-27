<?php
namespace YunXinIm;

class IM
{
    private $http;

    protected $baseUrl = 'https://api.netease.im/';

    /**
     * IM 请求的基类
     * @param YunXinImClient $client
     */
    public function __construct(YunXinImClient $client)
    {
        $httpOptions = [
            'http_header' => $client->getHttpHeaders()
        ];
        $this->http = Http::getInstance($httpOptions);
    }

    public function get($uri, array $query = []) {
        return $this->getBody($this->http->get($uri, $query));
    }

    public function post($uri, array $body = []) {
        return $this->getBody($this->http->post($uri, $body));
    }

    public function put($uri, array $body = []) {
        return $this->getBody($this->http->put($uri, $body));
    }

    public function del($uri, array $body = []) {
        return $this->getBody($this->http->delete($uri, $body));
    }

    private function getBody($output)
    {
        return isset($output['body']) ? $output['body'] : null;
    }

}