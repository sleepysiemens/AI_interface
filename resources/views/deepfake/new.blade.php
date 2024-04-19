@section('site_title', formatTitle([__('New'), __('Transcription'), config('settings.title')]))

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
                <label for="i-file">{{ __('Source') }}</label>
                <div class="custom-file">
                    <input type="file" name="source" id="i-file" class="custom-file-input{{ $errors->has('file') ? ' is-invalid' : '' }}">
                    <label class="custom-file-label" for="i-file" data-browse="{{ __('Browse') }}">{{ __('Choose file') }}</label>
                </div>
                @if ($errors->has('file'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @endif
                <small class="form-text text-muted">{{ __('Image.') }}</small>
            </div>

            <div class="form-group">
                <label for="i-file">{{ __('Target') }}</label>
                <div class="custom-file">
                    <input type="file" name="target" id="i-file-2" class="custom-file-input{{ $errors->has('file') ? ' is-invalid' : '' }}">
                    <label class="custom-file-label" for="i-file-2" data-browse="{{ __('Browse') }}">{{ __('Choose file') }}</label>
                </div>
                @if ($errors->has('file'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @endif
                <small class="form-text text-muted">{{ __('Image.') }}</small>
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


            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>
