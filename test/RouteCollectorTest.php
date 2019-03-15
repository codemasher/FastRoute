<?php

namespace FastRouteTest;

use PHPUnit\Framework\TestCase;

class RouteCollectorTest extends TestCase
{
    public function testShortcuts()
    {
        $r = new DummyRouteCollector();

        $r->delete('/delete', 'delete');
        $r->get('/get', 'get');
        $r->head('/head', 'head');
        $r->patch('/patch', 'patch');
        $r->post('/post', 'post');
        $r->put('/put', 'put');
        $r->options('/options', 'options');

        $expected = [
            [['DELETE'], '/delete', 'delete'],
            [['GET'], '/get', 'get'],
            [['HEAD'], '/head', 'head'],
            [['PATCH'], '/patch', 'patch'],
            [['POST'], '/post', 'post'],
            [['PUT'], '/put', 'put'],
            [['OPTIONS'], '/options', 'options'],
        ];

        $this->assertSame($expected, $r->routes);
    }

}

