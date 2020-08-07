<?php

/**
 * @file
 * Load settings from environment variables.
 * @see /.env.example
 */

if (!getenv('MYSQL_DATABASE')) {
  return;
}

$databases['default']['default'] = [
  'driver' => 'mysql',
  'database' => getenv('MYSQL_DATABASE'),
  'username' => getenv('MYSQL_USER'),
  'password' => getenv('MYSQL_PASSWORD'),
  'host' => getenv('MYSQL_HOSTNAME'),
  'port' => getenv('MYSQL_PORT') ?: '',
];

if (getenv('HASH_SALT')) {
  $settings['hash_salt'] = getenv('HASH_SALT');
}
