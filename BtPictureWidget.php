<?php

/**
 * Widget to manage gallery.
 * Requires Twitter Bootstrap styles to work.
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */
class BtPictureWidget extends CWidget {

    /** @var Gallery Model of gallery to manage */
    public $model;

    /** @var string Route to gallery controller */
    public $controllerRoute = false;
    public $assets;
    public $htmlOptions = array();

    public function init() {
        $this->assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets', time());
    }

    /** Render widget */
    public function run() {
        require_once ('model' . DIRECTORY_SEPARATOR . 'Btpicture.php');
        //если передаёться файл в посте


        if (isset($_POST['value'])) {
            $bt = new Btpicture();
            // Вытаскиваем необходимые данные
            $file = $_POST['value'];
            $name = $_POST['name']; ///base64 encoded file of image
            //загружаем этот файл
            $bt->owner_id = $this->model->id;
            $bt->owner_name = get_class($this->model);
            $bt->uploadOrigin($file, $name);
           //создаём копии относительно Btpicture. congig
            $bt->createCopies();                        
            $bt->save();
           //exit(json_encode($bt->attributes));
        }

        // include css and js files
        $this->runScripts();
        //    include_once ('model' . DIRECTORY_SEPARATOR . 'UploadHandler.php');
        //        $upload_handler = new UploadHandler();
        $pictures = Btpicture::model()->findAllByAttributes(array('owner_id' => $this->model->id, 'owner_name' => get_class($this->model)));
        $this->render('widgetView', array('pictures' => $pictures));
    }

    protected function runScripts() {
        /** @var $cs CClientScript */
        $cs = Yii::app()->clientScript;

        //$cs->registerCssFile('http://blueimp.github.io/cdn/css/bootstrap.min.css');
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');
        $cs->registerCssFile($this->assets . '/btpicture5.css');
        $cs->registerScriptFile($this->assets . '/btpicture5.js');
        $cs->registerScriptFile($this->assets . '/jquery.Jcrop.min.js');
        $cs->registerScript('btUploadUrl', 'btUploadUrl = "' . Yii::app()->createUrl('btpicture/upload') . '"');
        // $cs->registerScriptFile($this->assets . '/jquery.iframe-transport.js');
    }

}