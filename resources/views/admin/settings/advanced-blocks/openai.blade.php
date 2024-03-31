<div class="tab-pane fade" id="pills-openai" role="tabpanel" aria-labelledby="pills-openai-tab">
    <div class="form-group">
        <label for="i-openai-key"><b>{{__('OpenAI')}}</b> {{ __('API key') }}(временно сделал видимым)</label>
        <input type="text" name="openai_key" id="i-openai-key" class="form-control{{ $errors->has('openai_key') ? ' is-invalid' : '' }}" value="{{ old('openai_key') ?? config('settings.openai_key') }}">
        @if ($errors->has('openai_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('openai_key') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <label for="i-openai-completions-model" class="d-inline-flex align-items-center"><span class="{{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}">{{ __('Model') }}</span><span class="badge badge-secondary">{{ __('Default') }}</span></label>
        <select name="openai_completions_model" id="i-openai-completions-model" class="custom-select{{ $errors->has('openai_completions_model') ? ' is-invalid' : '' }}">
            @foreach(['gpt-4', 'gpt-3.5-turbo', 'gpt-3.5-turbo-16k'] as $key)
                <option value="{{ $key }}" @if ((old('openai_completions_model') !== null && old('openai_completions_model') == $key) || (old('openai_completions_model') == null && $key == config('settings.openai_completions_model'))) selected @endif>{{ $key }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="i-default-language" class="d-inline-flex align-items-center"><span class="{{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}">{{ __('Language') }}</span><span class="badge badge-secondary">{{ __('Default') }}</span></label>
        <select name="openai_default_language" id="i-default-language" class="custom-select{{ $errors->has('openai_default_language') ? ' is-invalid' : '' }}">
            @foreach(array_intersect_key(config('languages'), array_flip(config('completions.languages'))) as $key => $value)
                <option value="{{ $key }}" @if ((old('openai_default_language') !== null && old('openai_default_language') == $key) || (old('openai_default_language') == null && $key == config('settings.openai_default_language'))) selected @endif>{{ __($value['name']) }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="i-ai-assistant-name">{{ __('Assistant name') }}</label>
        <input type="text" name="ai_assistant_name" id="i-ai-assistant-name" class="form-control{{ $errors->has('ai_assistant_name') ? ' is-invalid' : '' }}" value="{{ old('ai_assistant_name') ?? config('settings.ai_assistant_name') }}">
        @if ($errors->has('ai_assistant_name'))
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ai_assistant_name') }}</strong>
                            </span>
        @endif
    </div>

    <div class="form-group">
        <label for="i-ai-assistant-email">{{ __('Assistant email') }}</label>
        <input type="text" name="ai_assistant_email" id="i-ai-assistant-email" class="form-control{{ $errors->has('ai_assistant_email') ? ' is-invalid' : '' }}" value="{{ old('ai_assistant_email') ?? config('settings.ai_assistant_email') }}">
        @if ($errors->has('ai_assistant_email'))
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ai_assistant_email') }}</strong>
                            </span>
        @endif
    </div>
</div>
