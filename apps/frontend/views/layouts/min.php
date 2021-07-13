<?php
use amylabs\panel\assets\ThemeAsset;

ThemeAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= \yii\helpers\Html::csrfMetaTags() ?>
    <title><?= \yii\helpers\Html::encode($this->title) ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <style type="text/css">
        .main, .footer {
            background: white;
            max-width: 1024px;
            margin: auto;
            text-align: center;
            padding: 10px;
        }
        .footer {
            margin-top: 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-around;
        }
        .requirements table {
            margin: auto;
        }

        html {
            background: grey;
        }

        h2 {
            margin: 0;
        }
        button {
            margin: 10px;
            cursor: pointer;
        }
    </style>
    <div class="main">
        <?=$content?>
    </div>
    <div class="footer">        
        <a href="/backend">Backend</a>        
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>