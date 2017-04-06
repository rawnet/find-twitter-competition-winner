<?php

require "vendor/autoload.php";

require "top_secret.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

$winningStrings = ['Winning String1 ', 'Winning string2'];
$q = '@rawnet';

$statuses = $connection->get("search/tweets", ["count" => 100,"q" => $q]);

$tweets = $statuses->statuses;

$potentialWinners = [];
foreach ($tweets as $tweet) {

    foreach ($winningStrings as $winningString) {
        if (strpos($tweet->text, $winningString) !== false) {
            $potentialWinners[] = $tweet->user->name;
            $potentiallyWinningTweet[$tweet->user->name][] = $tweet;
            break;
        }
    }
}

$potentialWinners = array_unique($potentialWinners);
echo <<<EOL
RAWNET PHP TWITTER TAKEOVER COMPETITION WINNER SELECTOR

EOL;
if (empty($potentialWinners)) {
    echo "No Winners!";
    exit(0);
}
$winner = $potentialWinners[mt_rand(0, count($potentialWinners) - 1)];
echo "The winner is $winner".PHP_EOL;
$winningTweet = $potentiallyWinningTweet[$winner][mt_rand(0, count($potentiallyWinningTweet[$winner]) - 1)]->text;
echo "Winning tweet: $winningTweet";