<?php

namespace Tests\Support;

use Illuminate\Contracts\Events\Dispatcher;

class FakeDispatcher implements Dispatcher
{
    public function listen($events, $listener = null)
    {
        // TODO: Implement listen() method.
    }

    public function hasListeners($eventName)
    {
        // TODO: Implement hasListeners() method.
    }

    public function subscribe($subscriber)
    {
        // TODO: Implement subscribe() method.
    }

    public function until($event, $payload = [])
    {
        // TODO: Implement until() method.
    }

    public function dispatch($event, $payload = [], $halt = false)
    {
        // TODO: Implement dispatch() method.
    }

    public function push($event, $payload = [])
    {
        // TODO: Implement push() method.
    }

    public function flush($event)
    {
        // TODO: Implement flush() method.
    }

    public function forget($event)
    {
        // TODO: Implement forget() method.
    }

    public function forgetPushed()
    {
        // TODO: Implement forgetPushed() method.
    }

}