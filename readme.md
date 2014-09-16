## Laravel based Slack Spotify to Youtube Bot

This bot will take messages from an incoming channel and where a Spotify link
has been shared, it will search Youtube and return the top video for the
artist and song name so that those who don't use Spotify can still go to see
the video.

It uses a combination of the Slack API, Spotify API and Youtube API.

You'll need to grab an access key from Youtube to use this and set up an
environment configuration file like such?

    <?php

    return array(

        'YOUTUBE_KEY'   => '<insert key here>',
        'SLACK_WEBHOOK' => 'https://you.slack.com/services/hooks/incoming-webhook?token=your_token_here'

    );


