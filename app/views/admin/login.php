
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>New</b>SHOP</a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
          <!--<p class="login-box-msg">Sign in to start your session</p>-->
            <form action="login" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="username" placeholder="Логин">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="pass" placeholder="Пароль">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-7" style="margin-left: 20px;">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember" value="1"> Запомнить меня
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Войти</button>
                    </div><!-- /.col -->
                </div>
            </form>

            <!--        <div class="social-auth-links text-center">
                      <p>- OR -</p>
                      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
                    </div> /.social-auth-links -->

            <a href="#">Я забыл пароль</a><br>
            <!--<a href="register.html" class="text-center">Register a new membership</a>-->

        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>
</html>
