<?php

namespace App\Traits;

use App\Models\Transcription;
use App\Services\GetResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

trait DeepFakeTrait
{
    public $getResponse;
    public function __construct(GetResponse  $getResponse)
    {
        $this->getResponse=$getResponse;
    }
    /**
     * Store the Transcription.
     *
     * @param Request $request
     * @return Transcription
     */
    protected function transcriptionStore(Request $request)
    {
        $transcription = new Transcription;
        // Store the temporary file
        $fileName = $request->file('file')->hashName();
        $request->file('file')->move(public_path('uploads/users/transcriptions'), $fileName);

        $result = json_decode($this->getResponse->TranscriptionResponse($request, $fileName)->getBody()->getContents(), true);

        $wordsCount = wordsCount($result['text']);

        $transcription->name = $request->input('name');
        $transcription->user_id = $request->user()->id;
        $transcription->result = trim($result['text']);
        $transcription->words = $wordsCount;
        $transcription->save();

        $request->user()->transcriptions_month_count += 1;
        $request->user()->transcriptions_total_count += 1;
        $request->user()->words_month_count += $wordsCount;
        $request->user()->words_total_count += $wordsCount;
        $request->user()->save();

        // Remove the temporary file
        unlink(public_path('uploads/users/transcriptions/' . $fileName));

        return $transcription;
    }

    /**
     * Update the Transcription.
     *
     * @param Request $request
     * @param Transcription $transcription
     * @return Transcription
     */
    protected function transcriptionUpdate(Request $request, Transcription $transcription)
    {
        if ($request->has('name')) {
            $transcription->name = $request->input('name');
        }

        if ($request->has('favorite')) {
            $transcription->favorite = $request->input('favorite');
        }

        if ($request->has('result')) {
            $transcription->result = $request->input('result');
        }

        $transcription->save();

        return $transcription;
    }
}
