<div class="tab-pane fade" id="pills-llm" role="tabpanel" aria-labelledby="pills-llm-tab">
    <div class="form-group">
        <label for="i-llm-key"><b>{{__('LLM')}}</b> {{ __('API key') }} (временно сделал видимым)</label>
        <input type="text" name="llm_key" id="i-llm-key" class="form-control{{ $errors->has('llm_key') ? ' is-invalid' : '' }}" value="{{ old('llm_key') ?? config('settings.llm_key') }}">
        @if ($errors->has('llm_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('llm_key') }}</strong>
            </span>
        @endif
    </div>

</div>
