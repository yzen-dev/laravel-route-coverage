<?php

namespace Tests\FakeTest;

class DeleteRequest extends FakeMakesHttpRequests
{
    public function testDelete(): void
    {
        $this->delete('/fake-test/delete');
    }

    public function testDeleteJson(): void
    {
        $this->deleteJson('/fake-test/delete-json');
    }

    # SEND DATA
    
    public function testDeleteSendData()
    {
        $this->delete('/fake-test/delete-send-data', ['one' => 'test']);
    }

    public function testDeleteJsonSendData()
    {
        $this->deleteJson('/fake-test/delete-json-send-data', ['one' => 'test']);
    }

    # SEND DATA AND HEADER
    public function testDeleteSendDataAndHeader()
    {
        $this->delete('/fake-test/delete-send-data-and-header', ['data' => 'test'], ['header' => ['one' => 1]]);
    }

    public function testDeleteJsonSendDataAndHeader()
    {
        $this->deleteJson('/fake-test/delete-json-send-data-and-header', ['data' => 'test'], ['header' => ['one' => 1]]);
    }

}
