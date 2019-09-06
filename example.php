<?php

require 'vendor/autoload.php';

use Etutorium\Client;

$c = new Client([
    'endPoint' => 'https://api.etutorium.com',
    'apiToken' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
]);


try {

    print_r($c->getMyAccount());

    print_r($c->createWebinar([
        'title' => 'api test',
        'timezone' => 'Europe/Kiev',
        'start_time' => '2017-01-24 20:00:00',
        'finish_time' => '2017-01-24 22:00:00',
        'language' => 'ua',
        'quick_signup' => 'NONE',
        'chat_enabled' => 1,
        'customized_email' => 0,
        'public_chat' => 0,
        'show_participant_tab' => 0,
        'show_participant_count' => 0,
        'stream_places' => 1,
        'archive_access' => 'NONE',
        'enable_ask_question' => 0
    ]));

    print_r($c->getWebinar(13144));

    print_r($c->getUserLink(13144, 'test@test.me'));
    print_r($c->getUserLink(13144, 'test2@test.me'));
    print_r($c->addUser(13144, 'test2@test.me', 'Test 2'));

} catch (\Exception $ex) {
    print_r($ex);
}
