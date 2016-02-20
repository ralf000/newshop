<!DOCTYPE html>
<html>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="margin-left: 0">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content" style="height: 100vh;">
            <div class="error-page" style="margin-top: 100px;">
            <h2 class="headline text-yellow"> 404</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> Страница не найдена</h3>
              <p>
                Сожалеем, но запрашиваемая страница не найдена.
              </p>
              <form class="search-form">
                <div class="input-group">
                  <input type="text" name="search" class="form-control" placeholder="Поиск">
                  <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                  </div>
                </div><!-- /.input-group -->
              </form>
              <br>
              <a href="../<?=FrontController::getInstance()->getClearController()?>" class="btn btn-warning">На главную</a>
            </div><!-- /.error-content -->
          </div><!-- /.error-page -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

  </body>
</html>

