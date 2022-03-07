<?php

namespace Tests\FakeTest;

class PutRequest extends FakeMakesHttpRequests
{

    public function testPut(): void
    {
        $this->put('/fake-test/put');
    }

    public function testPutJson(): void
    {
        $this->putJson('/fake-test/put-json');
    }

    # SEND DATA

    public function testPutSendData()
    {
        $this->put('/fake-test/put-send-data', ['one' => 'test']);
    }

    public function testPutJsonSendData()
    {
        $this->putJson('/fake-test/put-json-send-data', ['one' => 'test']);
    }

    # SEND DATA AND HEADER
    
    public function testPutSendDataAndHeader()
    {
        $this->put('/fake-test/put-send-data-and-header', ['data' => 'test'], ['header' => ['one' => 1]]);
    }

    public function testPutJsonSendDataAndHeader()
    {
        $this->putJson('/fake-test/put-json-send-data-and-header', ['data' => 'test'], ['header' => ['one' => 1]]);
    }
}
