<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class TestController extends Controller
{
    public function index()
    {
        $client = new Client(
            [
                'proxy' => [
                    'http' => getRequestProxy(),
                    'https' => getRequestProxy()
                ],
            ]
        );

        $params = [
            RequestOptions::JSON => [
                'model' => 'claude-3-opus-20240229',
                'max_tokens' => 1000,
                'temperature' => 0.0,
                'system' => 'Respond only in Yoda-speak.',
                'messages' => [
                    ['role' => 'user', 'content' => 'How are you today?']
                ]
            ],
            RequestOptions::HEADERS => [
                'x-api-key' => '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' // Замените my_api_key на ваш API-ключ
            ]
        ];

// Выполняем POST-запрос к API Anthropic
        $response = $client->post('https://api.anthropic.com/v1/messages', $params);

// Получаем тело ответа
        $body = $response->getBody()->getContents();

// Декодируем JSON-ответ
        $result = json_decode($body, true);

// Выводим содержимое сообщения
        dd ($result['content']);
    }
}
