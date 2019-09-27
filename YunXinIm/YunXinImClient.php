<?php
namespace YunXinIm;

class YunXinImClient
{
    /**
     * @var 平台的key
     */
    public $appKey;

    /**
     * @var 平台的秘钥
     */
    public $appSecret;

    /**
     * @var 当前时间戳
     */
    private $curTime;

    /**
     * @var 随机字符串(最大长度128个字符)
     */
    private $nonce;

    /**
     * @var SHA1(appSecret+ Nonce + CurTime)三个参数拼接的字符串进行sha1哈希计算，转化成16进制字符(String,小写)。
     */
    private $checkSum;

    /**
     * NetEaseImServer   获取云信IM客户端
     * @param $appKey    平台的key
     * @param $appSecret 平台的秘钥
     * @param $options   获取客户端的选项。
     */
    public function __construct($appKey, $appSecret,array $options = [])
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
    }

    /**
     * Notes: 获取请求头的header数据
     * User: mhl
     * @return array
     */
    public function getHttpHeaders()
    {
        $this->curTime = (string)(time());
        $this->nonce = md5(uniqid(microtime(true), true));
        $this->checkSum = sha1($this->appSecret . $this->nonce . $this->curTime);
        return [
            'AppKey:'.$this->appKey,
            'Nonce:'.$this->nonce,
            'CurTime:'.$this->curTime,
            'CheckSum:'.$this->checkSum,
            'Content-Type:application/x-www-form-urlencoded;charset=utf-8'
        ];
    }
}