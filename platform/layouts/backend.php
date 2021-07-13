<?php
use yii\helpers\ArrayHelper;
use platform\assets\SBAdminAsset;
use app\core\assets\QueueAsset;
use yii\helpers\Url;
use yii\bootstrap4\Breadcrumbs;

SBAdminAsset::register($this);


$logo = '';
$userLogo = '/logo/project-default.png';
$user = Yii::$app->user->identity;
if ($user && $user->profile && $user->profile->avatar) {
    $userLogo = $user->profile->avatar;
}


?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <?= \yii\helpers\Html::csrfMetaTags() ?>
    <title><?= \yii\helpers\Html::encode($this->title) ?></title>  
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">  

    <?php $this->head() ?>

</head>

<body id="page-top">
    <?php $this->beginBody() ?>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=\yii\helpers\Url::to(['/'])?>">
        <div class="sidebar-brand-icon">
          <img src="/logo/project-default.png" style="width: 40px">
        </div>
        <div class="sidebar-brand-text mx-3"><?= \yii\helpers\Html::img($logo) ?><?= Yii::$app->name; ?></div>
      </a>
        <?php if ($user) : ?>
        <?php foreach (Yii::$app->pluginManager->getNavigation() as $key => $item) : ?>
        <li class="nav-item">
            <a class="nav-link <?=isset($item['items'])? 'collapsed' : ''?>" href="<?=\yii\helpers\Url::to($item['url'])?>" 
                <?php if (isset($item['items'])) : ?>
                    data-toggle="collapse" data-target="#<?=$key?>-collapse" aria-expanded="true" aria-controls="<?=$key?>-collapse"
                <?php endif;?>
                >
              <i class="<?=$item['icon']?>"></i>
              <span><?=$item['label']?></span>
            </a>
            <?php if (isset($item['items'])) : ?>
                <div id="<?=$key?>-collapse" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <?php foreach ($item['items'] as $subItem) : ?>
                            <a class="collapse-item" href="<?=\yii\helpers\Url::to($subItem['url'])?>"><?=$subItem['label']?></a>
                        <?php endforeach;?>
                    </div>
                </div>
            <?php endif;?>
        </li>
        <?php endforeach;?>
        <?php else : ?>
        <li class="nav-item">
            <a class="nav-link" href="<?=Url::to(['/login'])?>">
              <i class="fa fa-user"></i>
              <span>Войти в систему</span>
            </a>
        </li>
        <?php endif;?>
      

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">



            

            <!-- Nav Item - User Information -->
        <?php if ($user) : ?>

            <div class="topbar-divider d-none d-sm-block"></div>


            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$user->getFullName()?></span>
                <img class="img-profile rounded-circle" src="<?=$userLogo?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?=Url::to(['/profile', 'id' => $user->id])?>">
                  <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Профиль
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Настройки
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fa fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Выйти
                </a>
              </div>
            </li>
        <?php endif;?>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);?>
        <?php if ($user) : ?>
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?=$this->title?></h1>
            <?php foreach (Yii::$app->session->getAllFlashes() as $type => $data) : ?>
                <?php
                    $color = 'secondary';
                switch ($type) {
                    case 'error':
                        $color = 'danger';
                        break;

                    case 'succcess':
                        $color = 'succcess';
                        break;
                        
                    default:
                        $color = $type;
                        break;
                }
                ?>
                <div class="alert alert-<?=$color?>" role="alert">
                    <?=$data?>
                </div>
                <?php
                    Yii::$app->session->removeFlash($type);
                ?>
            <?php endforeach;?>
        <?php endif;?>
            <?= $content; ?>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Выйти из системы?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Вы действительно хотите выйти из системы?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Отмена</button>
          <a class="btn btn-primary" href="<?=Url::to(['/logout'])?>">Выйти</a>
        </div>
      </div>
    </div>
  </div>
    
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>