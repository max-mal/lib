<?php

namespace app\core\jobs;

use Yii;
use yii\base\BaseObject;
use app\core\models\Libbook;
use DOMDocument;

class DownloadJob extends BaseObject implements \yii\queue\JobInterface
{
    public $bookId;
    
    public function execute($queue)
    {
        $book = Libbook::find()->where(['BookId' => $this->bookId])->one();
        
        $data = file_get_contents('https://flibusta.site/b/' . $book->BookId);

        $dom = new DOMDocument;
        $dom->loadHTML($data);

        $image = $book->annotation? '/images/books/' . $book->annotation->nid . '/cover' : null;

        foreach ($dom->getElementsByTagName('img') as $node) {
            if (trim($node->getAttribute('title')) == 'Cover image') {
                $imageFile = file_get_contents('https://flibusta.site' . $node->getAttribute('src'));
                mkdir(Yii::getAlias('@project') . '/web/images/books/' . $book->annotation->nid);
                file_put_contents(Yii::getAlias('@project') . '/web' . $image, $imageFile);
            }
        }
    }
}
