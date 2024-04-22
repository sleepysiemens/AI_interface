<div class="d-none">
    <div class="form-group">
        <label for="i-style">{{ __('Style') }}</label>
        <select name="style" id="i-style" class="custom-select{{ $errors->has('style') ? ' is-invalid' : '' }}">
            <option value="">{{ __('None') }}</option>
            @foreach(config('images.styles') as $key => $value)
                <option value="{{ $key }}" @if ((old('style') !== null && old('style') == $key) || (isset($style) && $style == $key && old('style') == null)) selected @endif>{{ __($value) }}</option>
            @endforeach
        </select>
        @if ($errors->has('style'))
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('style') }}</strong>
                            </span>
        @endif
        <small class="form-text text-muted">{{ __('The style of the image.') }}</small>
    </div>

    <div class="form-group">
        <label for="i-medium">{{ __('Medium') }}</label>
        <select name="medium" id="i-medium" class="custom-select{{ $errors->has('medium') ? ' is-invalid' : '' }}">
            <option value="">{{ __('None') }}</option>
            @foreach(config('images.mediums') as $key => $value)
                <option value="{{ $key }}" @if ((old('medium') !== null && old('medium') == $key) || (isset($medium) && $medium == $key && old('medium') == null)) selected @endif>{{ __($value) }}</option>
            @endforeach
        </select>
        @if ($errors->has('medium'))
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('medium') }}</strong>
                            </span>
        @endif
        <small class="form-text text-muted">{{ __('The medium of the image.') }}</small>
    </div>

    <div class="form-group">
        <label for="i-filter">{{ __('Filter') }}</label>
        <select name="filter" id="i-filter" class="custom-select{{ $errors->has('filter') ? ' is-invalid' : '' }}">
            <option value="">{{ __('None') }}</option>
            @foreach(config('images.filters') as $key => $value)
                <option value="{{ $key }}" @if ((old('filter') !== null && old('filter') == $key) || (isset($filter) && $filter == $key && old('filter') == null)) selected @endif>{{ __($value) }}</option>
            @endforeach
        </select>
        @if ($errors->has('filter'))
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('filter') }}</strong>
                            </span>
        @endif
        <small class="form-text text-muted">{{ __('The filter of the image.') }}</small>
    </div>

    <div class="form-group">
        <label for="i-resolution">{{ __('Resolution') }}</label>
        <select name="resolution" id="i-resolution" class="custom-select{{ $errors->has('resolution') ? ' is-invalid' : '' }}">
            @foreach(config('images.resolutions') as $key => $value)
                <option value="{{ $key }}" @if ((old('resolution') !== null && old('resolution') == $key) || (isset($resolution) && $resolution == $key && old('resolution') == null) || (old('resolution') == null && !isset($resolution) && $key == '512x512')) selected @endif>{{ __($value) }}</option>
            @endforeach
        </select>
        @if ($errors->has('resolution'))
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('resolution') }}</strong>
                            </span>
        @endif
        <small class="form-text text-muted">{{ __('The resolution of the image.') }}</small>
    </div>
</div>
