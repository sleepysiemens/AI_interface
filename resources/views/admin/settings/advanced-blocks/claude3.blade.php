<div class="tab-pane fade" id="pills-claude3" role="tabpanel" aria-labelledby="pills-claude3-tab">
    <div class="form-group">
        <label for="i-claude3-key"><b>{{__('Claude 3')}}</b> {{ __('API key') }} (временно сделал видимым)</label>
        <input type="text" name="claude3_key" id="i-claude3-key" class="form-control{{ $errors->has('claude3_key') ? ' is-invalid' : '' }}" value="{{ old('claude3_key') ?? config('settings.claude3_key') }}">
        @if ($errors->has('claude3_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('claude3_key') }}</strong>
            </span>
        @endif
    </div>

</div>
