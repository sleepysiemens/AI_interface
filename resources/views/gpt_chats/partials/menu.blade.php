@if(request()->is('admin/*') || request()->is('dashboard') || request()->is('chats') || request()->is('chats/new') || request()->is('chats/*/edit'))
    <a href="#" class="btn d-flex align-items-center btn-sm text-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.more-horiz', ['class' => 'fill-current width-4 height-4'])&#8203;</a>
@endif

<div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow">
    <a class="dropdown-item d-flex align-items-center" href="{{ request()->is('admin/*') ? route('admin.chats.gpt.edit', $chat->id) : route('chats.gpt.edit', $chat->id) }}">@include('icons.edit', ['class' => 'text-muted fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Edit') }}</a>

    <a class="dropdown-item d-flex align-items-center" href="{{ route('chats.gpt.show', $chat->id) }}">@include('icons.eye', ['class' => 'text-muted fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('View') }}</a>

    @if(Auth::check() && Auth::user()->id == $chat->user_id && !request()->is('admin/*'))
        <div class="dropdown-divider"></div>
        <a class="dropdown-item {{ ($chat->favorite ? 'text-warning' : '') }} d-flex align-items-center" href="#" data-toggle="modal" data-target="#modal" data-action="{{ route('chats.gpt.edit', $chat->id) }}" data-button-name="favorite" data-button-value="{{ ($chat->favorite ? '0' : '1') }}" data-button="btn {{ ($chat->favorite ? 'btn-danger' : 'btn-warning') }}" data-title="{{ ($chat->favorite ? __('Delete') : __('Favorite')) }}" data-text="{{ ($chat->favorite ? __('Are you sure you want to remove :name from favorites?', ['name' => $chat->name]) : __('Are you sure you want to add :name as favorite?', ['name' => $chat->name])) }}">@include('icons.' . ($chat->favorite ? 'star' : 'grade'), ['class' => 'fill-current width-4 height-4 ' . ($chat->favorite ? 'text-warning' : 'text-muted') . (__('lang_dir') == 'rtl' ? ' ml-3' : ' mr-3')]) {{ __('Favorite') }}</a>
    @endif

    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-danger d-flex align-items-center" href="#" data-toggle="modal" data-target="#modal" data-action="{{ request()->is('admin/*') || (Auth::user()->role == 1 && $chat->user_id != Auth::user()->id) ? route('admin.chats.gpt.destroy', $chat->id) : route('chats.gpt.destroy', $chat->id) }}" data-button="btn btn-danger" data-title="{{ __('Delete') }}" data-text="{{ __('Deleting this chat is permanent, and will remove all the data associated with it.') }}" data-sub-text="{{ __('Are you sure you want to delete :name?', ['name' => $chat->name]) }}">@include('icons.delete', ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')]) {{ __('Delete') }}</a>
</div>
