<?php
/* @var $this BtpictureController */
/* @var $model Btpicture */

$this->breadcrumbs=array(
	'Btpictures'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Btpicture', 'url'=>array('index')),
	array('label'=>'Create Btpicture', 'url'=>array('create')),
	array('label'=>'View Btpicture', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Btpicture', 'url'=>array('admin')),
);
?>

<h1>Update Btpicture <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>