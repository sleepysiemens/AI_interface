<div class="tab-pane fade" id="pills-davinci" role="tabpanel" aria-labelledby="pills-davinci-tab">
    <div class="form-group">
        <label for="i-davinci-key"><b>{{__('Davinci')}}</b> {{ __('API key') }} (временно сделал видимым)</label>
        <input type="text" name="davinci_key" id="i-davinci-key" class="form-control{{ $errors->has('davinci_key') ? ' is-invalid' : '' }}" value="{{ old('davinci_key') ?? config('settings.davinci_key') }}">
        @if ($errors->has('davinci_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('davinci_key') }}</strong>
            </span>
        @endif
    </div>

</div>
