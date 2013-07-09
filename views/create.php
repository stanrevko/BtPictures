<?php
/* @var $this BtpictureController */
/* @var $model Btpicture */

$this->breadcrumbs=array(
	'Btpictures'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Btpicture', 'url'=>array('index')),
	array('label'=>'Manage Btpicture', 'url'=>array('admin')),
);
?>

<h1>Create Btpicture</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>