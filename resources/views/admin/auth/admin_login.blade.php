<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{asset('assets/admin/dist/img/favicon.png')}}?{{ time() }}" type="image/x-icon" />
    <title>Log in | {{ config('app.name', 'SRS') }}</title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/dist/css/adminlte.min.css') }}?{{ time() }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/iCheck/square/blue.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-header text-center">
            <a href="{{ URL::to('/admin') }}" class="h1">
                <b>Admin</b>Login
            </a>
        </div>
        <div class="card-body login-card-body">
            @include ('admin.common.error')
            <p class="login-box-msg">Sign in to start your session</p>
            <form method="POST" action="{{ route('admin.signin') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                    <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember"> Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn brn-sm btn-info btn-block btn-flat"><i class="fa fa-sign-in-alt pr-1"></i> Sign In</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ URL::asset('assets/admin/plugins/jQuery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ URL::asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass   : 'iradio_square-blue',
            increaseArea : '20%' // optional
        })
    })
</script>
</body>
</html>
