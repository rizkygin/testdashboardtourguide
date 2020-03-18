@extends('auth.auth')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card-group">
        <div class="card p-4" style="border-color: rgba(0, 0, 0, 0.250); border-bottom: 20px solid #007bff"
          <div class="card-body">
            <form action="{{ route('login') }}" method="POST">
              @csrf
              <h1>Login</h1>
              <p class="text-muted">Sign In to your account</p>
              <div class="input-group mb-3">
                <div class="input-group-prepend"><span class="input-group-text">
                    <svg class="c-icon">
                      <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-user"></use>
                    </svg></span></div>
                <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus type="email" placeholder="Email Address">
                
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="input-group mb-4">
                <div class="input-group-prepend"><span class="input-group-text">
                    <svg class="c-icon">
                      <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-lock-locked"></use>
                    </svg></span></div>
                <input class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" type="password" placeholder="Password">
                
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              
              <div class="form-group row">
                  <div class="col">
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                          <label class="form-check-label" for="remember">
                              {{ __('Remember Me') }}
                          </label>
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <button class="btn btn-primary px-4" type="submit">Login</button>
                </div>
                @if (Route::has('password.request'))
                <div class="col-6 text-right">
                  <a class="btn btn-link px-0" href="{{route('password.request')}}">Forgot password?</a>
                </div>
                @endif
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection