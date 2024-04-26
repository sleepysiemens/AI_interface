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

    public function messageGPTResponse($request, $chat)
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

        $api_key=config('settings.gpt-3_openai_key');

        switch ($chat->model)
        {
            case 'gpt-3.5-turbo':
                $api_key=config('settings.gpt-3_openai_key');
                break;
            case 'gpt-3.5-turbo-16k':
                $api_key=config('settings.gpt-3_16k_openai_key');
                break;
            case 'gpt-4':
                $api_key=config('settings.gpt-4_openai_key');
                break;
        }

        $response = $httpClient->request('POST', 'https://api.openai.com/v1/chat/completions',
            [
                'proxy' => [
                    'http' => getRequestProxy(),
                    'https' => getRequestProxy()
                ],
                'timeout' => config('settings.request_timeout') * 60,
                'headers' => [
                    'User-Agent' => config('settings.request_user_agent'),
                    'Authorization' => 'Bearer ' . $api_key,
                ],
                'json' => [
                    #'model' => config('settings.openai_completions_model'),
                    'model' => $chat->model,
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

    public function messageCloudeResponse($request, $chat)
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

        $client = new Client();

        $response = $client->request('POST', 'https://claude-3.p.rapidapi.com/messages', [
            'body' => '{
    "model": "claude-3-opus-20240229",
    "max_tokens": 1024,
    "messages": [
        {
            "role": "user",
            "content": "'.trim(preg_replace('/(?:\s{2,}+|[^\S ])/ui', ' ', $request->input('message'))).'"
        }
    ]
}',
            'headers' => [
                'X-RapidAPI-Host' => 'claude-3.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.claude3_key'),
                'content-type' => 'application/json',
            ],
        ]);

        $result= json_decode($response->getBody());
        return ($result);
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
                    'Authorization' => 'Bearer ' . config('settings.gpt-4_openai_key'),
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

    public function DalleImageResponse($request)
    {
        $httpClient = new Client();

        $response = $httpClient->request('POST', 'https://api.openai.com/v1/images/generations',
            [
                'proxy' => [
                    'http' => getRequestProxy(),
                    'https' => getRequestProxy()
                ],
                'timeout' => config('settings.request_timeout') * 60,
                'headers' => [
                    'User-Agent' => config('settings.re quest_user_agent'),
                    'Authorization' => 'Bearer ' . config('settings.gpt-3_openai_key'),
                ],
                'json' => [
                    'model' => 'dall-e-3',
                    'prompt' => trim(preg_replace('/(?:\s{2,}+|[^\S ])/ui', ' ', $request->input('description'))) . ($request->input('style') ? '. ' . __('The image should have :style style.', ['style' => $request->input('style')]) : '') . ($request->input('medium') ? '. ' . __('The image should be on a :medium medium.', ['medium' => $request->input('medium')]) : '') . ($request->input('filter') ? '. ' . __('Apply :filter filter.', ['filter' => $request->input('filter')]) : ''),
                    'n' => $request->has('variations') ? (float) $request->input('variations') : 1,
                    'size' => $request->input('resolution'),
                    'response_format' => 'url',
                    'user' => 'user' . $request->user()->id
                ]
            ]
        );

        return $response;
    }

    public function get_midjorney_task_id($description)
    {
        $client = new Client();

        $response = $client->request('POST', 'https://midjourney11.p.rapidapi.com/imagine', [
            'body' => '{"prompt": "'.$description.'"}',
            'headers' => [
                'X-RapidAPI-Host' => 'midjourney11.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.midjorney_key'),
                'content-type' => 'application/json',
            ],
        ]);


        return((json_decode($response->getBody()))->taskId) ;
    }

    public function MidjorneyImageResponse($request)
    {
        $task_id=$this->get_midjorney_task_id($request->input('description'));


        $client = new Client();
        $progress=0;

        $response = $client->request('GET', 'https://midjourney11.p.rapidapi.com/task/?taskId='.$task_id, [
            'headers' => [
                'X-RapidAPI-Host' => 'midjourney11.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.midjorney_key'),
            ],
        ]);
        return $response;
    }

    public function DeepFakeResponse($request)
    {
        $client = new Client();

        $response = $client->request('POST', 'https://deepfake-face-swap.p.rapidapi.com/swap', [
            'body' => '{
                            "source": "'.$request->source.'",
                            "target": "'.$request->target.'"
                        }',
            'headers' => [
                'X-RapidAPI-Host' => 'deepfake-face-swap.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.deepfake_key'),
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody())->result;
    }

    public function RunwayTextResponse($request)
    {
        $resolution=explode('x',$request->input('resolution_'));
        $client = new Client();

        $response = $client->request('POST', 'https://runwayml.p.rapidapi.com/generate/text', [
            'body' => '{
    "text_prompt": "'.$request->description.'",
    "width": '.$resolution[0].',
    "height": '.$resolution[1].',
    "motion": '.$request->motion.',
    "seed": '.$request->speed.',
    "upscale": '.$request->upscale.',
    "interpolate": '.$request->interpolate.'
}',
            'headers' => [
                'X-RapidAPI-Host' => 'runwayml.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.runway_key'),
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody())->uuid;
    }

    public function RunwayImageResponse($request)
    {
        $client = new Client();

        $response = $client->request('POST', 'https://runwayml.p.rapidapi.com/generate/image', [
            'body' => '{
    "img_prompt": "'.$request->source.'",
    "motion": '.$request->motion.',
    "seed": '.$request->speed.',
    "upscale": '.$request->upscale.',
    "interpolate": '.$request->interpolate.'
}',
            'headers' => [
                'X-RapidAPI-Host' => 'runwayml.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.runway_key'),
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody())->uuid;
    }

    public function RunwayImageDescriptionResponse($request)
    {
        $client = new Client();

        $response = $client->request('POST', 'https://runwayml.p.rapidapi.com/generate/imageDescription', [
            'body' => '{
    "img_prompt": "'.$request->source.'",
    "text_prompt": "'.$request->description.'",
    "motion": '.$request->motion.',
    "seed": '.$request->speed.',
    "upscale": '.$request->upscale.',
    "interpolate": '.$request->interpolate.'
}',
            'headers' => [
                'X-RapidAPI-Host' => 'runwayml.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.runway_key'),
                'content-type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody())->uuid;
    }
}
