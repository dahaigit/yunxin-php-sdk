<?php

spl_autoload_register(function ( $className) {
    $className = str_replace('\\', '/', $className);
    require_once __DIR__ . "/" .  $className . '.php';
});


$envs = parse_ini_file('.env');
$appKey = $envs['APP_KEY'];
$appSecret = $envs['APP_SECRET'];

try {
    $client = new \YunXinIm\IMAuth($appKey, $appSecret);
    $imTeam = new \YunXinIm\IM\Team($client);
    $tids = ['2687849475'];
//    // 获取某个群的信息和群人员。
//    $imTeamInfo = $imTeam->getTeamsInfoAddMembers($tids);
//    dd($imTeamInfo);
    $imUser = new \YunXinIm\IM\User($client);
    $user = $imUser->create(1,1);
    /*
     * 报错
     * int(414)
        string(16) "already register"
     *
     * */
    dd($user);

} catch (\Exception $exception) {
    dd($exception->getMessage());
}

function dd($res)
{
    var_dump($res);
    exit;
}