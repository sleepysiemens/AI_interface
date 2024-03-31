<div class="tab-pane fade" id="pills-deepfake" role="tabpanel" aria-labelledby="pills-deepfake-tab">
    <div class="form-group">
        <label for="i-deepfake-key"><b>{{__('Deepfake')}}</b> {{ __('API key') }} (временно сделал видимым)</label>
        <input type="text" name="deepfake_key" id="i-deepfake-key" class="form-control{{ $errors->has('deepfake_key') ? ' is-invalid' : '' }}" value="{{ old('deepfake_key') ?? config('settings.deepfake_key') }}">
        @if ($errors->has('deepfake_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('deepfake_key') }}</strong>
            </span>
        @endif
    </div>

</div>
