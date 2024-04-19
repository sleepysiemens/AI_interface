<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Models\Image;
use App\Models\Template;
use App\Traits\DeepFakeTrait;
use Illuminate\Http\Request;

class DeepFakeController extends Controller
{
    use DeepFakeTrait;

    /**
     * List the Images.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $images = Image::where('user_id', $request->user()->id)->where('network','deepfake')->get();
        return view('deepfake.container', ['view' => 'list', 'images' => $images]);
    }

    /**
     * Show the create Image form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('deepfake.container', ['view' => 'new']);
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
    }

    /**
     * Show the Image.
     */
    public function show(Request $request, $id)
    {
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
        dd(1);
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
    }
}
