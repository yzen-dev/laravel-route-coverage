<?php

namespace Tests\FakeTest;

class GetRequest extends FakeMakesHttpRequests
{

    public function testGet(): void
    {
        $this->get('/fake-test/get');
    }

    public function testGetJson(): void
    {
        $this->getJson('/fake-test/get-json');
    }
    
    # SEND DATA

    public function testGetSendData()
    {
        $this->get('/fake-test/get-send-data', ['one' => 'test']);
    }

    public function testGetJsonSendData()
    {
        $this->getJson('/fake-test/get-json-send-data', ['one' => 'test']);
    }
}
