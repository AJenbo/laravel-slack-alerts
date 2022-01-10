<?php

use Illuminate\Support\Facades\Bus;
use Spatie\SlackLogger\Exceptions\InvalidUrl;
use Spatie\SlackLogger\Facades\Slack;
use Spatie\SlackLogger\Jobs\SendToSlackChannelJob;

beforeEach(function() {
    Bus::fake();
});

it('can dispatch a job', function () {
    config()->set('slack-logger.webhook_url', 'https://test-domain.com');

    Slack::display('test-data');

    Bus::assertDispatched(SendToSlackChannelJob::class);
});

it('cannot dispatch a job with an invalid webhook url', function () {
    config()->set('slack-logger.webhook_url', '');

    $this->expectException(InvalidUrl::class);

    Slack::display('test-data');

    Bus::assertNothingDispatched();
});