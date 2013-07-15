<div class="btp-content">
    <!-- Область для перетаскивания -->
    <div id="drop-files" ondragover="return false">
        <p>Перетащите изображение сюда</p>
        <form id="frm">
            <input type="hidden" value="owner_name" />
            <input type="hidden" value="owner_id" />
            <input type="file" id="uploadbtn" multiple />
        </form>
    </div>
    <!-- Область предпросмотра -->
    <div id="uploaded-holder"> 
        <div id="dropped-files">
            <!-- Кнопки загрузить и удалить, а также количество файлов -->
            <div id="upload-button">
                <center>
                    <span>0 Файлов</span>
                    <a href="#" class="upload">Загрузить</a>
                    <a href="#" class="delete">Удалить</a>
                    <!-- Прогресс бар загрузки -->
                    <div id="loading">
                        <div id="loading-bar">
                            <div class="loading-color"></div>
                        </div>
                        <div id="loading-content"></div>
                    </div>
                </center>
            </div>  
        </div>
    </div>
    <!-- Список загруженных файлов -->
    <div id="file-name-holder">

        <h2>Загруженные файлы</h2>

        <?php foreach ($pictures as $picture) : ?>
            <div id="btpic-<?php echo $picture->id ?>" pic-id="<?php echo $picture->id ?>" class="image btpicture" style="background: url(<?php echo $picture->getUrl('original') ?>)" >
             <div class="btpic-panel">
               <div class="bt-button"><a href="javascript: void(0)">Просмотр</a></div> 
               <div class="bt-button"><a href="javascript: void(0)">Ред.</a></div>
               <div class="bt-button"><a href="javascript: void(0)" onclick="btpDelete(this)" >Удалить</a></div>               
             </div>    
        </div>
    <?php endforeach; ?>
</div>
</div>

<style type="text/css">
    .btpic-panel{
        background-color: rgba(0,0,0,0.7);
        height: 22px;
    }
    
    .btpic-panel .bt-button{
        
    }
    
    .btpic-panel .bt-button a{
    font-size: 14px;
    padding-left: 10px;
    color: #FFE34F;
    }
    
    .btpic-panel .bt-button a:hover{
        color: white;
    }
</style>    

<script>
function btpAction(action, id, callback){
    $.post('', {'action': action, 'id':id}, callback());
}

function btpByInnerEl(el){
    return $(el).closest('.btpicture');
}

function btpIdByEl(el){
    return $(el).closest('.btpicture').attr('pic-id');
}

function btpDelete(el){
    var id = btpIdByEl(el);
    $.post('', {'action': 'delete', 'id':id},$(btpByInnerEl(el)).hide('slow'));
     
}
</script>



