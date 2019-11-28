<?php

namespace tlog\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Db;

/**
 * 发布配置文件、迁移文件指令
 */
class Publish extends Command
{
    /**
     * 配置指令
     */
    protected function configure()
    {
        $this->setName('tlog:publish')->setDescription('Publish tlog');
    }

    /**
     * 执行指令
     * @param Input  $input
     * @param Output $output
     * @return null|int
     * @throws LogicException
     * @see setCode()
     */
    protected function execute(Input $input, Output $output)
    {
        echo "开始执行建表命令 \n";
        $default = config('database.default');
        $config = config("database.connections.{$default}");
        $prefix = $config['prefix'];

        $sql ="

CREATE TABLE `{$prefix}log_curl` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号---sort',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id--取cookie必须可以为null',
  `url` varchar(1024) NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '',
  `detail` longtext CHARACTER SET utf8mb4 NOT NULL COMMENT '详情|0',
  `user_agent` text NOT NULL COMMENT '浏览器|0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `params` longtext NOT NULL COMMENT '参数|0',
  `method` char(6) NOT NULL DEFAULT '' COMMENT '请求方式',
  `cookie` varchar(1000) NOT NULL DEFAULT '' COMMENT 'cookie|0',
  `response` longtext CHARACTER SET utf8mb4 COMMENT '返回内容|0',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间|0',
  `rinse_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数据清洗状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='curl请求日志表';
";
        Db::query($sql);

        //DROP TABLE IF EXISTS `log_request`;
        $sql ="

CREATE TABLE `{$prefix}log_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号---sort',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id--取cookie必须可以为null',
  `url` varchar(1024) NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '',
  `detail` longtext CHARACTER SET utf8mb4 NOT NULL COMMENT '详情|0',
  `user_agent` text NOT NULL COMMENT '浏览器|0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `params` longtext NOT NULL COMMENT '参数|0',
  `method` char(6) NOT NULL DEFAULT '' COMMENT '请求方式',
  `cookie` varchar(1000) NOT NULL DEFAULT '' COMMENT 'cookie|0',
  `response` longtext CHARACTER SET utf8mb4 COMMENT '返回内容|0',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间|0',
  `rinse_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数据清洗状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='访问日志表';
        ";
        Db::query($sql);

        echo "建表结束 \n";
    }
}

