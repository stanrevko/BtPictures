<?php
/* @var $this BtpictureController */
/* @var $model Btpicture */

$this->breadcrumbs = array(
    'Btpictures' => array('index'),
    $model->title => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'Create Btpicture', 'url' => array('create')),
    array('label' => 'Manage Btpicture', 'url' => array('index')),
    array('label' => 'Set as Main', 'url' => array('setMain', 'id' => $model->id)),
    array('label' => 'Delete Btpicture', 'url' => array('delete', 'id' => $model->id)),
);
?>

<h1>Редактирование Btpicture <?php echo $model->id; ?></h1>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(        
        array(
            'name' => 'Галерея',
          //  'header' => 'Спрятано',
          //'filter' => array('1' => 'Да', '0' => 'Нет'),
            'value' => ($model->getOwnerFull())
        ),
        'filename',
        //         'file_ext',
        //	'alt',
//		'title',
//		'is_main',
	 array(
            'name' => 'Спрятано',
          //  'header' => 'Спрятано',
          //'filter' => array('1' => 'Да', '0' => 'Нет'),
            'value' => ($model->is_hidden=="1")?("Да"):("Нет")
        ),
        'created',
        'updated',
    ),
));
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>