<div class="tab-pane fade" id="pills-ideogram" role="tabpanel" aria-labelledby="pills-ideogram-tab">
    <div class="form-group">
        <label for="i-ideogram-key"><b>{{__('Ideogram')}}</b> {{ __('API key') }} (временно сделал видимым)</label>
        <input type="text" name="ideogram_key" id="i-ideogram-key" class="form-control{{ $errors->has('ideogram_key') ? ' is-invalid' : '' }}" value="{{ old('ideogram_key') ?? config('settings.ideogram_key') }}">
        @if ($errors->has('ideogram_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('ideogram_key') }}</strong>
            </span>
        @endif
    </div>

</div>
