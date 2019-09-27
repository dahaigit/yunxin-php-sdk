<?php
namespace YunXinIm\IM;

use YunXinIm\IM;

class User extends IM
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
        try {
            $body = [
                'accid' => $accid,
                'name' => $name,
                // 用户登陆token
                'token' => md5($accid),
            ];
            return $this->post($url, $body);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}


