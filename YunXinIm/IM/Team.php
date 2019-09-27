<?php
namespace YunXinIm\IM;

use YunXinIm\IM;

class Team extends IM
{
    /**
     * Notes: 创建群
     * User: mhl
     * @param $groupName 组的名称
     * @param $groupOwner 群主ID
     * @param $groupMembers array 群人人员
     * @return null
     * @throws \Exception
     */
    public function create($groupName, $groupOwner,array $groupMembers)
    {
        $url = 'https://api.netease.im/nimserver/team/create.action';
        try {
            $body = [
                'tname' => $groupName,
                'owner' => $groupOwner,
                'members' => json_encode(array_keys($groupMembers)),
                'msg' => 'invite member',
                'magree' => 0,
                'joinmode' => 0
            ];
            return $this->post($url, $body);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Notes: 解散群
     * User: mhl
     * @param $tid 群ID
     * @param $owner 群主ID
     * @return null
     * @throws \Exception
     */
    public function remove($tid, $owner)
    {
        $url = 'https://api.netease.im/nimserver/team/remove.action';
        try {
            $body = [
                'tid' => $tid,
                'owner' => $owner,
            ];
            return $this->post($url, $body);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Notes: 更新组成员
     * User: mhl
     * @param $tid 群ID
     * @param $owner
     * @param array $addMembers 新增成员ID数组 ['xyym_294']
     * @param array $kickMembers 踢出成员ID数组 ['xyym_294']
     * @return array [
     *                  "add_res" => null
     *                  "kick_res" => array:1 [
     *                      "code" => 200
     *                  ]
     *              ]
     * @throws \Exception
     */
    public function updateMembers($tid, $owner, array $addMembers = [], array $kickMembers = [])
    {
        $addRes = null;
        $kickRes = null;
        try {
            if (!empty($addMembers)) {
                $addUrl = 'https://api.netease.im/nimserver/team/add.action';
                $addBody = [
                    'tid' => $tid,
                    'owner' => $owner,
                    'members' => json_encode($addMembers),
                    'magree' => 0,
                    'msg' => 'Welcome to group',
                ];
                $addRes =  $this->post($addUrl, $addBody);
            }
            if (!empty($kickMembers)) {
                $kickUrl = 'https://api.netease.im/nimserver/team/kick.action';
                $kickBody = [
                    'tid' => $tid,
                    'owner' => $owner,
                    'members' => json_encode($kickMembers),
                ];
                $kickRes =  $this->post($kickUrl, $kickBody);
            }
            return [
                'add_res' => $addRes,
                'kick_res' => $kickRes
            ];
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Notes: 获取多组信息和成员
     * User: mhl
     * @param array $tids 群id数组
     * @param int $ope
     * @return array [
     *  "tinfos" => array:1 [
     *      0 => array:18 [
     *          "icon" => null
     *          "announcement" => null
     *          "updatetime" => 1568789470385
     *          "muteType" => 0
     *          "uptinfomode" => 0
     *          "maxusers" => 200
     *          "intro" => null
     *          "size" => 3
     *          "createtime" => 1568787647433
     *          "upcustommode" => 0
     *          "owner" => "xyym_239"
     *          "tname" => "大海新创建"
     *          "beinvitemode" => 0
     *          "joinmode" => 0
     *          "tid" => 2687865120
     *          "members" => array:2 [
     *              0 => "xyym_291"
     *              1 => "xyym_294"
     *          ]
     *          "invitemode" => 0
     *          "mute" => false
     *      ]
     *  ]
     *  "code" => 200
     *  ]
     * @throws \Exception
     */
    public function getTeamsInfoAddMembers(array $tids, $ope = 1)
    {
        $url = 'https://api.netease.im/nimserver/team/query.action';
        try {
            $body = [
                'tids' => json_encode($tids),
                'ope' => $ope,
            ];
            return $this->post($url, $body);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}


