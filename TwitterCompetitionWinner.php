<?php

require "vendor/autoload.php";

require "top_secret.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

$count = 100;
$winningStrings = ['Winning string1', 'Winning string2'];
$q = '@rawnet';
$sinceId = '849918275781877760';
$maxId = '949918275781877760'; // Set an arbitrarily high max id

$tweets = [];
$noOfTweets = 0;
do {
    $statuses = $connection->get("search/tweets", ["count" => $count,"q" => $q, "since_id" => $sinceId, 'max_id' => $maxId]);

    $countOfTweetsReturned = count($statuses->statuses);
    $maxId = $statuses->statuses[$countOfTweetsReturned-1]->id;
    $tweets = array_merge($tweets, $statuses->statuses);
    $noOfTweets += $countOfTweetsReturned;
} while ($countOfTweetsReturned === $count);

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
$noOfPotetenialWinners = count($potentialWinners);
echo <<<EOL
RAWNET PHP TWITTER TAKEOVER COMPETITION WINNER SELECTOR

{$noOfTweets} tweets received.
{$noOfPotetenialWinners} correct answers.

And....

EOL;
if (empty($potentialWinners)) {
    echo "No Winners!";
    exit(0);
}
$winner = $potentialWinners[mt_rand(0, count($potentialWinners) - 1)];
echo "The winner is $winner".PHP_EOL;
$winningTweet = $potentiallyWinningTweet[$winner][mt_rand(0, count($potentiallyWinningTweet[$winner]) - 1)];
echo "Winning tweet: '$winningTweet->text' sent at $winningTweet->created_at";