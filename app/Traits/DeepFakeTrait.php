<?php

namespace App\Traits;

use App\Models\DeepFake;
use App\Services\GetResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait DeepFakeTrait
{
    /**
     * Store the Image.
     *
     * @param Request $request
     * @param string|null $prompt
     * @param int $variations
     * @return array
     * @throws GuzzleException
     */
    protected function imagesStore(Request $request)
    {
        $response = $this->fetchImages($request);

        return $this->imageModel($request, $response, 0);
    }

    /**
     * Store the Image.
     *
     * @param Request $request
     * @param string|null $prompt
     * @param int $variations
     * @return DeepFake
     * @throws GuzzleException
     */
    protected function imageStore(Request $request, string $prompt = null)
    {
        $response = $this->fetchImages($request);

        return $this->imageModel($request, $response, 0);
    }

    /**
     * @param Request $request
     * @param $result
     * @param $count
     * @return DeepFake
     * @throws GuzzleException
     */
    private function imageModel(Request $request, $result, $count)
    {
        $image = new DeepFake;
        $image->name = $request->input('name'). ($count > 1 ? ' (' . $count .')' : '');
        $image->user_id = $request->user()->id;
        $image->result = $result;
        $image->save();
        $request->user()->images_month_count += 1;
        $request->user()->images_total_count += 1;
        $request->user()->save();

        $imageData = base64_decode($result);
        $imageName = $request->input('name') . '.png';
        $path = public_path('uploads/users/images'.$request->user()->id) . $imageName;
        file_put_contents($path, $imageData);


        return $image;
    }

    /**
     * Update the Image.
     *
     * @param Request $request
     * @param DeepFake $image
     * @return DeepFake
     */
    protected function imageUpdate(Request $request, DeepFake $image)
    {
        if ($request->has('name')) {
            $image->name = $request->input('name');
        }

        $image->save();

        return $image;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws GuzzleException
     */
    private function fetchImages(Request $request)
    {
        $response = $this->getResponse->DeepFakeResponse($request);

        return $response;
    }
}
