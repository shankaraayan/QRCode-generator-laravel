<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected Client $client;
    protected string $from;

    function __construct()
    {
        $config = config('sms.gateway.twilio');

        $this->client = new Client($config['sid'], $config['token']);
        $this->from = $config['from'];
    }

    public function send(string $recipient, string $body): bool
    {
        try {
            $this->client->messages->create(
                "+91$recipient",
                ['from' => $this->from, 'from', 'body' => $body]
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
