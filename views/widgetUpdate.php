<?php
/* @var $this BtpictureController */
/* @var $model Btpicture */
/* @var $form CActiveForm */

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
            'value' => ($model->is_hidden == "1") ? ("Да") : ("Нет")
        ),
        'created',
        'updated',
    ),
));
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'btpicture-form',
        'action' => '?action=update',
        'enableAjaxValidation' => false,
            ));
    ?>
    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr class="row">
            <td>
                <?php echo CHtml::image($model->getUrl(), $model->alt, array('id' => 'target', 'style' => 'max-width: 100%;')) ?>
            </td>
            <td >
                <div id="preview-pane">
                    <div class="preview-container">
                        <img src="<?php echo $model->getUrl() ?>" class="jcrop-preview" alt="Preview" />
                    </div>
                </div>
            </td>
        </tr>
        <tr class="row">
            <td>
                <?php echo Chtml::hiddenField('action', 'update'); ?>
                <?php echo Chtml::hiddenField('id', $model->id); ?>
                <?php echo $form->labelEx($model, 'alt'); ?>
                <?php echo $form->textField($model, 'alt', array('size' => 60, 'maxlength' => 200)); ?>
                <?php echo $form->error($model, 'alt'); ?>

            </td>
            <td >
                <?php echo $form->labelEx($model, 'is_hidden'); ?>
                <?php echo $form->dropDownList($model, 'is_hidden', $model->getBooleanArray()); ?>
                <?php echo $form->error($model, 'is_hidden'); ?>
            </td>

        </tr>

        <tr class="row">
            <td >
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 200)); ?>
                <?php echo $form->error($model, 'title'); ?>
            </td>
            <td >            
            </td>

    </table>

    <?php $this->endWidget(); ?>

</div><!-- form -->


