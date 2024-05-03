<?php

namespace App\Traits;

use App\Models\Image;
use App\Models\Midjorney;
use App\Models\MidjorneyRequest;
use App\Services\GetResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait MidjorneyImageTrait
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
     * @return Image
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
     * @return Image
     * @throws GuzzleException
     */
    private function imageModel(Request $request, $result, $count)
    {
        $image = new Midjorney;
        $image->name = $request->input('name'). ($count > 1 ? ' (' . $count .')' : '');
        $image->user_id = $request->user()->id;
        $image->status = 'new';
        $image->task_uuid = $result;
        $image->save();

        $request->user()->images_month_count += 1;
        $request->user()->images_total_count += 1;
        $request->user()->save();

        return $image;
    }

    /**
     * Update the Image..
     *
     * @param Request $request
     * @param Image $image
     * @return Image
     */
    protected function imageUpdate(Request $request, Image $image)
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
        $response = $this->getResponse->MidjorneyImageResponse($request);

        return $response;
    }
}
