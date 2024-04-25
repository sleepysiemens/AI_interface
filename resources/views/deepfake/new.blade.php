@section('site_title', formatTitle([__('New'), __('DeepFake'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('deepfake'), 'title' => __('DeepFake')],
    ['title' => __('New')],
]])

<h1 class="h2 mb-3 d-inline-block">{{ __('New') }}</h1>

<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('DeepFake') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('deepfake.new') }}" method="post" enctype="multipart/form-data">
            @csrf

            <input name="type" type="hidden" value="transcription">

            <div class="form-group">
                <label for="i-name">{{ __('Name') }}</label>
                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="i-name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                <small class="form-text text-muted">{{ __('The name of the transcription.') }}</small>
            </div>

            <div class="form-group">
                <label for="i-source">{{ __('Source') }}</label>
                <input type="text" name="source" id="i-source" class="form-control{{ $errors->has('source') ? ' is-invalid' : '' }}" value="{{ $source ?? (old('source') ?? '') }}">
                @if ($errors->has('source'))
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('source') }}</strong>
                            </span>
                @endif
                <small class="form-text text-muted">{{ __('The link to the image.') }}</small>
            </div>

            <div class="form-group">
                <label for="i-target">{{ __('Target') }}</label>
                <input type="text" name="target" id="i-target" class="form-control{{ $errors->has('target') ? ' is-invalid' : '' }}" value="{{ $target ?? (old('target') ?? '') }}">
                @if ($errors->has('target'))
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('target') }}</strong>
                            </span>
                @endif
                <small class="form-text text-muted">{{ __('The link to the image.') }}</small>
            </div>

            <div class="form-group">
                <label for="i-description">{{ __('Description') }}</label>
                <textarea dir="ltr" rows="3" name="description" id="i-description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('The audio is about the evolution of AI.') }}">{{ old('description') ?? '' }}</textarea>
                @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
                <small class="form-text text-muted">{{ __('The description of the audio file.') }}</small>
            </div>
            @include('templates.partials.required-inputs')
            @include('templates.partials.common-inputs')


            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>
