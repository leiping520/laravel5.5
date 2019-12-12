
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
        
4.关于在laravel中的事件、监听的使用
    
    Laravel 有一个事件系统，事件类所在位置为app/Events，监听事件类所在位置为app/Listeners。
    当你运行Artisan控制台命令时会自动给你创建。
    
    第一步、事件与监听器的注册
        我们要找到EventServiceProvider.php的listens属性进行一些配置
        
    第二步、创建事件类与监听器类 
        php artisan event:generate
    
    第三步、触发事件
    
        可以在控制器、模型中调用事件类
        use App\Events\Ceshi
        
        再 event(new Ceshi($data))

5.自定义服务提供者
    
    第一步、创建服务提供者
    
    php artisan make:provider WeatherServiceProvider 即在app/Providers目录下创建了WeatherServiceProvider
    
    第二步、注册
    
    在config/app.php中注册服务提供者,在providers数组中将创建的服务提供者 App\Providers\WeatherServiceProvider::class写入
    
    第三步、创建契约
    
    在app目录下新建Contracts目录用以存放契约文件
    在app/Contracts目录下创建契约,即Weather.php接口文件。在接口中只定义了public function getWeather($cityName); 一个方法用于获取天气信息.
   
    第四步、实现契约
    
    在app目录下新建Service/Weather目录用于存放实现Weather.php契约的文件
    最终创建的文件是app/Service/Weather/Xinzhi.php。继承了Weather.php接口文件,所有要实现getWeather方法
    
    第五步、服务提供者绑定
    
    在WeatherServiceProvider中的register方法添加以下代码
    
    $this->app->bind('App\Contracts\Weather', function() {
        return new Xinzhi();
    });
    
    第六步、使用
    
    控制器中引入 use App\Contracts\Weather


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

./configure --prefix=/usr/local/xxx  配置安装路径

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
    
    error_log 错误日志的生成目录
    error_reporting 生产环境错误级别应全开
    display_errors 在页面上不显示错误
    log_errors 开启错误日志
    
    error_log = /var/log/php_error.log
    display_errors = Off
    error_reporting = E_ALL
    log_errors = On
 
 
 # 记录日志的方法
     /**
      * @param $dir 日志所在目录
      * @param $filename 日志文件
      * @param $log 日志内容
     */
   
     function writeLog(~~$dir~~,$filename,$log)
     {
         if (!file_exists($dir)) is_dir($dir)or (dirname($dir))and mkdir($dir,0777);
         $dir .= $filename;
         $h= fopen($dir,'a');//文件追加
         $time= date('Y-m-d H:i:s',time());
         $start="time:".$time."\r\n"."---------- content start ----------"."\r\n";
         $end="\r\n"."---------- content end ----------"."\r\n\n";
         $content=$start."".$log."".$end;
         fwrite($h, $content);
         fclose($h);
     }