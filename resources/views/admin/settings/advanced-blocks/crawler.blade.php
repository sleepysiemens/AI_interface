<div class="tab-pane fade" id="pills-crawler" role="tabpanel" aria-labelledby="pills-crawler-tab">
    <div class="form-group">
        <label for="i-request-user-agent">{{ __('User-Agent') }}</label>
        <input type="text" name="request_user_agent" id="i-request-user-agent" class="form-control{{ $errors->has('request_user_agent') ? ' is-invalid' : '' }}" value="{{ old('request_user_agent') ?? config('settings.request_user_agent') }}">
        @if ($errors->has('request_user_agent'))
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('request_user_agent') }}</strong>
                            </span>
        @endif
    </div>

    <div class="form-group">
        <label for="i-request-proxy">{{ __('Proxies') }}</label>
        <textarea name="request_proxy" id="i-request-proxy" class="form-control{{ $errors->has('request_proxy') ? ' is-invalid' : '' }}" rows="3" placeholder="http://username:password@ip:port
">{{ config('settings.request_proxy') }}</textarea>
        @if ($errors->has('request_proxy'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('request_proxy') }}</strong>
            </span>
        @endif
        <small class="form-text text-muted">{{ __('One per line.') }}</small>
    </div>
</div>
