<?php

use Spatie\TwitterStreamingApi\PublicStream;
use DG\Twitter\Twitter;

require_once('vendor/autoload.php');
require('config.php');
@mkdir(__DIR__.DIRECTORY_SEPARATOR.'tweets');

// Twitter API
$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

// Connect to twitter Streaming API
PublicStream::create(
    $accessToken,
    $accessTokenSecret,
    $consumerKey,
    $consumerSecret
)->whenHears('@TarteebTest', function(array $tweet) use($twitter) {
	$name = $tweet['user']['screen_name'] ?? null;
    echo "We got mentioned by {$name} who tweeted something".PHP_EOL;
    handle($twitter, $tweet['in_reply_to_status_id_str'], $tweet['in_reply_to_screen_name']);
})->startListening();


function handle($twitter, $tweetId, $screenName) {
    $lastTweet = $tweetId;

    $list = [];
    $list[] = $twitter->request('/statuses/show/'.$tweetId, 'GET',['tweet_mode' => 'extended']);

    $tweets = $twitter->request('/statuses/user_timeline.json?tweet_mode=extended&count=100&screen_name='.$screenName.'&since_id='.$tweetId,'GET');
    foreach (array_reverse($tweets) as $tweet) {
        if($lastTweet !=  $tweet->in_reply_to_status_id_str) break;
        $list[] = $tweet;
        $lastTweet = $tweet->id_str;
    }

    foreach($list as $tweet) {
        dump('Reply to: '. $tweet->in_reply_to_status_id_str . ' - text: '.$tweet->full_text);
    }

    $text = array_map(fn($tweet) => preg_replace('#https:\/\/(.*?)\/(.*?)$#','',$tweet->full_text), $list);
    file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'tweets'.DIRECTORY_SEPARATOR.$tweetId.'.text', implode("\n", $text));
}