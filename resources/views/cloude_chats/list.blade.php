@section('site_title', formatTitle([__('Chats'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['title' => __('Chats')]
]])

<div class="d-flex">
    <div class="flex-grow-1">
        <h1 class="h2 mb-3 d-inline-block">{{ __('Chats') }} {{__('Claude 3')}}</h1>
    </div>
    <div>
        <a href="{{ route('chats.cloude.new') }}" class="btn btn-primary mb-3">{{ __('New') }}</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Chats') }}</div>
            </div>
            <div class="col-auto">
                <form method="GET" action="{{ route('chats.cloude') }}">
                    <div class="input-group input-group-sm">
                        <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-primary d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-tooltip="true" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])
                                &#8203;
                            </button>
                            <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64 p-0" id="search-filters">
                                <div class="dropdown-header py-3">
                                    <div class="row">
                                        <div class="col">
                                            <div class="font-weight-medium m-0 text-body">{{ __('Filters') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('chats.cloude') }}" class="text-secondary">{{ __('Reset') }}</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider my-0"></div>

                                <div class="max-height-96 overflow-auto pt-3">
                                    <div class="form-group px-4">
                                        <label for="i-search-by" class="small">{{ __('Search by') }}</label>
                                        <select name="search_by" id="i-search-by" class="custom-select custom-select-sm">
                                            @foreach(['name' => __('Name')] as $key => $value)
                                                <option value="{{ $key }}" @if(request()->input('search_by') == $key) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group px-4">
                                        <label for="i-favorite" class="small">{{ __('Favorite') }}</label>
                                        <select name="favorite" id="i-favorite" class="custom-select custom-select-sm">
                                            <option value="">{{ __('All') }}</option>
                                            @foreach([0 => __('No'), 1 => __('Yes')] as $key => $value)
                                                <option value="{{ $key }}" @if(request()->input('favorite') == $key && request()->input('favorite') !== null) selected @endif>{{ __($value) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group px-4">
                                        <label for="i-sort-by" class="small">{{ __('Sort by') }}</label>
                                        <select name="sort_by" id="i-sort-by" class="custom-select custom-select-sm">
                                            @foreach(['id' => __('Date created'), 'name' => __('Name')] as $key => $value)
                                                <option value="{{ $key }}" @if(request()->input('sort_by') == $key) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group px-4">
                                        <label for="i-sort" class="small">{{ __('Sort') }}</label>
                                        <select name="sort" id="i-sort" class="custom-select custom-select-sm">
                                            @foreach(['desc' => __('Descending'), 'asc' => __('Ascending')] as $key => $value)
                                                <option value="{{ $key }}" @if(request()->input('sort') == $key) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group px-4">
                                        <label for="i-per-page" class="small">{{ __('Results per page') }}</label>
                                        <select name="per_page" id="i-per-page" class="custom-select custom-select-sm">
                                            @foreach([10, 25, 50, 100] as $value)
                                                <option value="{{ $value }}" @if(request()->input('per_page') == $value || request()->input('per_page') == null && $value == config('settings.paginate')) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="dropdown-divider my-0"></div>

                                <div class="px-4 py-3">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">{{ __('Search') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        @if(count($chats) == 0)
            {{ __('No results found.') }}
        @else
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0 text-muted">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-8 col-lg-6 d-flex text-truncate">
                                    {{ __('Name') }}
                                </div>

                                <div class="d-none d-md-block col-md-4 col-lg-2 text-truncate">
                                    {{ __('Messages') }}
                                </div>

                                <div class="d-none d-lg-block col-lg-2 text-truncate">
                                    {{ __('Words') }}
                                </div>

                                <div class="d-none d-lg-block col-lg-2 text-truncate">
                                    {{ __('Created at') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-row">
                                <div class="col">
                                    <div class="invisible btn d-flex align-items-center btn-sm text-primary">@include('icons.more-horiz', ['class' => 'fill-current width-4 height-4'])&#8203;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($chats as $chat)
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col text-truncate">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-8 col-lg-6 d-flex text-truncate">
                                        <div class="text-truncate">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center text-truncate">
                                                    <a href="{{ route('chats.cloude.show', $chat->id) }}" class="text-truncate">{{ $chat->name }}</a>

                                                    @if($chat->favorite) <div class="d-flex flex-shrink-0 width-4 height-4 text-warning {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-tooltip="true" title="{{ __('Favorite') }}">@include('icons.star', ['class' => 'fill-current width-4 height-4 flex-shrink-0'])</div> @endif
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="text-muted text-truncate small cursor-help" data-tooltip="true" title="{{ $chat->url }}">
                                                    {{ Str::substr(strip_tags($chat->latestMessage()->first()->result ?? __('No data')) . '.', 0, 160) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-none d-md-flex align-items-center col-md-4 col-lg-2">
                                        {{ number_format($chat->messages, 0, __('.'), __(',')) }}
                                    </div>

                                    <div class="d-none d-lg-block col-lg-2 text-truncate">
                                        {{ number_format($chat->words, 0, __('.'), __(',')) }}
                                    </div>

                                    <div class="d-none d-lg-flex col-lg-2 text-truncate">
                                        <span class="text-truncate" data-tooltip="true" title="{{ $chat->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d') . ' H:i:s') }}">{{ $chat->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-row">
                                    <div class="col">
                                        @include('gpt_chats.partials.menu')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3 align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $chats->firstItem(), 'to' => $chats->lastItem(), 'total' => $chats->total()]) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            {{ $chats->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
