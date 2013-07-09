<?php
/* @var $this BtpictureController */
/* @var $model Btpicture */

$this->breadcrumbs=array(
	'Btpictures'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Btpicture', 'url'=>array('index')),
	array('label'=>'Create Btpicture', 'url'=>array('create')),
	array('label'=>'Update Btpicture', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Btpicture', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Btpicture', 'url'=>array('admin')),
);
?>

<h1>View Btpicture #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'owner_name',
		'owner_id',
		'id',
		'user_id',
		'filename',
		'file_ext',
		'alt',
		'title',
		'is_main',
		'is_hidden',
		'created',
		'updated',
	),
)); ?>
