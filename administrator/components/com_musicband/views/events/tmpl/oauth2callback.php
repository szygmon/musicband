<?php

require_once JPATH_ROOT . '/media/com_musicband/google-calendar/vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('882932249847-t2q16g98a913v9m4vjvakcuter77c8pb.apps.googleusercontent.com');
$client->setClientSecret('slTLxY2LsGR1Nqx6D-y788yK');
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/administrator/index.php?option=com_musicband&view=events&layout=oauth2callback');
$client->setState(strtr(base64_encode(JFactory::getApplication()->input->get('cid')), '+/=', '-_,'));


if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $session = JFactory::getSession();
    $session->set('google_access_token', $client->getAccessToken());
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/administrator/index.php?option=com_musicband&view=events&google=ok&cid='.base64_decode(strtr(JFactory::getApplication()->input->get('state'), '-_,', '+/='));
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}