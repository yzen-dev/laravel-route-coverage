<?php

namespace Tests\FakeTest;

class PatchRequest extends FakeMakesHttpRequests
{

    public function testPath(): void
    {
        $this->patch('/fake-test/path');
    }

    public function testPatchJson(): void
    {
        $this->patchJson('/fake-test/patch-json');
    }

    # SEND DATA

    public function testPatchSendData()
    {
        $this->patch('/fake-test/patch-send-data', ['one' => 'test']);
    }

    public function testPatchJsonSendData()
    {
        $this->patchJson('/fake-test/patch-json-send-data', ['one' => 'test']);
    }

    # SEND DATA AND HEADER
    
    public function testPatchSendDataAndHeader()
    {
        $this->patch('/fake-test/patch-send-data-and-header', ['data' => 'test'], ['header' => ['one' => 1]]);
    }

    public function testPatchJsonSendDataAndHeader()
    {
        $this->patchJson('/fake-test/patch-json-send-data-and-header', ['data' => 'test'], ['header' => ['one' => 1]]);
    }
}
