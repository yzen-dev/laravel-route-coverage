<?php

namespace Tests\FakeTest;


class FakeMakesHttpRequests
{

    public function get($uri, array $headers = [])
    {
        return 1;
    }

    public function getJson($uri, array $headers = [])
    {
        return 1;
    }

    public function post($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function postJson($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function put($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function putJson($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function patch($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function patchJson($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function delete($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function deleteJson($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function options($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function optionsJson($uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function json($method, $uri, array $data = [], array $headers = [])
    {
        return 1;
    }

    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        return 1;
    }
}
