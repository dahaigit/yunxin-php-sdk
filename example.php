<?php

spl_autoload_register(function ( $className) {
    $className = str_replace('\\', '/', $className);
    require_once __DIR__ . "/" .  $className . '.php';
});


$envs = parse_ini_file('.env');
$appKey = $envs['APP_KEY'];
$appSecret = $envs['APP_SECRET'];

try {
    $client = new \YunXinIm\YunXinImClient($appKey, $appSecret);
    $imTeam = new \YunXinIm\IM\Team($client);
    $tids = ['26878494751'];
    // 获取某个群的信息和群人员。
    $imTeamInfo = $imTeam->getTeamsInfoAddMembers($tids);
    dd($imTeamInfo);
} catch (\Exception $exception) {
    // todo some things
    dd($exception->getMessage());
}

function dd($res)
{
    var_dump($res);
    exit;
}