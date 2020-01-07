<?php

namespace tlog\listener;

use think\facade\Db;
use think\facade\Request;

class WriteResponseLog
{
    public function handle($response)
    {
        if(Request::isCli()) return;
        if(config('app.rlog.disable')) return;
        $ipWhiteList    = config('app.rlog.white_list',[]);//['127.0.0.1', '192.168.16.96', '127.0.0.1', '192.168.16.118'];
        $header = $response->getHeader();
        $content = $response->getContent();
        $this->writeResponse($content);
    }

    function writeResponse($content){
        try{
            $logId = cache('logId');
            $dir = app()->getRuntimePath().'/db_log';
            $sql_path = $dir.'/'.$logId.'.sql';
            $sql = '';
            if(file_exists($sql_path)){
                $sql = file_get_contents($sql_path);
            }
            $data = [];
            $data['response'] = $content;
            $data['sql'] = $sql;
            Db::name('log_request')->where(['id'=>$logId])->update($data);
            unlink($sql_path);
        }catch (\Exception $e){

        }
    }
}
