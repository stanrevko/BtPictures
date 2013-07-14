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
                 <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
            </td>
            
    </table>


    <?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">
    // Create variables (in this scope) to hold the API and image size
    var jcrop_api,
    boundx,
    boundy,$preview,$pcnt,$pimg,xsize,ysize;
    $(function(){

    

        // Grab some information about the preview pane
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),

        xsize = $pcnt.width(),
        ysize = $pcnt.height();
      
        console.log('init',[xsize,ysize]);
        
    });
    function crop(){
        $('#target').Jcrop({
            onChange: updatePreview,
            onSelect: updatePreview,
            aspectRatio: xsize / ysize
        },function(){
            // Use the API to get the real image size
            var bounds = this.getBounds();
            boundx = bounds[0];
            boundy = bounds[1];
            // Store the API in the jcrop_api variable
            jcrop_api = this;

            // Move the preview into the jcrop container for css positioning
            $preview.appendTo(jcrop_api.ui.holder);
        });
    }
    function updatePreview(c)
    {
        if (parseInt(c.w) > 0)
        {
            var rx = xsize / c.w;
            var ry = ysize / c.h;

            $pimg.css({
                width: Math.round(rx * boundx) + 'px',
                height: Math.round(ry * boundy) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'
            });
        }
    };




</script>

<style type="text/css">

    /* Apply these styles only when #preview-pane has
       been placed within the Jcrop widget */
    .jcrop-holder #preview-pane {
        display: block;
        position: absolute;
        z-index: 2000;
        top: 10px;
        right: -280px;
        padding: 6px;
        border: 1px rgba(0,0,0,.4) solid;
        background-color: white;

        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;

        -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
        box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
    }

    /* The Javascript code will set the aspect ratio of the crop
       area based on the size of the thumbnail preview,
       specified here */
    #preview-pane .preview-container {
        width: 250px;
        height: 170px;
        overflow: hidden;
    }

</style>