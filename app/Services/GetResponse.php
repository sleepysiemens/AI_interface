<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Transcription;
use GuzzleHttp\Client;

class GetResponse
{
    public function documentResponse($request, $prompt)
    {
        $httpClient = new Client();

        $response = $httpClient->request('POST', 'https://api.openai.com/v1/chat/completions',
            [
                'proxy' => [
                    'http' => getRequestProxy(),
                    'https' => getRequestProxy()
                ],
                'timeout' => config('settings.request_timeout') * 60,
                'headers' => [
                    'User-Agent' => config('settings.request_user_agent'),
                    'Authorization' => 'Bearer ' . config('settings.openai_key'),
                ],
                'json' => [
                    'model' => config('settings.openai_completions_model'),
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => trim(preg_replace('/(?:\s{2,}+|[^\S ])/ui', ' ', $prompt))
                        ]
                    ],
                    'temperature' => $request->has('creativity') ? (float) $request->input('creativity') : 0.5,
                    'n' => $request->has('variations') ? (float) $request->input('variations') : 1,
                    'frequency_penalty' => 0,
                    'presence_penalty' => 0,
                    'user' => 'user' . $request->user()->id
                ]
            ]
        );

        return $response;
    }

    public function messageResponse($request, $chat)
    {
        $httpClient = new Client();

        $oldMessages = Message::where([['chat_id', '=', $request->input('chat_id')], ['user_id', '=', $request->user()->id]])->orderBy('id', 'desc')->limit(20)->get()->reverse()->toArray();

        // If there's a chat history
        if ($oldMessages) {
            // Check if the last message is from the user
            if (end($oldMessages)['user_id'] == $request->user()->id) {
                // Remove the last message
                array_pop($oldMessages);
            }
        }

        // If there's a behavior defined
        if ($chat->behavior) {
            $messages[] = ['role' => 'system', 'content' => $chat->behavior];
        }

        // Prepare the chat history
        foreach ($oldMessages as $oldMessage) {
            $messages[] = ['role' => $oldMessage['role'], 'content' => trim(preg_replace('/(?:\s{2,}+|[^\S ])/ui', ' ', $oldMessage['result']))];
        }

        // Append the user's input
        $messages[] = ['role' => 'user', 'content' => trim(preg_replace('/(?:\s{2,}+|[^\S ])/ui', ' ', $request->input('message')))];

        $response = $httpClient->request('POST', 'https://api.openai.com/v1/chat/completions',
            [
                'proxy' => [
                    'http' => getRequestProxy(),
                    'https' => getRequestProxy()
                ],
                'timeout' => config('settings.request_timeout') * 60,
                'headers' => [
                    'User-Agent' => config('settings.request_user_agent'),
                    'Authorization' => 'Bearer ' . config('settings.openai_key'),
                ],
                'json' => [
                    'model' => config('settings.openai_completions_model'),
                    'messages' => $messages,
                    'temperature' => $request->has('creativity') ? (float) $request->input('creativity') : 0.5,
                    'n' => 1,
                    'frequency_penalty' => 0,
                    'presence_penalty' => 0,
                    'user' => 'user' . $request->user()->id
                ]
            ]
        );

        return $response;
    }

    public function TranscriptionResponse($request, $fileName)
    {

        $httpClient = new Client();

        $response = $httpClient->request('POST', 'https://api.openai.com/v1/audio/transcriptions',
            [
                'proxy' => [
                    'http' => getRequestProxy(),
                    'https' => getRequestProxy()
                ],
                'timeout' => config('settings.request_timeout') * 60,
                'headers' => [
                    'User-Agent' => config('settings.request_user_agent'),
                    'Authorization' => 'Bearer ' . config('settings.openai_key'),
                ],
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen('uploads/users/transcriptions/' . $fileName, 'r')
                    ],
                    [
                        'name'     => 'model',
                        'contents' => config('settings.openai_transcriptions_model')
                    ],
                    [
                        'name'     => 'prompt',
                        'contents' => trim(preg_replace('/(?:\s{2,}+|[^\S ])/ui', ' ', $request->input('description')))
                    ],
                    [
                        'name'     => 'language',
                        'contents' => $request->input('language')
                    ],
                    [
                        'name'     => 'user',
                        'contents' => 'user' . $request->user()->id
                    ]
                ]
            ]
        );
        return $response;
    }
}
