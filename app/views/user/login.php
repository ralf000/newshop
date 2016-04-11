<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Войти</h2>
                    <form action="/user/login" method="post">
                        <div class="form-group">
                            <label for="login">Логин*</label>
                            <input type="text" name="username" class="form-control" id="login" placeholder="Логин" />
                        </div>
                        <div class="form-group">
                            <label for="pass">Пароль*</label>
                            <input type="password" name="pass" class="form-control" id="pass" placeholder="Пароль"/>
                        </div>
                        <span>
                            <input type="checkbox" name="remember" value="1" class="checkbox"> 
                            Запомнить меня
                        </span>
                        <button type="submit" class="btn btn-default">Войти</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">ИЛИ</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Зарегистрироваться</h2>
                    <form action="registration" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="login">Логин*</label>
                            <input type="text" name="username" id="login" class="form-control" placeholder="Логин"/>
                        </div>
                        <div class="form-group">
                            <label for="fullName">ФИО</label>
                            <input type="text" name="fullName" id="fullName" class="form-control" placeholder="ФИО"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email"/>
                        </div>
                        <div class="form-group">
                            <a href="#" class="phone_plus"><i class="fa fa-plus-circle"></i></a> <label>Добавить телефон</label>
                        </div>
                        <div class="form-group">
                            <a href="#" class="address_plus"><i class="fa fa-plus-circle"></i></a> <label>Добавить Адрес</label>
                        </div>
                        <div class="form-group">
                            <label for="pass">Пароль</label>
                            <input type="password" name="pass" id="pass" class="form-control" placeholder="Пароль"/>
                        </div>
                        <div class="form-group">
                            <label for="dpass">Повторите пароль</label>
                            <input type="password" name="dpass" id="dpass" class="form-control" placeholder="Пароль"/>
                        </div>
                        <div class="form-group">
                            <label for="photo">Аватар</label>
                            <input type="file" name="photo" id="photo"/>
                        </div>
                        <button type="submit" class="btn btn-default">Зарегистрироваться</button>
                    </form>

                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->
<script type="text/javascript" src="/app/template/js/user/login.js"></script>