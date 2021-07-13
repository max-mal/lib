<?php
use yii\helpers\ArrayHelper;
use yii\bootstrap4\BootstrapPluginAsset;

BootstrapPluginAsset::register($this);
?>



<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
  <head>
    <?= \yii\helpers\Html::csrfMetaTags() ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">  
    <title>MeowBooks: <?= \yii\helpers\Html::encode($this->title) ?></title>

    <?php $this->head() ?>
    <!-- Favicons -->

    <meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      h3, h4 {
        border-bottom: 1px solid #b9b9b9;
        padding-bottom: 10px;
    }
    footer {
        text-align: center;
        background: #e9ecef;
        padding-top: 15px;
    }
    .gohome {
        position: absolute;
        top: 40px;
        left: 40px;
        cursor: pointer;
    }

    .gohome svg {
        width: 2em;
        height: 2em;
        color: #838586;
    }
    .gohome svg:hover {
        color: black;
    }
    ul.pagination {
        justify-content: center;
    }

    ul.pagination li {
        background: #e9ecef;
        margin: 5px;
        padding: 5px 10px;
        border-radius: 3px;
    }

    ul.pagination li a, ul.pagination li a:visited {
        color: black;
        text-decoration: none;
    }

    ul.pagination li:hover {
        background: #a7a7a7;
    }

    ul.pagination li.active {
        background: #969696;
    }
    footer {
        position: fixed;
        width: 100%;
        bottom: 0;
        right: 0;
        left: 0;
    }

    main {
        margin-bottom: 100px;
    }
    .jumbotron {
        padding: 2rem;
    }
    </style>
  </head>
  <body>
    <?php $this->beginBody() ?>    
    <main role="main">      
      <div class="jumbotron">
        <div class="container">
          <h1 class="display-5 text-center">
            <span class="cat__header">🐈</span>
            <?= \yii\helpers\Html::encode($this->title? $this->title: 'MeowBooks') ?>
                
            </h1>          
        </div>
      </div>

      <div class="container">
        
        <?=$content?>

        <hr>

      </div> <!-- /container -->

    </main>

<footer>
    <div class="container">
        <div class="row">            
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>