# find-twitter-competition-winner

Create Twitter Developer Account and get oauth keys.

Create file `top_secret.php` with your variables.
```php
<?php
//top_secret.php
$consumerKey = CONSUMER_KEY;
$consumerSecret = CONSUMER_SECRET;
$accessToken = ACCESS_TOKEN;
$accessTokenSecret = ACCESS_TOKEN_SECRET;
```

Install the application dependencies:
```bash
composer install
```
Find the competition winner:
```
php TwitterCompetitionWinner.php
```