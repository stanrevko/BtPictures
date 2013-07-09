<?php

/**
 * This is the model class for table "btpicture".  Work with files
 *
 * The followings are the available columns in table 'btpicture':
 * @property string $owner_name
 * @property integer $owner_id
 * @property integer $id
 * @property integer $user_id
 * @property string $filename
 * @property string $file_ext
 * @property string $alt
 * @property string $title
 * @property integer $is_main
 * @property integer $is_hidden
 * @property string $created
 * @property string $updated
 */
class Btpicture extends CActiveRecord {

    public $originFile;  // contains base64_encoded data of image file;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Btpicture the static model class
     */

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //get array of config or value from this array by $key
    public static function getConfig($key = null) {
        $confArr = array(
            'dir' => Yii::getPathOfAlias('btpicture'),
            'sizes' => array(
                'size1' => array('width' => '1000', 'aspectRatio' => '1:1', 'height' => '1000'), ///if is set aspectRatio btImage don't use height; aspectRatio mast be like "1:1"
                'size2' => array('width' => '425', 'aspectRatio' => '1:1', 'height' => '425'),
                'size3' => array('width' => '82', 'aspectRatio' => '1:1', 'height' => '82'),
            ),
        );
        if ($key === null)
            return $confArr;
        elseif (isset($confArr[$key]))
            return $confArr[$key];
        else
            return false;
    }

    ///get workdir for this extension
    public static function getDir() {
        return self::getConfig('dir');
    }

    public function uploadOrigin($file, $name) {
        $uploaddir = self::getDir();
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

// Создаем изображение на сервере
        if (file_put_contents($uploaddir . $randomName . "." . $mime, $decodedData)) {
            // Записываем данные изображения в БД
            $this->filename = $randomName;
            $this->file_ext = $mime;
            $this->save();
            return true;
        }
        else
            return false;
    }

    public function getOriginPath() {
        $this->getDir() . DS . "origin" . DS . "$this->filename.$this->file_ext";
    }

    ///get path of image converted to size$number
    public function getSizePath($sizeName) {
        $this->getDir() . DS . $sizeName . DS . "$this->filename.$this->file_ext";
    }

    public function createCopies() {
        ///пропарсити з конфігу всі розміра
        ////відносно параметрів     
        $sizes = $this->getConfig('sizes');
        foreach ($sizes as $sizeName=>$size) {
            Yii::app()->image()->load($this->getOriginPath())->resize($size['width'], $size['height'])->save($this->getSizePath($sizeName));            
        }
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
            array('filename', 'length', 'max' => 30),
            array('file_ext', 'length', 'max' => 5),
            array('alt, title', 'length', 'max' => 200),
            array('created, updated', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('owner_name, owner_id, id, user_id, filename, file_ext, alt, title, is_main, is_hidden, created, updated', 'safe', 'on' => 'search'),
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
            'owner_name' => 'Owner Name',
            'owner_id' => 'Owner',
            'id' => 'ID',
            'user_id' => 'User',
            'filename' => 'Filename',
            'file_ext' => 'File Ext',
            'alt' => 'Alt',
            'title' => 'Title',
            'is_main' => 'Is Main',
            'is_hidden' => 'Is Hidden',
            'created' => 'Created',
            'updated' => 'Updated',
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
        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('filename', $this->filename, true);
        $criteria->compare('file_ext', $this->file_ext, true);
        $criteria->compare('alt', $this->alt, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('is_main', $this->is_main);
        $criteria->compare('is_hidden', $this->is_hidden);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('updated', $this->updated, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}