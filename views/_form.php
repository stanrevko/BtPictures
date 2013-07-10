<?php
/* @var $this BtpictureController */
/* @var $model Btpicture */
/* @var $form CActiveForm */

?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'btpicture-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

       <?php echo CHtml::image($model->getUrl(),$model->alt, array('style: max-width: 100%;'))?>
    <?php echo $form->errorSummary($model); ?>
 <table>
    <tr class="row">
        <td class="fl_l">
            <?php echo $form->labelEx($model, 'alt'); ?>
            <?php echo $form->textField($model, 'alt', array('size' => 60, 'maxlength' => 200)); ?>
            <?php echo $form->error($model, 'alt'); ?>

        </td>
             <td class="fl_l">
            <?php echo $form->labelEx($model, 'is_main'); ?>		
            <?php echo $form->dropDownList($model, 'is_main', $model->getBooleanArray()); ?>
            <?php echo $form->error($model, 'is_main'); ?>
        </td>
        
    </tr>

    <tr class="row">
        <td class="fl_l">
            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 200)); ?>
            <?php echo $form->error($model, 'title'); ?>
        </td>
   

        <td class="row">
            <?php echo $form->labelEx($model, 'is_hidden'); ?>
            <?php echo $form->dropDownList($model, 'is_hidden', $model->getBooleanArray()); ?>
            <?php echo $form->error($model, 'is_hidden'); ?>
        </td>
    </td>
 </table>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->