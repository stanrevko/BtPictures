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
        $this->assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
    }

    /** Render widget */
    public function run() {
        // include css and js files
        $this->runScripts();

        include_once ('model' . DIRECTORY_SEPARATOR . 'Btpicture.php');
    //    include_once ('model' . DIRECTORY_SEPARATOR . 'UploadHandler.php');
      //        $upload_handler = new UploadHandler();
        $pictures = Btpicture::model()->findAllByAttributes(array('owner_id' => $this->model->id, 'owner_name' => get_class($this->model)));
        $this->render('widgetView', array('pictures' => $pictures));
    }

    protected function runScripts() {
        /** @var $cs CClientScript */
        $cs = Yii::app()->clientScript;

        $cs->registerCssFile('http://blueimp.github.io/cdn/css/bootstrap.min.css');
         $cs->registerCssFile($this->assets . '/btpicture3.css');
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');

        $cs->registerScriptFile($this->assets . '/btpicture.js');
        $cs->registerScript('btUploadUrl','btUploadUrl = "'.Yii::app()->createUrl('btpicture/upload').'"');
       // $cs->registerScriptFile($this->assets . '/jquery.iframe-transport.js');
       
    }
    
    }