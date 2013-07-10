<?php
/* @var $this BtpictureController */
/* @var $model Btpicture */

$this->breadcrumbs = array(
    'Btpictures' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Btpicture', 'url' => array('index')),
    array('label' => 'Create Btpicture', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#btpicture-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление Btpictures</h1>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'btpicture-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(

        array(
            'name' => 'owner',
            'header' => 'Главная',
            'value' => '$data->owner_name . $data->owner_id '
        ),
        
        'id',
        'user_id',
        'filename',
        //'file_ext',

        'alt',
      //  'title',
         array(
            'name' => 'is_main',
            'header' => 'Главная',
            'filter' => array('1' => 'Да', '0' => 'Нет'),
            'value' => '($data->is_main=="1")?("Yes"):("No")'
        ),
        array(
            'name' => 'is_hidden',
            'header' => 'Спрятано',
            'filter' => array('1' => 'Да', '0' => 'Нет'),
            'value' => '($data->is_hidden=="1")?("Yes"):("No")'
        ),
        /* 'created',
          'updated',
         */
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
