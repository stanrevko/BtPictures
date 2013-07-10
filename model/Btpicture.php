<?php

/**
 * This is the model class for table "btpicture".  Work with files
 *
 * The followings are the available columns in table 'btpicture':
 * @property string $owner_name
 * @property integer $owner_id
 * @property integer $id
 * @property integer $user_id
 * @property string $file_name
 * @property string $file_ext
 * @property string $filename  =  "$file_name.$file_ext"
 * @property string $alt
 * @property string $title
 * @property integer $is_main
 * @property integer $is_hidden
 * @property string $created
 * @property string $updated
 */
class Btpicture extends CActiveRecord {

    public $originFile;  // contains base64_encoded data of image file;
  //  public $owner; // for search
    public function getOwner(){
       return  "$this->owner_name-$this->owner_id";
    }
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //get array of config or value from this array by $key
    public static function getConfig($key = null) {
        $confArr = array(
            'dir' => Yii::getPathOfAlias('btpicture'),
            'sizes' => array(
                'size1' => array('width' => '1000', 'aspectRatio' => '1:1', 'height' => '1000'), ///if is set aspectRatio btImage don't use height; aspectRatio mast be like "1:1"
                'size2' => array('width' => '425', 'aspectRatio' => '1:1', 'height' => false),
                'size3' => array('width' => '82', 'aspectRatio' => '1:1', 'height' => false),
            ),
        );
        if ($key === null)
            return $confArr;
        elseif (isset($confArr[$key]))
            return $confArr[$key];
        else
            return false;
    }

    ///get workdir for this extension/  and if is set $sizeName return dir of this size
    public static function getDir($sizeName = null) {
        $dir = self::getConfig('dir');
        if ($sizeName === null) {
            return $dir . DS;
        } else {
            return $dir . DS . $sizeName . DS;
        }
    }

    public function getUrl($sizeName = null) {
        if ($sizeName === null)
            $sizeName = "original";
        return "/images/btpicture/" . $sizeName . "/" . $this->filename;
    }

    //return file_name with ext;
    public function getFilename() {
        return "$this->file_name.$this->file_ext";
    }

    public function uploadOrigin($file, $name) {
        $uploaddir = $this->getDir('original');

        // Все загруженные файлы помещаются в эту папку
        // Получаем расширение файла
        $getMime = explode('.', $name);
        $mime = end($getMime);

        // Выделим данные
        $data = explode(',', $file);

        // Декодируем данные, закодированные алгоритмом MIME base64
        $encodedData = str_replace(' ', '+', $data[1]);
        $decodedData = base64_decode($encodedData);
        // Вы можете использовать данное имя файла, или создать произвольное имя.
        // Мы будем создавать произвольное имя!
        $randomName = substr_replace(sha1(microtime(true)), '', 12);

        $this->file_name = $randomName;
        $this->file_ext = $mime;
        ///создаем директорю если не существует

        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        // Создаем изображение на сервере
        if (file_put_contents($this->getOriginalPath(), $decodedData)) {
            // Записываем данные изображения в БД
            return true;
        }
        else
            return false;
    }

    ///get path of image converted to size$number
    public function getFilePath($sizeName) {
        return $this->getDir($sizeName) . $this->getFilename();
    }

    ///get path of image converted to size$number
    public function getFileLink($sizeName) {
        return $this->getDir($sizeName) . $this->getFilename();
    }

    public function getOriginalPath() {
        return $this->getFilePath("original");
    }

    public function createCopies() {
        require_once '/../helpers/BtImage.php';
        ///пропарсити з конфігу всі розміра
        ////відносно параметрів     
        $sizes = $this->getConfig('sizes');
        foreach ($sizes as $sizeName => $size) {

            $uploaddir = $this->getDir($sizeName);
            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }
            BtImage::resize($this->getOriginalPath(), $uploaddir . $this->getFilename(), $size['width'], $size['height']);
        }
    }

    public function checkFile($sizeName) {
        return file_exists($this->getFilePath($sizeName));
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'btpicture';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('owner_id, user_id, is_main, is_hidden', 'numerical', 'integerOnly' => true),
            array('owner_name', 'length', 'max' => 50),
            array('file_name', 'length', 'max' => 30),
            array('file_ext', 'length', 'max' => 5),
            array('alt, title', 'length', 'max' => 200),
            array('created, updated', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('owner_name, owner_id, id, user_id, file_name, file_ext, alt, title, is_main, is_hidden, created, updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'owner_name' => 'Имя модели-групирования',
            'owner_id' => 'Id модели-гурипрования',
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'file_name' => 'Имя файла',
            'file_ext' => 'Расширение',
            'alt' => 'Альтернативный текст',
            'title' => 'Описание картинки',
            'is_main' => 'Главная картинка',
            'is_hidden' => 'Спрятать',
            'created' => 'Создано',
            'updated' => 'Редактировано',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('owner_name', $this->owner_name, true);
        $criteria->compare('owner_id', $this->owner_id);
        $criteria->compare('owner', $this->owner);
        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('file_ext', $this->file_ext, true);
        $criteria->compare('alt', $this->alt, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('is_main', $this->is_main);
        $criteria->compare('is_hidden', $this->is_hidden);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('updated', $this->updated, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 40,
                    ),
                ));
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->user_id = Yii::app()->user->id;
            $this->updated = date("Y-m-d H:i:s");
            if ($this->isNewRecord)
                $this->created = date("Y-m-d H:i:s");
            return true;
        }
        else
            return false;
    }

    ///after deleting of model delete files
    public function afterDelete() {

        parent::afterDelete();

        $sizes = $this->getConfig('sizes');
        //delete original pic
        $sizeName = 'original';
        if ($this->checkFile($sizeName))
            @unlink($this->getFilePath($sizeName));
        //delete all sizes
        foreach ($sizes as $sizeName => $size) {
            $this->getFilePath($sizeName);
            if ($this->checkFile($sizeName))
                @unlink($this->getFilePath($sizeName));
        }
    }

    public function getBooleanArray() {
        return array(0 => 'Нет', 1 => 'Да');
    }

}