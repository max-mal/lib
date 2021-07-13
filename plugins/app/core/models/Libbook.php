<?php

namespace app\core\models;

use Yii;
use DOMDocument;
use yii\helpers\ArrayHelper;
use app\core\jobs\DownloadJob;
use yii\helpers\Url;
use ZipArchive;

/**
 * This is the model class for table "libbook".
 *
 * @property int $BookId
 * @property int $FileSize
 * @property string $Time
 * @property string $Title
 * @property string $Title1
 * @property string $Lang
 * @property int $LangEx
 * @property string $SrcLang
 * @property string $FileType
 * @property string $Encoding
 * @property int $Year
 * @property string $Deleted
 * @property string $Ver
 * @property string $FileAuthor
 * @property int $N
 * @property string $keywords
 * @property string $md5
 * @property string $Modified
 * @property string $pmd5
 * @property int $InfoCode
 * @property int $Pages
 * @property int $Chars
 */
class Libbook extends \yii\db\ActiveRecord
{

    public $rate;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libbook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FileSize', 'LangEx', 'Year', 'N', 'InfoCode', 'Pages', 'Chars'], 'integer'],
            [['Time', 'Modified'], 'safe'],
            [['Title1', 'FileType', 'FileAuthor', 'keywords', 'md5'], 'required'],
            [['Title', 'Title1'], 'string', 'max' => 254],
            [['Lang', 'SrcLang'], 'string', 'max' => 3],
            [['FileType'], 'string', 'max' => 4],
            [['Encoding', 'md5', 'pmd5'], 'string', 'max' => 32],
            [['Deleted'], 'string', 'max' => 1],
            [['Ver'], 'string', 'max' => 8],
            [['FileAuthor'], 'string', 'max' => 64],
            [['keywords'], 'string', 'max' => 255],
            [['md5'], 'unique'],
            ['Rate', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'BookId' => 'Book ID',
            'FileSize' => 'File Size',
            'Time' => 'Time',
            'Title' => 'Title',
            'Title1' => 'Title1',
            'Lang' => 'Lang',
            'LangEx' => 'Lang Ex',
            'SrcLang' => 'Src Lang',
            'FileType' => 'File Type',
            'Encoding' => 'Encoding',
            'Year' => 'Year',
            'Deleted' => 'Deleted',
            'Ver' => 'Ver',
            'FileAuthor' => 'File Author',
            'N' => 'N',
            'keywords' => 'Keywords',
            'md5' => 'Md5',
            'Modified' => 'Modified',
            'pmd5' => 'Pmd5',
            'InfoCode' => 'Info Code',
            'Pages' => 'Pages',
            'Chars' => 'Chars',
        ];
    }

    public function getSeqs()
    {
        return $this->hasMany(Libseqname::class, ['SeqId' => 'SeqId'])->viaTable('libseq', ['BookId' => 'BookId']);
    }

    public function getAnnotation()
    {
        return $this->hasOne(Annotation::class, ['BookId' => 'BookId']);
    }

    private function get_inner_html($node)
    {
        $innerHTML= '';
        $children = $node->childNodes;
        foreach ($children as $child) {
            $innerHTML .= $child->ownerDocument->saveXML($child);
        }

        return $innerHTML;
    }

    public function parseBook()
    {
        $book = $this;
        
        $storage = Yii::getAlias('@project') . '/web/books/';

        $bookDir = $storage . $book->BookId;
        $bookFile = $bookDir . '/book.html';


        $bookFb2 = $this->findBookFb2();

        $chapters = [];
        $images = [];

        if (!file_exists($bookDir)){
            mkdir($bookDir);              
        }
        
        if ($bookFb2) {
            extract($this->parseFb2($bookFb2));                          
        } else {

            if (!file_exists($bookDir) || !file_exists($bookDir . '/flibusta.is/b/' . $book->BookId . '/read')) {
                @mkdir($bookDir);
                shell_exec("cd $bookDir; wget -e robots=off -U 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.6) Gecko/20070802 SeaMonkey/1.1.4' --span-hosts --page-requisites --convert-links http://flibusta.is/b/$book->BookId/read");
            }

            $bookContent = file_get_contents($bookDir . '/flibusta.is/b/' . $book->BookId . '/read');

            error_reporting(E_ERROR);

            $dom = new DOMDocument;
            $dom->loadHTML($bookContent);

            $main = $dom->getElementById('main');

            $data = [];

            foreach ($dom->getElementsByTagName('h3') as $node) {
                $data[] =  trim(strip_tags($this->get_inner_html($node)));
            }


            $mainNodes = [];
            $blocks = [];

            $chapters = [];
            $currentChapter = null;
            $images = [];

            $blocks = $this->parseNode($main, $chapters, $currentChapter, $images);

            if ($currentChapter) {
                $chapters[] = [
                    'title' => $currentChapter,
                    'blocks' => $blocks,
                ];
            }
        }
        

        $chapters = array_values($chapters);
        $bookChapters = [];
        

        file_put_contents($bookDir . '/images.json', json_encode($images));

        foreach ($chapters as $index => $chapter) {
            $chapterFileName = '/chapter-' . $index . '.json';
            $chapterFile = $bookDir . $chapterFileName;

            $bookChapter = BookChapter::find()->where([
                'book_id' => $book->BookId,
                'number' => $index
            ])->one();

            if (!$bookChapter) {
                $bookChapter = new BookChapter();
            }
            
            $bookChapter->book_id = $book->BookId;
            $bookChapter->name = $chapter['title'];
            $bookChapter->file = $chapterFileName;

            file_put_contents($chapterFile, json_encode([
                'time' => time(),
                'blocks' => $chapter['blocks'],
                'version' => '2.18.0',
            ]));

            $bookChapter->number = $index;
            $bookChapter->save();
            $bookChapters[] = $bookChapter;
        }

        return $bookChapters;
    }

    public function getProgress()
    {
        return $this->hasOne(BookProgress::class, ['book_id' => 'BookId'])
            ->andOnCondition(['user_id' => Yii::$app->user->id]);
    }

    public function getAuthor()
    {
        return $this->hasOne(Libavtorname::class, ['AvtorId' => 'AvtorId'])->viaTable('libavtor', ['BookId' => 'BookId']);
    }

    public function getAuthors()
    {
        return $this->hasMany(Libavtorname::class, ['AvtorId' => 'AvtorId'])->viaTable('libavtor', ['BookId' => 'BookId']);
    }

    public function getLibGenres()
    {
        return $this->hasMany(Libgenre::class, ['BookId' => 'BookId']);
    }

    public function getRate() 
    {
        return $this->hasMany(Librate::class, ['BookId' => 'BookId']);
    }

    private function findBook($storage)
    {

        if (file_exists($storage . "/" . $this->BookId . ".fb2")) {
            return [
                'contents' => file_get_contents($storage . "/" . $this->BookId . ".fb2")
            ];
        }

        $dirContent = scandir($storage);
        
        foreach ($dirContent as $entry) {            
            $parts = explode('-', str_replace('.zip', '', $entry));            

            if (count($parts) != 3 ) {
                continue;
            }


            if (!(intval($parts[1]) <= intval($this->BookId) && intval($this->BookId) <= intval($parts[2]) )) {
                continue;
            }
            
            $za = new ZipArchive();
            $za->open($storage . "/" . $entry);

            for ($i=0; $i < $za->numFiles; $i++) {

                $zaFileStat = $za->statIndex($i);                
                if (explode('.', $zaFileStat['name'])[0] == $this->BookId) {
                    $data = $za->getFromIndex($i);
                    $za->close();
                    return [
                        'zip' => $storage . "/" . $entry,
                        'entry' => $zaFileStat,
                        'contents' => $data
                    ];
                }
            }   
            try {
                $za->close();
            } catch (\Throwable $e) {

            }
            
        }    
        return null;  
    }

    public function parseFb2($file)
    {
        $doc = new DOMDocument();
        //Отключаем проверку ошибок
        $doc->strictErrorChecking = false;
        $doc->recover = true;
        //Загружаем содержимое файла
        $load = $doc->loadXML($file['contents'], LIBXML_NOERROR);

        // print_r($file['contents']);

        $body = $doc->getElementsByTagName('body')[0];

        $chapters = [
        ];
        $blocks = [];
        $images = [];
        $currentChapter = null;

        $this->parseFb2Node($body, $chapters, $currentChapter, $blocks, $images);

        if ($currentChapter && count($blocks)){
            $chapters[] = [
                'title' => trim(strip_tags($currentChapter)),
                'blocks' => $blocks,
            ];
        }        

        if (count($chapters[0]['blocks']) == 0) {
            unset($chapters[0]);
        }

        if (count($images)) {
            foreach ($doc->getElementsByTagName('binary') as $binary) {
                file_put_contents(Yii::getAlias('@project') . '/web/books/' . $this->BookId . '/' . $binary->getAttribute('id'), base64_decode($binary->textContent));
            }
        }

        return [
            'chapters' => $chapters,
            'images' => $images,
        ];
    }

    private function parseFb2Node($node, &$chapters, &$currentChapter, &$blocks, &$images)
    {
        if ($node->nodeName == 'section') {                
            foreach ($node->childNodes as $sectionNode) {
                if ($sectionNode->nodeName == 'title') {
                    $chapters[] = [
                        'title' => trim(strip_tags($currentChapter)),
                        'blocks' => $blocks,
                    ];

                    $currentChapter = $this->get_inner_html($sectionNode);
                    $blocks = [];

                    $blocks[] = [
                        'type' => 'header',
                        'data' => [
                            'text' => trim(strip_tags($currentChapter)),
                            'level' => 3,
                        ]
                    ];
                } else {
                    $this->parseFb2Node($sectionNode, $chapters, $currentChapter, $blocks, $images);
                }
            }
        } else if ($node->nodeName == 'p' || $node->nodeName == '#text' || $node->nodeName == 'cite') {
            $text = $this->get_inner_html($node);
            $text = str_replace('<emphasis>', '<i>', $text);
            $text = str_replace('</emphasis>', '</i>', $text);

            if (!trim($text)){
                return;
            }

            $blocks[] = [
                'type' => 'paragraph',
                'data' => [
                    'text' => $node->textContent,
                ]
            ];
        } else if ($node->nodeName == 'image') {
            $url = Yii::$app->request->hostInfo . '/books/' . $this->BookId . '/' . substr($node->getAttribute('l:href'), 1);
            
            $images[] = $url;

            $blocks[] = [
                'type' => 'image',
                'data' => [
                    'file' => [
                        'url' => $url
                    ]
                ]
            ];
        } else if ($node->nodeName == 'a') {
            if (!$node->getAttribute('href')) {
                return;
            }
            $blocks[] = [
                'type' => 'paragraph',
                'data' => [
                    'text' => '<a href="' . $node->getAttribute('href') . '">' . trim($this->get_inner_html($node)) . '</a>',
                ]
            ];
        } else {
            if (count($node->childNodes) && $this->get_inner_html($node)){
                foreach ($node->childNodes as $aNode) {
                    $this->parseFb2Node($aNode, $chapters, $currentChapter, $blocks, $images);
                }
            }
        }
    }

    private function getStorageBookImage($file)
    {
        $path = Yii::getAlias('@project') . '/web/books/' . $this->BookId;

        if (!file_exists($path)){
            mkdir($path);
        }

        $doc = new DOMDocument();
        //Отключаем проверку ошибок
        $doc->strictErrorChecking = false;
        $doc->recover = true;
        //Загружаем содержимое файла
        $load = $doc->loadXML($file['contents'], LIBXML_NOERROR);
        

        $coverNode = $doc->getElementsByTagName('coverpage')[0];

        if (!$coverNode)         {
            return false;
        }
        
        $coverImage = null;
        foreach ($coverNode->childNodes as $node) {            
            if ($node->nodeName == 'image') {
                $coverImage = $node;
                break;
            }
        }        
        $href = $coverImage->getAttribute('l:href');        

        $binaries = $doc->getElementsByTagName('binary');

        foreach ($binaries as $binary) {
            if ($binary->getAttribute('id') != substr($href, 1)) {
                continue;
            }
            
            $image = base64_decode($binary->textContent);
            

            file_put_contents($path . '/cover', $image);

            return true;
            
        }        
        
        return false;
    }

    public function findBookFb2()
    {
        $storage = "/media/pi/DATA/fb2.Flibusta.Net";
        $storageUpdates = "/media/pi/DATA/fb2.Flibusta.Net/updates";

        $bookFile = $this->findBook($storage);
        if (!$bookFile) {
            $bookFile = $this->findBook($storageUpdates);
        }

        if (!$bookFile) {
            $bookFile = $this->downloadBookFb2();
        }

        return $bookFile;
    }

    public function downloadBookFb2()
    {
        $url = "http://flibusta.is/b/" . $this->BookId . "/fb2";
        try {
            $client = new \app\core\utils\ProxyRequest();
            $zip = $client->request($url);
            $path = "/media/pi/DATA/fb2.Flibusta.Net/" . $this->BookId;        
            file_put_contents($path, $zip);
            
            $za = new \ZipArchive();
            $za->open($path);
            $data = $za->getFromIndex(0);

            file_put_contents("$path.fb2", $data);        
            $za->close();
            unlink($path);

            $file = [
                'contents' => $data,
            ];

            $this->getStorageBookImage($file);
            return $file;

        } catch (\Throwable $e) {
            return null;
        }
    }

    public function getImage($promo = false)
    {

        $path = Yii::getAlias('@project') . '/web/books/' . $this->BookId . '/cover';
        $redir = Yii::$app->request->hostInfo . '/books/' . $this->BookId . '/cover';

        if (file_exists($path)){
            return $redir;
        }

        $bookFile = $this->findBookFb2();
     
        if ($bookFile && $this->getStorageBookImage($bookFile)) {
            return $redir;
        }

        $this->genereateBookCover();

        return $redir;
        
    }

    public function getImageUrl($promo = false)
    {
        return Yii::$app->request->hostInfo . Url::to([$promo? '/api/promo/image' : '/api/books/image', 'bookId' => $this->BookId, 'token' => Yii::$app->request->get('token', '')]);
    }


    public function toResponse()
    {

        $author = $this->author;

        $pic = $this->getImageUrl();


        return [
            'id' => $this->BookId,
            'picture' => $pic,
            'title' => $this->Title,
            'description' => $this->annotation? $this->annotation->Body : '',
            'author_id' => $author? $author->AvtorId : 1,
            'progress' => $this->progress? $this->progress->progress : 0,
            'genres' => ArrayHelper::getColumn($this->libGenres, 'GenreId'),            
            'year' => $this->Year,
            'type' => $this->seqs,
            'is_bought' => 1,
            'price' => 0,
            'current_chapter' => $this->progress? $this->progress->chapter: 0,
            'created_at' => $this->Time,            
            'isDeleted' => 0,
            'authors' => $this->authors,
            'rate' => $this->getRate()->sum('Rate'),
        ];
    }

    private function parseNode($main, &$chapters, &$currentChapter, &$images)
    {
        $blocks = [];

        foreach ($main->childNodes as $node) {
            if (in_array($node->nodeName, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'])) {
                if ($node->nodeName == 'h3') {
                    if ($currentChapter) {
                        $chapters[] = [
                            'title' => $currentChapter,
                            'blocks' => $blocks,
                        ];
                    }

                    $blocks = [];
                    $currentChapter = trim(strip_tags($this->get_inner_html($node)));
                }
                

                $blocks[] = [
                    'type' => 'header',
                    'data' => [
                        'text' => trim(strip_tags($this->get_inner_html($node))),
                        'level' => substr($node->nodeName, 1),
                    ]
                ];
            } elseif ($node->nodeName == '#text' || $node->nodeName == 'p' || $node->nodeName == 'div') {
                if (!trim($node->textContent)) {
                    continue;
                }
                $blocks[] = [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => $node->textContent,
                    ]
                ];
            } elseif ($node->nodeName == 'img') {
                $url = Yii::$app->request->hostInfo . '/books/' . $this->BookId . '/flibusta.is/b/' . $this->BookId . '/' . $node->getAttribute('src');
                
                $images[] = $url;

                $blocks[] = [
                    'type' => 'image',
                    'data' => [
                        'file' => [
                            'url' => $url
                        ]
                    ]
                ];
            } elseif ($node->nodeName == 'a') {
                if (!$node->getAttribute('href')) {
                    continue;
                }
                $blocks[] = [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => '<a href="' . $node->getAttribute('href') . '">' . trim($this->get_inner_html($node)) . '</a>',
                    ]
                ];
            } else {
                if (!trim($this->get_inner_html($node))) {
                    continue;
                }

                foreach ($this->parseNode($node, $chapters, $currentChapter, $images) as $block) {
                    $blocks[] = $block;
                }
                // $blocks[] = [
                //     'type' => 'paragraph',
                //     'data' => [
                //         'text' => $this->get_inner_html($node),
                //     ]
                // ];
            }
        }

        return $blocks;
    }


    private function genereateBookCover()
    {

        $im = imagecreatetruecolor(200, 300);

        // Создание цветов
        $white = imagecolorallocate($im, 255, 255, 255);
        $grey = imagecolorallocate($im, 128, 128, 128);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 200, 300, $white);
        imagefilledrectangle($im, 0, 0, 5, 300, $grey);

        // Текст надписи
        $text = $this->Title;
        $arr = explode(' ', $text);

        foreach ($arr as $key => $item) {
            if ($key % 3 == 0) {
                $arr[$key] = "\n" . $arr[$key];
            }
        }

        $text = implode(' ', $arr);
        // Замена пути к шрифту на пользовательский
        $font = '/usr/share/fonts/truetype/freefont/FreeSans.ttf';


        $size = 20;
        $fits = false;
        while (!$fits) {
            $bounds = imagettfbbox($size, 0, $font, $text);
            if ($bounds[2] > 190) {
                $size--;
                continue;
            }

            $fits = true;
        }
        
        imagettftext($im, $size, 0, 10, 80, $black, $font, $text);
        if ($this->author) {
            imagettftext($im, 10, 0, 10, 80 + $bounds[1] + 20, $black, $font, $this->author->FirstName . ' ' . $this->author->MiddleName . "\n" . $this->author->LastName);
        }

        $path = Yii::getAlias('@project') . '/web/books/' . $this->BookId;
        if (!file_exists($path)) {
            mkdir($path);    
        }
        
        imagepng($im, $path . '/cover');
        imagedestroy($im);

        return true;        
    }    
}
