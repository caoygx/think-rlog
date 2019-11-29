<h1 align="center">
    ThinkPHP 6.0 rlog
</h1>

<p align="center">
	<strong>think-rlog 是一个专为ThinkPHP6.0打造的请求日志记录工具</strong>    
</p>


## 使用方法

1. 使用`composer`安装库：

```
composer require rrbrr/tlog
```

2. 注册服务，在应用的全局公共文件service.php中加入：

```php
return [
    // ...

    tlog\tlogService::class,
];
```

3. 建立日志存储表：

```
php think tlog:publish
```

这将自动生成 `log_request` 和 `log_curl` 表。



4. 添加事件监听,在应用全局事件文件event.php中加入

```php

    'listen' => [
        'AppInit' => [
            'tlog\listener\WriteRequestLog'
        ],
    ]

```

## 其它
配置文件 app.php
[
    'rlog'=>[
        'white_list'=>'127.0.0.1','192.168.1.8' //指定需要记录请求信息的ip
    ]
] 




