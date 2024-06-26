@section('menu')
    @php
        $menu = [
            route('dashboard') => [
                'icon' => 'grid-view',
                'title' => __('Dashboard')
            ],
            route('templates') => [
                'icon' => 'apps',
                'title' => __('Templates')
            ],
            route('documents') => [
                'icon' => 'document',
                'title' => __('Documents')
            ],
           'images' => [
                'icon' => 'image',
                'title' => __('Images'),
                'menu'=>
                [
                    route('images.dalle') =>
                    [
                        'icon' => 'openai',
                        'title' => __('DALL-E')
                    ],
                    route('images.midjorney') =>
                     [
                        'icon' => 'midjorney',
                        'title' => __('Midjorney')
                    ],
                    route('images.davinci') =>
                    [
                        'icon' => 'davinci',
                        'title' => __('Davinci'),
                    ],
                ],
            ],
            'chats'=>[
                        'icon' => 'chat',
                        'title' => __('Chats'),
                        'menu'=>
                        [
                             route('chats.gpt') => [
                            'icon' => 'chat',
                            'title' => __('Chat GPT')
                            ],
                            route('chats.cloude') => [
                            'icon' => 'chat',
                            'title' => __('Claude 3')
                            ],
                        ],
                    ],
                 'runway' => [
                'icon' => 'runway',
                'title' => __('Runway'),
                'menu'=>
                [
                    route('runway.text') => [
                        'icon' => 'runway',
                        'title' => __('Generate by text')
                        ],
                    route('runway.image') => [
                        'icon' => 'runway',
                        'title' => __('Generate by image')
                        ],
                    route('runway.image_description') => [
                        'icon' => 'runway',
                            'title' => __('Generate by image and description')
                        ],
                    ],
                ],

                'StabDiff' => [
                    'icon' => 'stabdiff',
                    'title' => __('StabDiff'),
                    'menu' => [
                        route('stabdiff.text') => [
                        'icon' => 'stabdiff',
                        'title' => __('Generate by text')
                        ],
                        route('stabdiff.image') => [
                        'icon' => 'stabdiff',
                        'title' => __('Generate by image')
                        ],
                    ],
                ],

            route('transcriptions') => [
                'icon' => 'headphones',
                'title' => __('Transcriptions')
            ],
            route('deepfake') => [
                'icon' => 'deepfake',
                'title' => __('DeepFake')
            ]
        ];
    @endphp

    <div class="nav d-block text-truncate">
        @foreach ($menu as $key => $value)
            <li class="nav-item">
                <a class="nav-link d-flex px-4 @if (str_starts_with(request()->url(), $key) && !isset($value['menu'])) active @endif" @if(isset($value['menu'])) data-toggle="collapse" href="#sub-menu-{{ $key }}" role="button" @if (array_filter(array_keys($value['menu']), function ($url) { return str_starts_with(request()->url(), $url); })) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse-{{ $key }}" @else href="{{ $key }}" @endif>
                    <span class="sidebar-icon d-flex align-items-center">@include('icons.' . $value['icon'], ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')])</span>
                    <span class="flex-grow-1 text-truncate">{{ $value['title'] }}</span>
                    @if (isset($value['menu'])) <span class="d-flex align-items-center ml-auto sidebar-expand">@include('icons.expand-more', ['class' => 'fill-current text-muted width-3 height-3'])</span> @endif
                </a>
            </li>

            @if (isset($value['menu']))
                <div class="collapse sub-menu @if (array_filter(array_keys($menu[$key]['menu']), function ($url) { return str_starts_with(request()->url(), $url); })) show @endif" id="sub-menu-{{ $key }}">
                    @foreach ($value['menu'] as $subKey => $subValue)
                        <a href="{{ $subKey }}" class="nav-link px-4 d-flex text-truncate @if (request()->url()== $subKey) active @endif">
                            <span class="sidebar-icon d-flex align-items-center">@include('icons.' . $subValue['icon'], ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')])</span>
                            <span class="flex-grow-1 text-truncate">{{ $subValue['title'] }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
@endsection
