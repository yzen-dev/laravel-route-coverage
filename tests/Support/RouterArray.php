<?php

namespace Tests\Support;

use Illuminate\Routing\Router;

class RouterArray
{
    public static array $routes = [
        # POST REQUESTS
        
        [
            "url" => "fake-test/post",
            "method" => "POST",
            "controller" => 'App\\Http\\Controller\\PostController@post'
        ],
        [
            "url" => "fake-test/post-json",
            "method" => "POST",
            "controller" => 'App\\Http\\Controller\\PostController@post'
        ],
        [
            "url" => "fake-test/post-send-data",
            "method" => "POST",
            "controller" => 'App\\Http\\Controller\\PostController@post'
        ],
        [
            "url" => "fake-test/post-json-send-data",
            "method" => "POST",
            "controller" => 'App\\Http\\Controller\\PostController@post'
        ],
        [
            "url" => "fake-test/post-send-data-and-header",
            "method" => "POST",
            "controller" => 'App\\Http\\Controller\\PostController@post'
        ],
        [
            "url" => "fake-test/post-json-send-data-and-header",
            "method" => "POST",
            "controller" => 'App\\Http\\Controller\\PostController@post'
        ],
        
        # GET REQUESTS

        [
            "url" => "fake-test/get",
            "method" => "GET",
            "controller" => 'App\\Http\\Controller\\GetController@get'
        ],
        [
            "url" => "fake-test/get-json",
            "method" => "GET",
            "controller" => 'App\\Http\\Controller\\GetController@get'
        ],
        [
            "url" => "fake-test/get-send-data",
            "method" => "GET",
            "controller" => 'App\\Http\\Controller\\GetController@get'
        ],
        [
            "url" => "fake-test/get-json-send-data",
            "method" => "GET",
            "controller" => 'App\\Http\\Controller\\GetController@get'
        ],
        
        # DELETE REQUESTS
        
        [
            "url" => "fake-test/delete",
            "method" => "DELETE",
            "controller" => 'App\\Http\\Controller\\DeleteController@delete'
        ],
        [
            "url" => "fake-test/delete-json",
            "method" => "DELETE",
            "controller" => 'App\\Http\\Controller\\DeleteController@delete'
        ],
        [
            "url" => "fake-test/delete-send-data",
            "method" => "DELETE",
            "controller" => 'App\\Http\\Controller\\DeleteController@delete'
        ],
        [
            "url" => "fake-test/delete-json-send-data",
            "method" => "DELETE",
            "controller" => 'App\\Http\\Controller\\DeleteController@delete'
        ],
        [
            "url" => "fake-test/delete-send-data-and-header",
            "method" => "DELETE",
            "controller" => 'App\\Http\\Controller\\DeleteController@delete'
        ],
        [
            "url" => "fake-test/delete-json-send-data-and-header",
            "method" => "DELETE",
            "controller" => 'App\\Http\\Controller\\DeleteController@delete'
        ],
        
        # PATCH REQUESTS
        
        [
            "url" => "fake-test/path",
            "method" => "PATCH",
            "controller" => 'App\\Http\\Controller\\PatchController@patch'
        ],
        [
            "url" => "fake-test/patch-json",
            "method" => "PATCH",
            "controller" => 'App\\Http\\Controller\\PatchController@patch'
        ],
        [
            "url" => "fake-test/patch-send-data",
            "method" => "PATCH",
            "controller" => 'App\\Http\\Controller\\PatchController@patch'
        ],
        [
            "url" => "fake-test/patch-json-send-data",
            "method" => "PATCH",
            "controller" => 'App\\Http\\Controller\\PatchController@patch'
        ],
        [
            "url" => "fake-test/patch-send-data-and-header",
            "method" => "PATCH",
            "controller" => 'App\\Http\\Controller\\PatchController@patch'
        ],
        [
            "url" => "fake-test/patch-json-send-data-and-header",
            "method" => "PATCH",
            "controller" => 'App\\Http\\Controller\\PatchController@patch'
        ],

        # PUT REQUESTS
        [
            "url" => "fake-test/put",
            "method" => "PUT",
            "controller" => 'App\\Http\\Controller\\PutController@put'
        ],
        [
            "url" => "fake-test/put-json",
            "method" => "PUT",
            "controller" => 'App\\Http\\Controller\\PutController@put'
        ],
        [
            "url" => "fake-test/put-send-data",
            "method" => "PUT",
            "controller" => 'App\\Http\\Controller\\PutController@put'
        ],
        [
            "url" => "fake-test/put-json-send-data",
            "method" => "PUT",
            "controller" => 'App\\Http\\Controller\\PutController@put'
        ],
        [
            "url" => "fake-test/put-send-data-and-header",
            "method" => "PUT",
            "controller" => 'App\\Http\\Controller\\PutController@put'
        ],
        [
            "url" => "fake-test/put-json-send-data-and-header",
            "method" => "PUT",
            "controller" => 'App\\Http\\Controller\\PutController@put'
        ],

        # JSON REQUESTS

        [
            "url" => "fake-test/json-arg-post",
            "method" => "POST",
            "controller" => 'App\\Http\\Controller\\PostController@post'
        ],
        [
            "url" => "fake-test/json-arg-post",
            "method" => "POST",
            "controller" => 'App\\Http\\Controller\\PostController@post'
        ],
        [
            "url" => "fake-test/json-arg-post",
            "method" => "POST",
            "controller" => 'App\\Http\\Controller\\PostController@post'
        ],
        [
            "url" => "fake-test/json-arg-get",
            "method" => "GET",
            "controller" => 'App\\Http\\Controller\\GetController@get'
        ],
        [
            "url" => "fake-test/json-arg-get",
            "method" => "GET",
            "controller" => 'App\\Http\\Controller\\GetController@get'
        ],
        [
            "url" => "fake-test/json-arg-get",
            "method" => "GET",
            "controller" => 'App\\Http\\Controller\\GetController@get'
        ],
        [
            "url" => "fake-test/json-arg-patch",
            "method" => "PATCH",
            "controller" => 'App\\Http\\Controller\\PatchController@patch'
        ],
        [
            "url" => "fake-test/json-arg-patch",
            "method" => "PATCH",
            "controller" => 'App\\Http\\Controller\\PatchController@patch'
        ],
        [
            "url" => "fake-test/json-arg-patch",
            "method" => "PATCH",
            "controller" => 'App\\Http\\Controller\\PatchController@patch'
        ],
        [
            "url" => "fake-test/json-arg-put",
            "method" => "PUT",
            "controller" => 'App\\Http\\Controller\\PutController@put'
        ],
        [
            "url" => "fake-test/json-arg-put",
            "method" => "PUT",
            "controller" => 'App\\Http\\Controller\\PutController@put'
        ],
        [
            "url" => "fake-test/json-arg-put",
            "method" => "PUT",
            "controller" => 'App\\Http\\Controller\\PutController@put'
        ],
        [
            "url" => "fake-test/json-arg-delete",
            "method" => "DELETE",
            "controller" => 'App\\Http\\Controller\\DeleteController@delete'
        ],
        [
            "url" => "fake-test/json-arg-delete",
            "method" => "DELETE",
            "controller" => 'App\\Http\\Controller\\DeleteController@delete'
        ],
        [
            "url" => "fake-test/json-arg-delete",
            "method" => "DELETE",
            "controller" => 'App\\Http\\Controller\\DeleteController@delete'
        ],
    ];
}
