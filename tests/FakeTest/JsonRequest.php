<?php

namespace Tests\FakeTest;

class JsonRequest extends FakeMakesHttpRequests
{
    # BASE CALL
    public function testJsonArgGet(): void
    {
        $this->json('GET', '/fake-test/json-arg-get');
    }

    public function testJsonArgPost(): void
    {
        $this->json('POST', '/fake-test/json-arg-post');
    }

    public function testJsonArgPut(): void
    {
        $this->json('PUT', '/fake-test/json-arg-put');
    }

    public function testJsonArgPatch(): void
    {
        $this->json('PATCH', '/fake-test/json-arg-patch');
    }

    public function testJsonArgDelete(): void
    {
        $this->json('DELETE', '/fake-test/json-arg-delete');
    }

    # SEND DATA

    public function testJsonArgGetSendData(): void
    {
        $this->json('GET', '/fake-test/json-arg-get', ['one' => 'test']);
    }

    public function testJsonArgPostSendData(): void
    {
        $this->json('POST', '/fake-test/json-arg-post', ['one' => 'test']);
    }

    public function testJsonArgPutSendData(): void
    {
        $this->json('PUT', '/fake-test/json-arg-put', ['one' => 'test']);
    }

    public function testJsonArgPatchSendData(): void
    {
        $this->json('PATCH', '/fake-test/json-arg-patch', ['one' => 'test']);
    }

    public function testJsonArgDeleteSendData(): void
    {
        $this->json('DELETE', '/fake-test/json-arg-delete', ['one' => 'test']);
    }

    # SEND DATA AND HEADER

    public function testJsonArgGetSendDataAndHeader(): void
    {
        $this->json('GET', '/fake-test/json-arg-get', ['one' => 'test'], ['header' => ['one' => 1]]);
    }

    public function testJsonArgPostSendDataAndHeader(): void
    {
        $this->json('POST', '/fake-test/json-arg-post', ['one' => 'test'], ['header' => ['one' => 1]]);
    }

    public function testJsonArgPutSendDataAndHeader(): void
    {
        $this->json('PUT', '/fake-test/json-arg-put', ['one' => 'test'], ['header' => ['one' => 1]]);
    }

    public function testJsonArgPatchSendDataAndHeader(): void
    {
        $this->json('PATCH', '/fake-test/json-arg-patch', ['one' => 'test'], ['header' => ['one' => 1]]);
    }

    public function testJsonArgDeleteSendDataAndHeader(): void
    {
        $this->json('DELETE', '/fake-test/json-arg-delete', ['one' => 'test'], ['header' => ['one' => 1]]);
    }
}
