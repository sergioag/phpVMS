<?php

include dirname(__FILE__).'/bootstrap.inc.php';

echo '<pre>';

Config::set('TWITTER_AIRLINE_ACCOUNT', 'nabeels');

ActivityData::readTwitter();