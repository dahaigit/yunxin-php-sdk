<?php
namespace YunXinIm\IM;

use YunXinIm\Proxy;

class History extends Proxy
{
    /**
     * Notes: 获取群云端历史消息
     * User: mhl
     * @param $tid          群ID
     * @param $accid        查询用户对应的accid
     * @param $beginTime    开始时间，ms
     * @param $endTime      截止时间，ms
     * @param int $limit    查询限制条数
     * @return null
     * @throws \Exception
     */
    public function getTeamMsg($tid, $accid, $beginTime, $endTime, $limit = 100)
    {
        $url = $this->baseUrl . 'nimserver/history/queryTeamMsg.action';
        $body = [
            'tid' => $tid,
            'accid' => $accid,
            'begintime' => $beginTime,
            'endtime' => $endTime,
            'limit' => $limit,
        ];
        return $this->post($url, $body);
    }
}


