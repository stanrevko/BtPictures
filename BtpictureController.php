<?php

class BtpictureController extends Controller {

    public $pictures_dir = '/images/btpictures';
    public $layout='//layouts/column2';
    public $assets;
    public function filters() {
        return array(
        //    'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function init() {
        parent::init();
        //подгрузка моделей
        include_once ('model' . DIRECTORY_SEPARATOR . 'Btpicture.php');
    }

    public function getViewPath() {
        return $newPath = (__DIR__) . DIRECTORY_SEPARATOR . "views";
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->actionUpdate($id);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Btpicture;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Btpicture'])) {
            $model->attributes = $_POST['Btpicture'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
         $cs = Yii::app()->clientScript;

        //$cs->registerCssFile('http://blueimp.github.io/cdn/css/bootstrap.min.css');
        $cs->registerCoreScript('jquery');        
   $this->assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
   Yii::app()->clientScript->registerScriptFile($this->assets . '/jquery.Jcrop.min.js');
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Btpicture'])) {
            $model->attributes = $_POST['Btpicture'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
   
    public function actionIndex() {

        $dataProvider = new CActiveDataProvider('Btpicture');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }  */

    /**
     * Manages all models.
     */
    
    public function actionIndex() {
        $model = new Btpicture('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Btpicture']))
            $model->attributes = $_GET['Btpicture'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Btpicture the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Btpicture::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Btpicture $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'btpicture-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
 