<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Models\Image;
use App\Models\Midjorney;
use App\Models\Template;
use App\Traits\MidjorneyImageTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MidjorneyController extends Controller
{
    use MidjorneyImageTrait;

    /**
     * List the Images.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchBy = in_array($request->input('search_by'), ['name']) ? $request->input('search_by') : 'name';
        $favorite = $request->input('favorite');
        $sortBy = in_array($request->input('sort_by'), ['id', 'name']) ? $request->input('sort_by') : 'id';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $images = Midjorney::where('user_id', $request->user()->id)#->where('type','text')
            ->when($search, function ($query) use ($search, $searchBy) {
                return $query->searchName($search);
            })
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'search_by' => $searchBy, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);

        return view('images.midjorney.container', ['view' => 'list', 'images' => $images]);
    }

    /**
     * Show the create Image form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('images.midjorney.container', ['view' => 'new']);
    }

    /**
     * Show the edit Image form.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $image = Midjorney::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        return view('images.midjorney.container', ['view' => 'edit', 'image' => $image]);
    }

    /**
     * Show the Image.
     */
    public function show(Request $request, $id)
    {
        $image = Midjorney::where([['id', $id]])->firstOrFail();
        $client = new Client();

        $response = $client->request('GET', 'https://midjourney11.p.rapidapi.com/task/?taskId='.$image->task_uuid, [
            'headers' => [
                'X-RapidAPI-Host' => 'midjourney11.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.midjorney_key'),
            ],
        ]);

        $result=json_decode($response->getBody());
        //dd($result);
        if($result->progress != 0)
        {
            $link = $result->imageUrl;

            $image->link = $link;
            $image->status = 'done';
            $image->save();
        }
        else
            $link = null;


        return view('images.midjorney.container', ['view' => 'show', 'image' => $image, 'link' => $link]);

    }

    /**
     * Store the Image.
     *
     * @param StoreImageRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(StoreImageRequest $request)
    {
        $image = $this->imagesStore($request);

        return redirect()->route('runway.text.show', $image);
    }

    /**
     * Update the Image.
     *
     * @param UpdateImageRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateImageRequest $request, $id)
    {
        $image = Midjorney::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $this->imageUpdate($request, $image);

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Process the Template.
     *
     * @param UpdateTemplateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processShow(UpdateTemplateRequest $request, $id)
    {
        $template = Midjorney::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $this->templateUpdate($request, $template);

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Delete the Image.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $image = Image::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $image->delete();

        return redirect()->route('images')->with('success', __(':name has been deleted.', ['name' => $image->name]));
    }
}
