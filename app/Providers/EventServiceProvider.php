<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        //注册事件和监听
        'App\Events\Ceshi' => [
            'App\Listeners\CeshiRecord'
        ],

        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],

        'Illuminate\Database\Events\QueryExecuted' => [
            'App\Listeners\QueryListener',
            // 新增SqlListener监听QueryExecuted
//            'App\Listeners\SqlListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
