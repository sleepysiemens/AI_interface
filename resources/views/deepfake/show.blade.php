@section('site_title', formatTitle([e($image->name), __('Image'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => request()->is('admin/*') ? route('admin.dashboard') : route('dashboard'), 'title' => request()->is('admin/*') ? __('Admin') : __('Home')],
    ['url' => request()->is('admin/*') ? route('admin.images') : route('deepfake'), 'title' => __('Depfake')],
    ['title' => __('Generate by text')],
]])

<div class="d-flex align-items-end mb-3">
    <h1 class="h2 mb-0 flex-grow-1 text-truncate">{{ $image->name }}</h1>

    <div class="d-flex align-items-center flex-grow-0">
        <div class="form-row flex-nowrap">
            <div class="col">

            </div>
            <div class="col">
                <a href="#" class="btn text-secondary d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.more-horiz', ['class' => 'fill-current width-4 height-4'])&#8203;</a>

                @include('runway.image.partials.menu')
            </div>
        </div>
    </div>
</div>

<div class="row m-n2">
    <div class="col-12 p-2">
        <div class="card border-0 rounded-top shadow-sm overflow-hidden">
            <div class="card-header align-items-center">
                <div class="row">
                    <div class="col d-flex align-items-center">
                        <div class="d-flex align-items-center font-weight-medium py-1">
                            <div class="d-flex align-items-center text-truncate">
                                {{ __('Image') }}
                                @if($image->favorite) <div class="d-flex flex-shrink-0 width-4 height-4 text-warning {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-tooltip="true" title="{{ __('Favorite') }}">@include('icons.star', ['class' => 'fill-current width-4 height-4 flex-shrink-0'])</div> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                    <img src="{{asset('uploads/users/images/'.$image->user_id.$image->name.'.png')}}" class="w-100">
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-12 col-lg text-truncate d-flex align-items-center justify-content-lg-center">
                        <div class="card-body my-n2 text-truncate d-flex align-items-center justify-content-lg-center">
                            <span class="height-6 d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}" data-tooltip="true" title="{{ __('Created at') }}">
                                @include('icons.event', ['class' => 'fill-current text-muted width-4 height-4'])
                            </span>

                            <span class="text-truncate text-muted" data-tooltip="true" title="{{ $image->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')) }} {{ $image->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format('H:i:s') }}">
                            {{ $image->created_at->diffForHumans() }}
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    @if($image->status != 'done')
        <script>
            setTimeout(() => {
                window.location.reload(1);
            },30000);
        </script>
    @endif
@endsection
