<?php

namespace NotificationChannels\Messagebird\Test;

use Mockery;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use NotificationChannels\Messagebird\MessagebirdClient;
use NotificationChannels\Messagebird\MessagebirdMessage;

class MessagebirdClientTest extends TestCase
{
    public function setUp(): void
    {
        $this->guzzle = Mockery::mock(new Client());
        $this->client = Mockery::mock(new MessagebirdClient($this->guzzle, 'test_ek1qBbKbHoA20gZHM40RBjxzX'));
        $this->message = (new MessagebirdMessage('Message content'))->setOriginator('APPNAME')->setRecipients('31650520659')->setReference('000123');
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(MessagebirdClient::class, $this->client);
        $this->assertInstanceOf(MessagebirdMessage::class, $this->message);
    }

    /** @test */
    public function it_can_send_message()
    {
        $this->client->shouldReceive('send')->with($this->message)->once();
        $this->assertNull($this->client->send($this->message));
    }
}
