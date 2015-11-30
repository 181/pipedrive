<?php

namespace spec\Devio\Pipedrive;

use Devio\Pipedrive\Http\Client;
use Devio\Pipedrive\Http\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Devio\Pipedrive\Request');
    }
    
    public function let(Client $client)
    {
        $this->beConstructedWith($client);
        $this->setToken('foobarbaz');
    }

    public function it_makes_a_request(Client $client, Response $response)
    {
        $content = ['success' => true, 'data' => []];
        $response->getContent()
                 ->shouldBeCalled()
                 ->willReturn((object) $content);
        $response->getStatusCode()
                 ->shouldBeCalled()
                 ->willReturn(200);

        $client->get('https://api.pipedrive.com/v1/foo/1?api_token=foobarbaz', [])
               ->shouldBeCalled()
               ->willReturn($response);
        $client->put('https://api.pipedrive.com/v1/foo/1?api_token=foobarbaz', ['name' => 'bar'])
               ->shouldBeCalled()
               ->willReturn($response);
        $client->post('https://api.pipedrive.com/v1/foo?api_token=foobarbaz', [])
               ->shouldBeCalled()
               ->willReturn($response);

        $this->get('foo/:id', ['id' => 1]);
        $this->put('foo/:id', ['id' => 1, 'name' => 'bar']);
        $this->post('foo', []);
    }
}