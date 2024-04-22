<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Models\Runway;
use App\Models\Template;
use App\Traits\RunwayTextTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RunwayTextController extends Controller
{
    use RunwayTextTrait;

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
        $sortBy = in_array($request->input('sort_by'), ['id', 'name']) ? $request->input('sort_by') : 'id';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $images = Runway::where('user_id', $request->user()->id)->where('type','text')
            ->when($search, function ($query) use ($search, $searchBy) {
                return $query->searchName($search);
            })
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'search_by' => $searchBy, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);

        return view('runway.text.container', ['view' => 'list', 'images' => $images]);
    }

    /**
     * Show the create Image form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('runway.text.container', ['view' => 'new']);
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
        $image = Runway::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        return view('runway.text.container', ['view' => 'edit', 'image' => $image]);
    }

    /**
     * Show the Image.
     */
    public function show(Request $request, $id)
    {
        $image = Runway::where([['id', $id]])->firstOrFail();
        $client = new Client();
        #if($image->status=='new')
        #{
            $response = $client->request('GET', 'https://runwayml.p.rapidapi.com/status?uuid='.$image->task_uuid, [
                'headers' => [
                    'X-RapidAPI-Host' => 'runwayml.p.rapidapi.com',
                    'X-RapidAPI-Key' => config('settings.runway_key'),
                ],
            ]);

            $result=json_decode($response->getBody());
            //dd($result);
            if($result->status!='in queue')
            {
                $link['gif']=$result->gif_url;
                $link['video']=$result->url;

                $image->link=$result->gif_url;
                $image->video_url=$result->url;
                $image->status='done';
                $image->save();
            }
            else
                $link=null;
        #}
        #else
        #{
        #    $link['gif']=$image->link;
        #    $link['video']=$image->video_url;
        #}

        return view('runway.text.container', ['view' => 'show', 'image' => $image, 'link' => $link]);
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

        //return view('runway.text.container', ['view' => 'new', 'image' => $image, 'name' => $request->input('name'), 'description' => $request->input('description')]);
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
        $image = Runway::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

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
        $template = Template::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

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
        $image = Runway::where([['id', '=', $id], ['user_id', '=', $request->user()->id]])->firstOrFail();

        $image->delete();

        return redirect()->route('runway.text')->with('success', __(':name has been deleted.', ['name' => $image->name]));
    }
}
