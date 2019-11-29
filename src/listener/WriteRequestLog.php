<?php

namespace tlog\listener;

use think\facade\Db;

class WriteRequestLog
{
    public function handle($event)
    {
        if(config('app.rlog.disable')) return;

        $ipWhiteList    = config('app.rlog.white_list',[]);//['127.0.0.1', '192.168.16.96', '127.0.0.1', '192.168.16.118'];
        $data = get_http_request_data($ipWhiteList);
        $logId = Db::name('log_request')->insertGetId($data);

        //header("logId: $logId");
        $dir = app()->getRuntimePath().'/db_log';
        file_exists($dir) || mkdir($dir,0777,true);

        Db::listen(function($sql, $time, $explain)use($dir,$logId){
            if(!empty($logId) && strpos($sql,'log_request') === false){
                //echo $sql. ' ['.$time.'s]';
                //dump($explain);
                file_put_contents("$dir/$logId.sql", $sql.PHP_EOL, FILE_APPEND);
            }

        });

    }
}
