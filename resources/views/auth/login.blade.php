@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form id="login_success" method="post" action="{{ URL("/kitlogin") }}">
                        {!! csrf_field() !!}
                        <input id="csrf_nonce" type="hidden" name="csrf" />
                        <input id="code" type="hidden" name="code" />
                    </form>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail or UserName</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-4">
                                <span onclick="loginWithSMS();" class="btn btn-primary btn-block">
                                    Login with SMS
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span onclick="loginWithEmail();" class="btn btn-primary btn-block">
                                    Login with Email
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{!! url('facebook/redirect') !!}" class="btn btn-primary btn-block">
                                    Login with facebook
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        <script type="text/javascript">
    
          // initialize Account Kit with CSRF protection
            AccountKit_OnInteractive = function(){
                AccountKit.init(
                  {
                    appId:'1461990380583214', 
                    state:"{{ csrf_token() }}", 
                    version:'v1.1'
                  }
                );
            };

              // login callback
              function loginCallback(response) {
                console.log(response);
                if (response.status === "PARTIALLY_AUTHENTICATED") {
                  document.getElementById("code").value = response.code;
                  document.getElementById("csrf_nonce").value = response.state;
                  document.getElementById("login_success").submit();
                }
                else if (response.status === "NOT_AUTHENTICATED") {
                  // handle authentication failure
                   console.log("NOT_AUTHENTICATED");
                }
                else if (response.status === "BAD_PARAMS") {
                  // handle bad parameters
                  console.log("BAD_PARAMS");
                }
              }

              function loginWithSMS(){
                AccountKit.login("PHONE",{}, loginCallback);
              }

              function loginWithEmail(){
                AccountKit.login("EMAIL", {}, loginCallback);
              }
        </script>
@endsection