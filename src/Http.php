<?php
namespace YunXinIM;

class Http
{
    /**
     * @var array 请求的选项
     */
    private static $options = [];

    /**
     * @var obj 请求实例
     */
    private static $instance = null;

    /**
     * http请求封装
     * 目前只支持curl请求。单例模式
     *
     * @param array $options 请求的选项
     */
    private function __construct(array $options = [])
    {
        self::$options = $options;
    }

    /**
     * 获取实例
     *
     * @param array $options http选项
     * @return Http::instance
     */
    public static function getInstance(array $options =  [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($options);
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    /**
     * Notes: GET请求
     * User: mhl
     * @param $uri
     * @param array $query
     * @return mixed
     */
    public function get($uri, array $query = [])
    {
        if (!empty($query)) {
            $uri = $uri . "?" . http_build_query($query);
        }
        return self::request(__FUNCTION__, $uri);
    }

    public function post($uri, array $body = [])
    {
        return self::request(__FUNCTION__, $uri, $body);
    }

    public function put($uri, array $body = [])
    {
        return self::request(__FUNCTION__, $uri, $body);
    }

    public function delete($uri, array $body = [])
    {
        return self::request(__FUNCTION__, $uri, $body);
    }

    public function upload($uri, array $body = [])
    {
        $headers = [
            'Content-Type: multipart/form-data',
            'Connection: Keep-Alive',
        ];
        return self::request(__FUNCTION__, $uri, $body, $headers);
    }

    /**
     * Notes: 最终发起请求的方法
     * User: mhl
     * @param $method 请求的方法
     * @param $uri 请求的uri
     * @param array $body 请求内容
     * @param $headers 请求头
     * @return int
     */
    private static function request($method, $uri, $body = [], $headers = [])
    {
        $defaultHeaders = [
            'Content-Type: application/json',
            'Connection: Keep-Alive',
        ];

        $method = strtoupper($method);
        $ch = curl_init();
        $options = [
            // 设为TRUE，将在启用CURLOPT_RETURNTRANSFER时，返回原生的（Raw）输出。
            CURLOPT_RETURNTRANSFER => true,
            // 启用时会将头文件的信息作为数据流输出
            CURLOPT_HEADER => true,
            // 在http请求中包含一个User-Agent：头字符串
            CURLOPT_USERAGENT => 'NetEaseClient-Api-php-client',

            // 建立连接等待时间
            CURLOPT_CONNECTTIMEOUT => 20,
            // 最大执行时间
            CURLOPT_TIMEOUT => 120,

            // 需要获取的 URL 地址，也可以在curl_init() 初始化会话的时候。
            CURLOPT_URL => $uri,
            // 请求方法
            CURLOPT_CUSTOMREQUEST => ($method == 'UPLOAD') ? 'POST' : $method,
        ];

        if (!isset(self::$options['open_ssl']) || self::$options['open_ssl'] == true) {
            $options[CURLOPT_SSL_VERIFYPEER] = false;
            $options[CURLOPT_SSL_VERIFYHOST] = 0;
        }
        if (isset(self::$options['http_header'])) {
            // 这里写请求头信息
            $options[CURLOPT_HTTPHEADER] = self::$options['http_header'];
        } else {
            $options[CURLOPT_HTTPHEADER] = (empty($headers) ? $defaultHeaders : $headers);
        }
        if (!empty($body)) {
            if ('UPLOAD' == $method) {
                if (class_exists('\CURLFile')) {
                    $options[CURLOPT_SAFE_UPLOAD] = true;
                    $options[CURLOPT_POSTFIELDS] = ['filename' => new \CURLFile($body['path'])];
                } else {
                    if (defined('CURLOPT_SAFE_UPLOAD')) {
                        $options[CURLOPT_SAFE_UPLOAD] = false;
                    }
                    $options[CURLOPT_POSTFIELDS] = ['filename' => '@' . $body['path']];
                }
            } else {
                // 判断是否json传输，默认x-www-form-urlencoded
                if (isset($options['is_json']) && $options['is_json']) {
                    $options[CURLOPT_POSTFIELDS] = json_encode($body);
                } else {
                    $options[CURLOPT_POSTFIELDS] = http_build_query($body);
                }
            }
        }
        curl_setopt_array($ch, $options);
        $output = curl_exec($ch);

        if ($output === false) {
            return "Error Code:" . curl_errno($ch) . ", Error Message:" . curl_error($ch);
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headerText = substr($output, 0, $headerSize);
            $body = substr($output, $headerSize);
            $headers = [];
            foreach (explode('\r\n', $headerText) as $line => $lineText) {
                if (!empty($lineText)) {
                    if ($line === 0) {
                        $headers[0] = $lineText;
                    } else if (strpos($lineText, ': ')) {
                        list($key, $value) = explode(': ', $lineText);
                        $headers[$key] = $value;
                    }
                }
            }
            $response['headers'] = $headers;
            $response['body'] = json_decode($body, true);
            $response['http_code'] = $httpCode;
            curl_close($ch);
            return $response;
        }
    }
}

