<?php

namespace App\Traits;

use App\Models\Image;
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

        /*$results = [];
        $i = 1;
        foreach ($response['data'] as $result) {
            if ($request->user()->can('create', ['App\Models\MidjorneyRequest'])) {
                $results[] = $this->imageModel($request, $result, $i);
                $i++;
            }
        }

        return $results;*/

        MidjorneyRequest::create(['user_id'=>auth()->user()->id, 'taskId'=>$response]);

        return $response;
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
        $fileName = Str::uuid();

        $httpClient = new Client();

        $httpClient->request('GET', $count == 0 ? $result['data'][0]['url'] : $result['url'], [
            'sink' => public_path('uploads/users/images/' . $fileName)
        ]);

        $imageResource = imagecreatefrompng(public_path('uploads/users/images/' . $fileName));

        $imageFileName = $fileName . '.jpg';

        // Convert and optimize the image
        imagejpeg($imageResource, public_path('uploads/users/images/' . $imageFileName), 88);

        // Remove the original image
        unlink(public_path('uploads/users/images/' . $fileName));

        $image = new Image;
        $image->name = $request->input('name'). ($count > 1 ? ' (' . $count .')' : '');
        $image->user_id = $request->user()->id;
        $image->result = $imageFileName;
        $image->network = 'midjorney';
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

        if ($request->has('favorite')) {
            $image->favorite = $request->input('favorite');
        }

        $image->save();

        return $image;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws GuzzleException
     */
    private function getTaskId(Request $request)
    {
        $response=$this->getResponse->get_midjorney_task_id($request->description);

       return $response;
    }

    private function fetchImages(Request $request)
    {
        $response=$this->getResponse->MidjorneyImageResponse($request);

        return json_decode($response->getBody()->getContents(), true);
    }
}
