<?php

class BtPictureWidget extends CWidget {

    /** @var Gallery Model of gallery to manage */
    public $model;

    /** @var string Route to gallery controller */
    public $controllerRoute = false;
    public $assets;
    public $htmlOptions = array();
    public $breadcrumbs;
    public $menu;

    public function init() {
        require_once ('model' . DIRECTORY_SEPARATOR . 'Btpicture.php');
        $this->assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets', time());
    }

    public function loadModel($id) {
        $model = Btpicture::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        ///security
        elseif (!($model->owner_id == $this->model->id && $model->owner_name == get_class($this->model)))
            throw new CHttpException(401, 'Access denided.');
        return $model;
    }

    protected function actionUpload($filecontents, $name) {
        $bt = new Btpicture();
        ///$filecontents   ///base64 encoded file of image             
        //загружаем этот файл
        $bt->owner_id = $this->model->id;
        $bt->owner_name = get_class($this->model);
        $bt->uploadOrigin($filecontents, $name);
        //создаём копии относительно Btpicture. congig
        $bt->createCopies();
        $bt->save();
        return $bt;
    }

    /** Render widget */
    public function run() {
        ///for ajax actions
        if(isset($_REQUEST['edit'])){
          $picture = $this->loadModel($_REQUEST['id']);                    
                    $this->render("_form",array('model'=>$picture));
                    exit();
                    }
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'edit':
                    $picture = $this->loadModel($_POST['id']);
                    
                    $this->render("update");
                    break;
                case 'delete':
                    $picture = $this->loadModel($_POST['id']);
                    $picture->delete();
                    break;
                case 'setMain':
                    $picture = $this->loadModel($_POST['id']);
                    $picture->setAsMain();
                    break;

                case 'upload':
                    //если передаёться файл в посте
                    if (isset($_POST['value']) && !empty($_POST['value']))
                        $this->actionUpload($_POST['value'], $_POST['name']);
                    break;
                    break; /// two break need because we need show, but we have exit()
                    exit();
            }
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

        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');
        $cs->registerCssFile($this->assets . '/btpicture23.css');
        $cs->registerScriptFile($this->assets . '/btpicture23.js');
        $cs->registerScriptFile($this->assets . '/jquery.Jcrop.min.js');
        $cs->registerScript('btUploadUrl', 'btUploadUrl = "' . Yii::app()->createUrl('btpicture/upload') . '"');
    }

}