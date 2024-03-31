<div class="tab-pane fade" id="pills-midjorney" role="tabpanel" aria-labelledby="pills-midjorney-tab">
    <div class="form-group">
        <label for="i-midjorney-key"><b>{{__('Midjorney')}}</b> {{ __('API key') }} (временно сделал видимым)</label>
        <input type="text" name="midjorney_key" id="i-midjorney-key" class="form-control{{ $errors->has('midjorney_key') ? ' is-invalid' : '' }}" value="{{ old('midjorney_key') ?? config('settings.midjorney_key') }}">
        @if ($errors->has('midjorney_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('midjorney_key') }}</strong>
            </span>
        @endif
    </div>

</div>
