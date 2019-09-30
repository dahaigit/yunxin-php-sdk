<?php
namespace YunXinIM;

class BaseClient
{
    /**
     * @var 所有请求都要经过BaseClient进行转发。并且BasecClient可以拥有中间件。处理，Auth，日志，等等功能。
     */
    private $http;

    /**
     * @var string 请求基础url
     */
    protected $baseUrl = 'https://api.netease.im/';

    /**
     * IM 请求代理
     * @param IMAuth $auth
     */
    public function __construct(IMAuth $auth)
    {
        $httpOptions = [
            'http_header' => $auth->getAuthHeaders()
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
                    // 这里我们直接抛出异常
                    throw new IMException($response['body']['code'] . "|" . $response['body']['desc']);
                    // 实际项目中，我们这样写。注意，不要把这些报错，直接显示出来。只提示im接口请求报错。并且记录日志。
                    // self::logWarningStatic($response['body']['code'] . "|" .$response['body']['desc'] . "|" . $url);
                    // self::throwErrorStatic(Code::E_IM_ERROR);
                }
                return $response['body'];
            } else {
                throw new IMException('未获取内容');
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}