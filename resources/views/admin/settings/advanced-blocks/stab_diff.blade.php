<div class="tab-pane fade" id="pills-stab_diff" role="tabpanel" aria-labelledby="pills-stab_diff-tab">
    <div class="form-group">
        <label for="i-stab_diff-key"><b>{{__('Stab Diff')}}</b> {{ __('API key') }} (временно сделал видимым)</label>
        <input type="text" name="stab_diff_key" id="i-stab_diff-key" class="form-control{{ $errors->has('stab_diff_key') ? ' is-invalid' : '' }}" value="{{ old('stab_diff_key') ?? config('settings.stab_diff_key') }}">
        @if ($errors->has('stab_diff_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('stab_diff_key') }}</strong>
            </span>
        @endif
    </div>

</div>
