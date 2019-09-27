<?php
namespace YunXinIm\IM;

use YunXinIm\Proxy;

class User extends Proxy
{
    /**
     * Notes: 创建用户，注册用户
     * User: mhl
     * @param $accid 自定义用户id
     * @param $name  用户名称
     * @return int
     * @throws \Exception
     */
    public function create($accid, $name)
    {
        $url = $this->baseUrl . 'nimserver/user/create.action';
        $body = [
            'accid' => $accid,
            'name' => $name,
            // 用户登陆token
            'token' => md5($accid),
        ];
        return $this->post($url, $body);
    }
}


