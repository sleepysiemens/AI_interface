@section('site_title', formatTitle([__('Advanced'), __('Settings'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Settings')],
]])

<h1 class="h2 mb-3 d-inline-block">{{ __('Advanced') }}</h1>

<div class="card border-0 shadow-sm">
    <div class="card-header"><div class="font-weight-medium py-1">{{ __('Advanced') }}</div></div>
    <div class="card-body">

        {{--<ul class="nav nav-pills d-flex flex-fill flex-column flex-md-row mb-3" id="pills-tab" role="tablist">--}}
        <ul class="nav nav-pills row px-2 mb-3" id="pills-tab" role="tablist">
            <li class="nav-item flex-grow-1 text-center col-3">
                <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#pills-general" role="tab" aria-controls="pills-general" aria-selected="true">{{ __('General') }}</a>
            </li>
            <li class="nav-item flex-grow-1 text-center col-3">
                <a class="nav-link" id="pills-openai-tab" data-toggle="pill" href="#pills-openai" role="tab" aria-controls="pills-openai" aria-selected="false">{{ __('OpenAI') }}</a>
            </li>
            <li class="nav-item flex-grow-1 text-center col-3">
                <a class="nav-link" id="pills-midjorney-tab" data-toggle="pill" href="#pills-midjorney" role="tab" aria-controls="pills-midjorney" aria-selected="false">{{ __('Midjorney') }}</a>
            </li>
            <li class="nav-item flex-grow-1 text-center col-3">
                <a class="nav-link" id="pills-claude3-tab" data-toggle="pill" href="#pills-claude3" role="tab" aria-controls="pills-claude3" aria-selected="false">{{ __('Claude 3') }}</a>
            </li>
            <li class="nav-item flex-grow-1 text-center col-3">
                <a class="nav-link" id="pills-stab_diff-tab" data-toggle="pill" href="#pills-stab_diff" role="tab" aria-controls="pills-stab_diff" aria-selected="false">{{ __('Stab Diff') }}</a>
            </li>
            <li class="nav-item flex-grow-1 text-center col-3">
                <a class="nav-link" id="pills-ideogram-tab" data-toggle="pill" href="#pills-ideogram" role="tab" aria-controls="pills-ideogram" aria-selected="false">{{ __('Ideogram') }}</a>
            </li>
            <li class="nav-item flex-grow-1 text-center col-3">
                <a class="nav-link" id="pills-runway-tab" data-toggle="pill" href="#pills-runway" role="tab" aria-controls="pills-runway" aria-selected="false">{{ __('Runway') }}</a>
            </li>
            <li class="nav-item flex-grow-1 text-center col-3">
                <a class="nav-link" id="pills-deepfake-tab" data-toggle="pill" href="#pills-deepfake" role="tab" aria-controls="pills-deepfake" aria-selected="false">{{ __('Deepfake') }}</a>
            </li>
        </ul>

        @include('shared.message')

        <form action="{{ route('admin.settings', 'advanced') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="tab-content" id="pills-tabContent">
                @include('admin.settings.advanced-blocks.general')
                @include('admin.settings.advanced-blocks.openai')
                @include('admin.settings.advanced-blocks.midjorney')
                @include('admin.settings.advanced-blocks.claude3')
                @include('admin.settings.advanced-blocks.stab_diff')
                @include('admin.settings.advanced-blocks.ideogram')
                @include('admin.settings.advanced-blocks.runway')
                @include('admin.settings.advanced-blocks.deepfake')
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>

    </div>
</div>
