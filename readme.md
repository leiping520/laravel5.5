
# 总结laravel5.5的用法

1.创建事件监听器 监听sql的执行情况

###### php artisan make:listener QueryListener --event=Illuminate\Database\Events\QueryExecuted
  
  QueryListener 方法handle
  
    $sql = str_replace("?", "'%s'", $event->sql);
    $log = vsprintf($sql, $event->bindings);
    Log::info($log);
    
  EventServiceProvider 属性$listen
  
    protected $listen = [
            'App\Events\Event' => [
                'App\Listeners\EventListener',
            ],
    
            'Illuminate\Database\Events\QueryExecuted' => [
                'App\Listeners\QueryListener',
                // 新增SqlListener监听QueryExecuted
                'App\Listeners\SqlListener',
            ],
    ];
    
2.安装调试利器laravel Debugbar扩展

###### composer require-dev barryvdh/laravel-debugbar --dev //最新版

   config app.php
    
    'providers' => [
       Barryvdh\Debugbar\ServiceProvider::class,
     ]
    'aliases' => [
       'Debugbar' => Barryvdh\Debugbar\Facade::class,
     ]
     
###### php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider" 发布配置文件
        
     .env  DEBUGBAR_ENABLED=true
     
3.创建command 命令php artisan key:generate 和php artisan cbc:generate
    
    Console/Kernel.php 属性$commands
    
        protected $commands = [
                Commands\AesCbcPassword::class,
                Commands\CbcGenerateCommand::class,
        ];
        
     Console/Commands
     
        AesCbcPassword.php 和 CbcGenerateCommand.php
        








=====================================================================================

# 编译安装xdebug扩展

1.下载xdebug

wget http://www.xdebug.org/files/xdebug-2.3.3.tgz

2.解压缩

tar zxvf xdebug-2.3.3.tgz

3.进入解压缩的目录

cd xdebug-2.3.3

4.建立外挂模块

phpize

5.配置

./configure

6.编译并安装

make && make install

7.在php.ini添加如下配置

zend_extension= xdebug.so所在路径

xdebug.profiler_enable=on#开启性能监控（一般在正式环境不建议开启）

xdebug.trace_output_dir="/usr/local/webserver/php/xdebug_trace"#程序执行顺序日志

xdebug.profiler_output_dir="/usr/local/webserver/php/xdebug_profiler"#程序执行性能日志

8.重启php-fpm

service php-fpm restart    



# lnmp环境日志的设置

    nginx :
    查找nginx日志   whereis nginx.conf  cat nginx.conf  查看日志路径
    
    access.log 记录访问信息  error.log 记录访问错误信息
    
    mysql :
    查找mysql日志   whereis my.cnf  cat my.cnf  查看日志所在路径
    
    mysql日志分为四种
    
    二进制日志：以二进制形式记录了数据库中的操作，但不记录查询操作
    错误日志：记录mysql服务器的启动、关闭和运行错误等信息
    通用日志：记录用户登陆和记录查询的信息
    慢查询日志：记录执行时间超过制定时间的操作 
    
    默认情况下，只启动了错误日志的功能
    
    php :
    查找PHP日志   whereis php.ini cat php.ini  查看日志所在路径
    
    
    