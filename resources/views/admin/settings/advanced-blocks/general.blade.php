<div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-general-tab">
    <div class="form-group">
        <label for="i-bad-words">{{ __('Bad words') }}</label>
        <textarea name="bad_words" id="i-bad-words" class="form-control{{ $errors->has('bad_words') ? ' is-invalid' : '' }}" rows="3">{{ config('settings.bad_words') }}</textarea>
        @if ($errors->has('bad_words'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('bad_words') }}</strong>
            </span>
        @endif
        <small class="form-text text-muted">{{ __('One per line.') }}</small>
    </div>
</div>
