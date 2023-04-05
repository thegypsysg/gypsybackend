<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>The SYRINGE | Log in</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/css/font-awesome.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/css/ionicons.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/css/AdminLTE.min.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/css/blue.css') }}">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
   </head>
   <body class="hold-transition login-page">
      <div class="login-box">
         <div class="login-logo">
            <a href="#"><b>The </b>SYRINGE</a>
         </div>
         <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="{{ route('login') }}" method="POST">
               @csrf
               <div class="form-group has-feedback">
                  <input type="email" name="username" class="form-control" placeholder="Email">
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  @if ($errors->has('username'))
                     <small class="text-danger">{{ $errors->first('username') }}</small>
                  @endif
               </div>
               <div class="form-group has-feedback">
                  <input type="password" name="password" class="form-control" placeholder="Password">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  @if ($errors->has('password'))
                     <small class="text-danger">{{ $errors->first('password') }}</small>
                  @endif
               </div>
               <div class="row">
                  <div class="col-xs-8">
                     <div class="checkbox icheck">
                        <label>
                        <input type="checkbox"> Remember Me
                        </label>
                     </div>
                  </div>
                  <div class="col-xs-4">
                     <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                  </div>
               </div>
            </form>
            
         </div>
      </div>
      <script src="/backend/js/jquery.min.js"></script>
      <script src="/backend/js/bootstrap.min.js"></script>
      <script src="/backend/js/icheck.min.js"></script>
      <script>
         $(function () {
           $('input').iCheck({
             checkboxClass: 'icheckbox_square-blue',
             radioClass: 'iradio_square-blue',
             increaseArea: '20%' /* optional */
           });
         });
      </script>
   </body>
</html>