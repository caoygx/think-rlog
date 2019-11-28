<?php
namespace tlog;


use think\Service;
use tlog\command\Publish;

/**
 * TlogService service
 */
class TlogService extends Service
{
    /**
     * Register service
     *
     * @return void
     */
    public function register()
    {
        // 注册数据迁移服务
        //$this->app->register(\think\migration\Service::class);
    }

    /**
     * Boot function
     *
     * @return void
     */
    public function boot()
    {
        $this->commands(['tlog:publish' => Publish::class]);
    }

}