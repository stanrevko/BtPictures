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
        <?php $isMainClass = ($picture->is_main)?  'btp-main' : ""; ?>
            <div id="btpic-<?php echo $picture->id ?>" pic-id="<?php echo $picture->id ?>" class="image btpicture <?php echo $isMainClass?>" style="background: url(<?php echo $picture->getUrl('original') ?>)" >
                <div class="btpic-panel">
                    <div class="bt-button"><a href="javascript: void(0)" onclick="btpSetMain(this)">Главная</a></div> 
                    <div class="bt-button"><a href="javascript: void(0)" onclick="btpUpdate(this)">Ред.</a></div>
                    <div class="bt-button"><a href="javascript: void(0)" onclick="btpDelete(this)" >Удалить</a></div>               
                </div>    
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div id="dialog">
</div>    
