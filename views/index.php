<?php
/* @var $this BtpictureController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Btpictures',
);

$this->menu=array(
	array('label'=>'Create Btpicture', 'url'=>array('create')),
	array('label'=>'Manage Btpicture', 'url'=>array('admin')),
);
?>

<h1>Btpictures</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
