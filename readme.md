
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
    //            'App\Listeners\SqlListener',
            ],
    ];