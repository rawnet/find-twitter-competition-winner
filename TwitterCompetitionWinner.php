<?php

require "vendor/autoload.php";

require "top_secret.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);


//$statuses = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);

$hashtag = '#rawnet';
$winningString = 'symfony';

$statuses = $connection->get("search/tweets", ["count" => 100,"q" => $hashtag]);
var_dump($statuses);

// TODO check total counter
$tweets = $statuses->statuses;

$potentialWinners = [];
foreach ($tweets as $tweet) {
	
	if (strpos($tweet->text, $winningString) !== false) {
		
		
		$potentialWinners[] = $tweet->user->name;
		$potentiallyWinningTweet[$tweet->user->name][] = $tweet;
	}
	
}

$potentialWinners = array_unique($potentialWinners);
$winner = $potentialWinners[mt_rand(0, count($potentialWinners) - 1)];
echo "The winner is $winner".PHP_EOL;
$winningTweet = $potentiallyWinningTweet[$winner][mt_rand(0, count($potentiallyWinningTweet[$winner]) - 1)]->text;
echo "Winning tweet: $winningTweet";