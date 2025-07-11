<div class="card border border-primary">
    <div class="card-body">
        <form action="{{ route('admin.api-setting.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{ __('admin.Api Host') }}</label>
                <div class="input-group ">
                    <input value="{{ $settings['site_api_host'] }}" name="site_api_host" type="text" class="form-control">

                    @error('site_api_host')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('admin.Api Key') }}</label>
                <div class="input-group ">
                    <input value="{{ $settings['site_api_key'] }}" name="site_api_key" type="text" class="form-control">

                    @error('site_api_key')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
        </form>
    </div>
</div>

