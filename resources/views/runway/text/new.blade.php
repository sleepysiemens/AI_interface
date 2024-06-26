@section('site_title', formatTitle([__('New'), __('Image'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('runway.text'), 'title' => __('Runway')],
    ['title' => __('Generate by text')],
    ['title' => __('New')],
]])

<h1 class="h2 mb-0 d-inline-block">{{__('Runway')}} {{ __('Generate by text') }}</h1>

<div class="row mx-n2">
    <div class="col-12 col-lg-5 px-2">
        <div class="card border-0 shadow-sm mt-3 @if(isset($images)) d-none d-lg-flex @endif" id="ai-form">
            <div class="card-header align-items-center">
                <div class="row">
                    <div class="col">
                        <div class="font-weight-medium py-1">{{ __('Image') }}</div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('shared.message')

                <form action="{{ route('runway.text.new') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="i-name">{{ __('Name') }}</label>
                        <input type="text" name="name" id="i-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $name ?? (old('name') ?? '') }}">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                        <small class="form-text text-muted">{{ __('The name of the image.') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="i-description">{{ __('Description') }}</label>
                        <textarea dir="ltr" rows="5" name="description" id="i-description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Blue butterfly') }}">{{ $description ?? (old('description') ?? '') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                        <small class="form-text text-muted">{{ __('The description of the image.') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="i-resolution">{{ __('Resolution') }}</label>
                        <select  name="resolution_" id="i-resolution" class="custom-select {{$errors->has('resolution') ? ' is-invalid' : ''}} ">
                            @foreach(config('images.resolutions') as $key => $value)
                                <option value="{{ $key }}">{{ __($value) }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('resolution_'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('resolution_') }}</strong>
                                </span>
                        @endif

                        <small class="form-text text-muted">{{ __('The resolution of the image.') }}</small>

                    </div>

                    <div class="form-group">
                        <label for="i-motion">{{ __('Motion') }}</label>
                        <input type="number" name="motion" id="i-motion" class="form-control{{ $errors->has('motion') ? ' is-invalid' : '' }}" value="{{ $motion ?? (old('motion') ?? '5') }}">
                        @if ($errors->has('motion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('motion') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-motion">{{ __('Speed') }}</label>
                        <input type="number" name="speed" id="i-motion" class="form-control{{ $errors->has('motion') ? ' is-invalid' : '' }}" value="{{ $speed ?? (old('speed') ?? '0') }}">
                        @if ($errors->has('speed'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('speed') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-upscale">{{ __('use upscale') }}</label>
                        <select  name="upscale" id="i-upscale" class="custom-select{{$errors->has('upscale') ? ' is-invalid' : ''}} ">
                            @foreach([true, false] as $key)
                                <option value="{{ $key }}">{{ $key ? __('yes') : __('no') }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('upscale'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('upscale') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-interpolate">{{ __('use interpolate') }}</label>
                        <select  name="interpolate" id="i-interpolate" class="custom-select{{$errors->has('interpolate') ? ' is-invalid' : ''}} ">
                            @foreach([true, false] as $key)
                                <option value="{{ $key }}">{{ $key ? __('yes') : __('no') }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('interpolate'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('interpolate') }}</strong>
                                </span>
                        @endif
                    </div>


                    @include('templates.partials.required-inputs')
                    @include('templates.partials.common-inputs')

                    <div class="row mx-n2 mt-4">
                        <div class="col px-2">
                            <button type="submit" name="submit" class="btn btn-primary position-relative" data-button-loader>
                                <div class="position-absolute top-0 right-0 bottom-0 left-0 d-flex align-items-center justify-content-center">
                                    <span class="d-none spinner-border spinner-border-sm width-4 height-4" role="status"></span>
                                </div>
                                <span class="spinner-text">{{ __('Generate') }}</span>&#8203;
                            </button>
                        </div>
                        <div class="col-auto px-2">
                            <a href="{{ route('templates.freestyle') }}" class="btn btn-outline-secondary d-none {{ (__('lang_dir') == 'rtl' ? 'mr-auto' : 'ml-auto') }}">{{ __('Reset') }}</a>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($images))
            <a href="#" class="btn btn-outline-secondary btn-block d-lg-none mt-3" id="ai-form-show-button">{{ __('Show form') }}</a>
        @endif
    </div>

    <div class="col-12 col-lg-7 px-2">
        @if(isset($images))
            <div class="text-muted font-weight-medium z-1" id="ai-placeholder-text-start">
                <div class="width-6 height-6 mt-5"></div>
                <div class="my-3">{{ __('Generating the content, please wait.') }}</div>
                <div class="width-6 height-6 mb-5"></div>
            </div>
        @endif

        <div class="position-relative pt-3 h-100 @if(isset($images)) d-none @else d-flex @endif" id="ai-placeholder-results">
            <div class="position-relative h-100 align-items-center justify-content-center d-flex w-100">
                <div class="text-muted font-weight-medium z-1" id="ai-placeholder-text-start">
                    <div class="width-6 height-6 mt-5"></div>
                    <div class="my-3">{{ __('Start by filling the form.') }}</div>
                    <div class="width-6 height-6 mb-5"></div>
                </div>
                <div class="text-muted flex-column font-weight-medium z-1 align-items-center d-none " id="ai-placeholder-text-progress">
                    <div class="width-6 height-6 mt-5"></div>
                    <div class="my-3">{{ __('Generating the content, please wait.') }}</div>
                    <div class="spinner-border spinner-border-sm width-6 height-6 mb-5" role="status"></div>
                </div>
                <div class="position-absolute top-0 right-0 bottom-0 left-0 border rounded border-width-2 border-dashed opacity-20 z-0"></div>
            </div>
        </div>
    </div>
</div>
