<?php

namespace App\Traits;

use App\Models\Chat;
use App\Models\Message;
use App\Services\GetResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait MessageTrait
{
    public $getResponse;
    public function __construct(GetResponse  $getResponse)
    {
        $this->getResponse=$getResponse;
    }
    /**
     * Store the Message.
     *
     * @param Request $request
     * @return Message
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function messageStore(Request $request)
    {
        $chat = Chat::where('id', $request->input('chat_id'))->firstOrFail();

        $message = new Message();
        $message->chat_id = $request->input('chat_id');
        $message->user_id = $request->user()->id;
        $message->role = $request->input('role');

        if ($request->input('role') == 'user') {
            $text = trim($request->input('message'));
        } else {
            try {
                $result = json_decode($this->getResponse->messageResponse($request, $chat)->getBody()->getContents(), true);

                $text = $result['choices'][0]['message']['content'] ?? '';
            } catch (\Exception $e) {
                $text = $e->getMessage();
            }
        }

        $wordsCount = wordsCount($text);

        if ($request->input('role') == 'assistant') {
            $request->user()->words_month_count += $wordsCount;
            $request->user()->words_total_count += $wordsCount;
            $request->user()->save();
        }

        $message->result = $text;
        $message->words = $wordsCount;
        $message->save();

        // Update the Chat
        $chat->words += $message->words;
        $chat->messages += 1;
        $chat->save();

        return $message;
    }
}
