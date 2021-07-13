<?php

namespace app\core\frontend\controllers;

use Yii;
use app\core\models\Libbook;
use app\core\models\Libavtorname;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AvtorController implements the CRUD actions for Libavtorname model.
 */
class LinkController extends Controller
{
	public function actionBook($id)
	{
		$book = Libbook::findOne($id);
		if (!$book) {
			throw new NotFoundHttpException();
		}		
		return $this->render('book', ['id' => $id, 'book' => $book]);
	}

	public function actionAuthor($id)
	{
		$author = Libavtorname::findOne($id);
		if (!$author) {
			throw new NotFoundHttpException();
		}		
		return $this->render('author', ['id' => $id, 'author' => $author]);
	}
}