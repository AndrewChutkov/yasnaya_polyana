<?php
include 'buttons.php';

$data = json_decode(file_get_contents('php://input'),true);
$text = $data['message']['text'];
$callback_data = $data['callback_query']['data'];

file_put_contents( 'file.txt', print_r($data, true), FILE_APPEND);

define('TOKEN', '5321936652:AAHBPPNuWkiTr__ulhFi7Jr4b-fZAL5wKG8');

// Функция вызова методов API
function sendTelegram($method, $response)
{
    $ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);

    return $res;
}

switch ($text) {
    //******************** СТАРТОВЫЙ ЭКРАН **************************
    case '/start';
    case 'Назад':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/start.txt'),
                'reply_markup' => json_encode([
                    'resize_keyboard' => true,
                    'keyboard' => [
                        [
                            ['text' => $schedule]
                        ],
                        [
                            ['text' => $buy_ticket]
                        ],
                        [
                            ['text' => $audio_guide]
                        ],
                        [
                            ['text' => $price]
                        ],
                        [
                            ['text' => $affiche]
                        ],
                        [
                            ['text' => $contacts]
                        ],
                        [
                            ['text' => $social_network]
                        ],
                        [
                            ['text' => $special_projects]
                        ],
                        [
                            ['text' => $branches]
                        ],
                        [
                            ['text' => $get_there]
                        ],
                        [
                            ['text' => $children]
                        ],
                        [
                            ['text' => $shn]
                        ],
                    ]
                ])
            )
        );
        break;

    case $schedule:
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/schedule.txt'),
            )
        );
        break;

    case $buy_ticket:
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => '<a href="http://tickets.ypmus.ru">В такой кнопке нельзя просто открытие ссылки сделать. Можно или так,</a>',
                'parse_mode' => 'HTML',
                'reply_markup' => json_encode([
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true,
                    'inline_keyboard' => [
                        [
                            ['text' => 'или так', 'url' => 'http://tickets.ypmus.ru'],
                        ]
                    ]
                ])
            )
        );
        break;

    case $audio_guide:
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/audio_guide.txt'),
                'reply_markup' => json_encode([
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true,
                    'inline_keyboard' => [
                        [
                            ['text' => $audio_guide_description_button, 'url' => $audio_guide_link],
                        ]
                    ]
                ])
            )
        );
        break;

    case $branches:
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/branches.txt'),
                'reply_markup' => json_encode([
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true,
                    'keyboard' => [
                        [
                            ['text' =>'Культурно-выставочный комплекс «Л. Н. Т.» '],
                        ],
                        [
                            ['text' => 'Станция «Козлова Засека»'],
                        ],
                        [
                            ['text' => 'Станция «Щекино» (Ясенки)'],
                        ],
                        [
                            ['text' => 'Крапивенский краеведческий музей @KrapivnaMusej'],
                        ],
                        [
                            ['text' => 'Музей Земства и градостроительной истории'],
                        ],
                        [
                            ['text' => 'Никольское-Вяземское'],
                        ],
                        [
                            ['text' => 'Малое Пирогово'],
                        ],
                        [
                            ['text' => 'Назад'],
                        ]

                    ]
                ])
            )
        );
        break;

    case $children:
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/children.txt'),
                'reply_markup' => json_encode([
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true,
                    'inline_keyboard' => [
                        [
                            ['text' => $children_button, 'url' => $children_link],
                        ]
                    ]
                ])
            )
        );
        break;

    case $shn:
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/shn.txt'),
                'reply_markup' => json_encode([
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true,
                    'inline_keyboard' => [
                        [
                            ['text' => $shn_button, 'url' => $shn_link],
                        ]
                    ]
                ])
            )
        );
        break;

    default:
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/Заглушка.txt'),
            )
        );
}
