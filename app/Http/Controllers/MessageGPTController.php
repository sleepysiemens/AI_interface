<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Traits\MessageGPTTrait;

class   MessageGPTController extends Controller
{
    use MessageGPTTrait;

    /**
     * Store the Chat.
     *
     * @param StoreMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(StoreMessageRequest $request)
    {
        $message = $this->messageStore($request);

        return response()->json(['message' => view('gpt_chats.partials.message', ['message' => $message])->render()], 200);
    }
}
