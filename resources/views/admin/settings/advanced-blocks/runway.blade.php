<div class="tab-pane fade" id="pills-runway" role="tabpanel" aria-labelledby="pills-runway-tab">
    <div class="form-group">
        <label for="i-runway-key"><b>{{__('Runway')}}</b> {{ __('API key') }} (временно сделал видимым)</label>
        <input type="text" name="runway_key" id="i-runway-key" class="form-control{{ $errors->has('runway_key') ? ' is-invalid' : '' }}" value="{{ old('runway_key') ?? config('settings.runway_key') }}">
        @if ($errors->has('runway_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('runway_key') }}</strong>
            </span>
        @endif
    </div>

</div>
