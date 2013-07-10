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
	array('label'=>'Manage Btpicture', 'url'=>array('')),
);
?>

<h1>Редактирование Btpicture <?php echo $model->id; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'owner',
	//	'id',
	//	'user_id',
		'filename',
       //         'file_ext',
	//	'alt',
//		'title',
//		'is_main',
//		'is_hidden',
		'created',
		'updated',
	),
)); ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>