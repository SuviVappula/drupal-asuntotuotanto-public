<?php

if (PHP_SAPI === 'cli') {
  ini_set('memory_limit', '512M');
}

if ($simpletest_db = getenv('SIMPLETEST_DB')) {
  $parts = parse_url($simpletest_db);
  putenv(sprintf('DRUPAL_DB_NAME=%s', substr($parts['path'], 1)));
  putenv(sprintf('DRUPAL_DB_USER=%s', $parts['user']));
  putenv(sprintf('DRUPAL_DB_PASS=%s', $parts['pass']));
  putenv(sprintf('DRUPAL_DB_HOST=%s', $parts['host']));
}

$databases['default']['default'] = [
  'database' => getenv('DRUPAL_DB_NAME'),
  'username' => getenv('DRUPAL_DB_USER'),
  'password' => getenv('DRUPAL_DB_PASS'),
  'prefix' => '',
  'host' => getenv('DRUPAL_DB_HOST'),
  'port' => getenv('DRUPAL_DB_PORT') ?: 3306,
  'namespace' => 'Drupal\Core\Database\Driver\mysql',
  'driver' => 'mysql',
];

if ($ssl_ca_path = getenv('AZURE_SQL_SSL_CA_PATH')) {
  $databases['default']['default']['pdo'] = [
    \PDO::MYSQL_ATTR_SSL_CA => $ssl_ca_path,
    \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => FALSE,
  ];
}

// Only in Wodby environment.
// @see https://wodby.com/docs/stacks/drupal/#overriding-settings-from-wodbysettingsphp
if (isset($_SERVER['WODBY_APP_NAME'])) {
  // The include won't be added automatically if it's already there.
  include '/var/www/conf/wodby.settings.php';
}

$settings['hash_salt'] = getenv('DRUPAL_HASH_SALT') ?: '000';

$config['openid_connect.settings.tunnistamo']['settings']['client_id'] = getenv('TUNNISTAMO_CLIENT_ID');
$config['openid_connect.settings.tunnistamo']['settings']['client_secret'] = getenv('TUNNISTAMO_CLIENT_SECRET');
// Drupal route(s).
$routes = (getenv('DRUPAL_ROUTES')) ? explode(',', getenv('DRUPAL_ROUTES')) : [];

foreach ($routes as $route) {
  $hosts[] = $host = parse_url($route)['host'];
  $trusted_host = str_replace('.', '\.', $host);
  $settings['trusted_host_patterns'][] = '^' . $trusted_host . '$';
}

$drush_options_uri = getenv('DRUSH_OPTIONS_URI');

if ($drush_options_uri && !in_array($drush_options_uri, $routes)) {
  $host = str_replace('.', '\.', parse_url($drush_options_uri)['host']);
  $settings['trusted_host_patterns'][] = '^' . $host . '$';
}

$settings['config_sync_directory'] = '../conf/cmi';
$settings['file_public_path'] = getenv('DRUPAL_FILES_PUBLIC') ?: 'sites/default/files';
$settings['file_private_path'] = getenv('DRUPAL_FILES_PRIVATE');
$settings['file_temp_path'] = getenv('DRUPAL_TMP_PATH') ?: '/tmp';

if ($reverse_proxy_address = getenv('DRUPAL_REVERSE_PROXY_ADDRESS')) {
  $reverse_proxy_address = explode(',', $reverse_proxy_address);

  if (isset($_SERVER['REMOTE_ADDR'])) {
    $reverse_proxy_address[] = $_SERVER['REMOTE_ADDR'];
  }
  $settings['reverse_proxy'] = TRUE;
  $settings['reverse_proxy_addresses'] = $reverse_proxy_address;
  $settings['reverse_proxy_trusted_headers'] = \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_ALL;
}

if ($env = getenv('APP_ENV')) {
  if (file_exists(__DIR__ . '/' . $env . '.settings.php')) {
    include __DIR__ . '/' . $env . '.settings.php';
  }

  if (file_exists(__DIR__ . '/' . $env . '.services.yml')) {
    $settings['container_yamls'][] = __DIR__ . '/' . $env . '.services.yml';
  }

  if (file_exists(__DIR__ . '/local.services.yml')) {
    $settings['container_yamls'][] = __DIR__ . '/local.services.yml';
  }

  if (file_exists(__DIR__ . '/local.settings.php')) {
    include __DIR__ . '/local.settings.php';
  }
}

if ($env = getenv('APP_ENV')) {
  $config['user.settings']['notify']['register_no_approval_required'] = FALSE;

  // Default settings for most environments.
  $settings['backend_url'] = getenv('ASU_DJANGO_BACKEND_ADDRESS');
  $settings['elastic_url'] = getenv('ASU_ELASTICSEARCH_ADDRESS');
  $config['mailsystem.settings']['defaults']['sender'] = 'swiftmailer';
  $config['mailsystem.settings']['defaults']['formatter'] = 'swiftmailer';
  $config['swiftmailer.transport']['smtp_host'] = getenv('ASU_MAILSERVER_ADDRESS') ?? '10.232.13.1';
  $config['swiftmailer.transport']['smtp_port'] = getenv('ASU_MAILSERVER_PORT') ?? '25';
  $config['swiftmailer.transport']['transport'] = getenv('ASU_MAILSERVER_TRANSPORT') ?? 'smtp';
  $config['swiftmailer.transport']['smtp_encryption'] = '0';

  $settings['asuntotuotanto_url'] = getenv('ASU_ASUNTOTUOTANTO_ADDRESS');
  $config['elasticsearch_connector.cluster.asuntotuotanto']['url'] = getenv('ASU_ELASTICSEARCH_ADDRESS');

  $config['external_entities.external_entity_type.project']['storage_client_config']['endpoint'] = getenv('ASU_ASUNTOTUOTANTO_ADDRESS');
  $config['external_entities.external_entity_type.apartment']['storage_client_config']['endpoint'] = getenv('ASU_ASUNTOTUOTANTO_ADDRESS');

  if ($env === 'dev') {
    // Local development environment.
    $config['mailsystem.settings']['defaults']['sender'] = 'swiftmailer';
    $config['mailsystem.settings']['defaults']['formatter'] = 'swiftmailer';
    $config['swiftmailer.transport']['transport'] = 'smtp';
    $config['swiftmailer.transport']['smtp_host'] = 'mailhog';
    $config['swiftmailer.transport']['smtp_port'] = '1025';
    $config['swiftmailer.transport']['smtp_encryption'] = '0';

    $settings['asuntotuotanto_url'] = 'https://asuntotuotanto.docker.so';
    $config['elasticsearch_connector.cluster.asuntotuotanto']['url'] = 'http://elastic:9200';

  }
}
