<?php

namespace Tests\FakeTest;

class PostRequest extends FakeMakesHttpRequests
{

    public function testPost(): void
    {
        $this->post('/fake-test/post');
    }

    public function testPostJson(): void
    {
        $this->postJson('/fake-test/post-json');
    }

    # SEND DATA
    
    public function testPostSendData()
    {
        $this->post('/fake-test/post-send-data', ['one' => 'test']);
    }

    public function testPostJsonSendData()
    {
        $this->postJson('/fake-test/post-json-send-data', ['one' => 'test']);
    }

    # SEND DATA AND HEADER
    
    public function testPostSendDataAndHeader()
    {
        $this->post('/fake-test/post-send-data-and-header', ['data' => 'test'], ['header' => ['one' => 1]]);
    }

    public function testPostJsonSendDataAndHeader()
    {
        $this->postJson('/fake-test/post-json-send-data-and-header', ['data' => 'test'], ['header' => ['one' => 1]]);
    }

}
