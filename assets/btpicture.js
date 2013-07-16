var $ = jQuery.noConflict();
$(document).ready(function() {
    // В dataTransfer помещаются изображения которые перетащили в область div
    jQuery.event.props.push('dataTransfer');
	
    // Максимальное количество загружаемых изображений за одни раз
    var maxFiles = 10;
	
    // Оповещение по умолчанию
    var errMessage = 0;
	
    // Кнопка выбора файлов
    var defaultUploadBtn = $('#uploadbtn');
	
    // Массив для всех изображений
    var dataArray = [];
	
    // Область информер о загруженных изображениях - скрыта
    $('#uploaded-files').hide();
	
    // Метод при падении файла в зону загрузки
    $('#drop-files').on('drop', function(e) {	
        // Передаем в files все полученные изображения
        var files = e.dataTransfer.files;
        // Проверяем на максимальное количество файлов
        if (files.length <= maxFiles) {
            // Передаем массив с файлами в функцию загрузки на предпросмотр
            loadInView(files);
        } else {
            alert('Вы не можете загружать больше '+maxFiles+' изображений!'); 
            files.length = 0;
            return;
        }
    });
	
    // При нажатии на кнопку выбора файлов
    defaultUploadBtn.on('change', function() {
        // Заполняем массив выбранными изображениями
        var files = $(this)[0].files;
        // Проверяем на максимальное количество файлов
        if (files.length <= maxFiles) {
            // Передаем массив с файлами в функцию загрузки на предпросмотр
            loadInView(files);
            // Очищаем инпут файл путем сброса формы
            $('#frm').each(function(){
                this.reset();
            });
        } else {
            alert('Вы не можете загружать больше '+maxFiles+' изображений!'); 
            files.length = 0;
        }
    });
	
    // Функция загрузки изображений на предросмотр
    function loadInView(files) {
        // Показываем обасть предпросмотра
        $('#uploaded-holder').show();
		
        // Для каждого файла
        $.each(files, function(index, file) {
						
            // Несколько оповещений при попытке загрузить не изображение
            if (!files[index].type.match('image.*')) {
				
                if(errMessage == 0) {
                    $('#drop-files p').html('Эй! только изображения!');
                    ++errMessage
                }
                else if(errMessage == 1) {
                    $('#drop-files p').html('Стоп! Загружаются только изображения!');
                    ++errMessage
                }
                else if(errMessage == 2) {
                    $('#drop-files p').html("Не умеешь читать? Только изображения!");
                    ++errMessage
                }
                else if(errMessage == 3) {
                    $('#drop-files p').html("Хорошо! Продолжай в том же духе");
                    errMessage = 0;
                }
                return false;
            }
			
            // Проверяем количество загружаемых элементов
            if((dataArray.length+files.length) <= maxFiles) {
                // показываем область с кнопками
                $('#upload-button').css({
                    'display' : 'block'
                });
            } 
            else {
                alert('Вы не можете загружать больше '+maxFiles+' изображений!');
                return;
            }
			
            // Создаем новый экземпляра FileReader
            var fileReader = new FileReader();
            // Инициируем функцию FileReader
            fileReader.onload = (function(file) {
					
                return function(e) {
                    // Помещаем URI изображения в массив
                    dataArray.push({
                        action: 'upload',
                        name : file.name, 
                        value : this.result
                    });
                    addImage((dataArray.length-1));
                }; 
						
            })(files[index]);
            // Производим чтение картинки по URI
            fileReader.readAsDataURL(file);
        });
        return false;
    }
		
    // Процедура добавления эскизов на страницу
    function addImage(ind) {
        // Если индекс отрицательный значит выводим весь массив изображений
        if (ind < 0 ) { 
            start = 0;
            end = dataArray.length; 
        } else {
            // иначе только определенное изображение 
            start = ind;
            end = ind+1;
        } 
        // Оповещения о загруженных файлах
        if(dataArray.length == 0) {
            // Если пустой массив скрываем кнопки и всю область
            $('#upload-button').hide();
            $('#uploaded-holder').hide();
        } else if (dataArray.length == 1) {
            $('#upload-button span').html("Был выбран 1 файл");
        } else {
            $('#upload-button span').html(dataArray.length+" файлов были выбраны");
        }
        // Цикл для каждого элемента массива
        for (i = start; i < end; i++) {
            // размещаем загруженные изображения
            if($('#dropped-files > .image').length <= maxFiles) { 
                $('#dropped-files').append('<div id="img-'+i+'" class="image" style="background: url('+dataArray[i].value+'); background-size: cover;"> <a href="#" id="drop-'+i+'" class="drop-button">Удалить изображение</a></div>'); 
            }
        }
        return false;
    }
	
    // Функция удаления всех изображений
    function restartFiles() {
	
        // Установим бар загрузки в значение по умолчанию
        $('#loading-bar .loading-color').css({
            'width' : '0%'
        });
        $('#loading').css({
            'display' : 'none'
        });
        $('#loading-content').html(' ');
		
        // Удаляем все изображения на странице и скрываем кнопки
        $('#upload-button').hide();
        $('#dropped-files > .image').remove();
        $('#uploaded-holder').hide();
	
        // Очищаем массив
        dataArray.length = 0;
		
        return false;
    }
	
    // Удаление только выбранного изображения 
    $("#dropped-files").on("click","a[id^='drop']", function() {
        // получаем название id
        var elid = $(this).attr('id');
        // создаем массив для разделенных строк
        var temp = new Array();
        // делим строку id на 2 части
        temp = elid.split('-');
        // получаем значение после тире тоесть индекс изображения в массиве
        dataArray.splice(temp[1],1);
        // Удаляем старые эскизы
        $('#dropped-files > .image').remove();
        // Обновляем эскизи в соответсвии с обновленным массивом
        addImage(-1);		
    });
	
    // Удалить все изображения кнопка 
    $('#dropped-files #upload-button .delete').click(restartFiles);
	
    // Загрузка изображений на сервер
    $('#upload-button .upload').click(function() {
		
        // Показываем прогресс бар
        $("#loading").show();
        // переменные для работы прогресс бара
        var totalPercent = 100 / dataArray.length;
        var x = 0;
		
        $('#loading-content').html('Загружен '+dataArray[0].name);
        // Для каждого файла
        $.each(dataArray, function(index, file) {                    
            // загружаем страницу и передаем значения, используя HTTP POST запрос 
            $.post('', dataArray[index], function(data) {
			
                var fileName = dataArray[index].name;
                ++x;
				
                // Изменение бара загрузки
                $('#loading-bar .loading-color').css({
                    'width' : totalPercent*(x)+'%'
                });
                // Если загрузка закончилась
                if(totalPercent*(x) == 100) {
                    // Загрузка завершена
                    $('#loading-content').html('Загрузка завершена!');
					
                    // Вызываем функцию удаления всех изображений после задержки 1 секунда
                    setTimeout(restartFiles, 1000);
                    //обновляем картинки
                    $('#file-name-holder').html($(data).find('#file-name-holder').html());
                // если еще продолжается загрузка	
                } else if(totalPercent*(x) < 100) {
                    // Какой файл загружается
                    $('#loading-content').html('Загружается '+fileName);
                }
				
            // Формируем в виде списка все загруженные изображения
            // data формируется в upload.php
                                  
				
            });
        });
        // Показываем список загруженных файлов
        //$('#uploaded-files').show();
        return false;
    });
	
    // Простые стили для области перетаскивания
    $('#drop-files').on('dragenter', function() {
        $(this).css({
            'box-shadow' : 'inset 0px 0px 20px rgba(0, 0, 0, 0.1)', 
            'border' : '4px dashed #bb2b2b'
        });
        return false;
    });
	
    $('#drop-files').on('drop', function() {
        $(this).css({
            'box-shadow' : 'none', 
            'border' : '4px dashed rgba(0,0,0,0.2)'
        });
        return false;
    });
});


/*                      wIdget View*/


    
function updateSave(){        
    $.post('',$('#btpicture-form').serialize(), function(){            
        });
}
   
function btpByInnerEl(el){
    return $(el).closest('.btpicture');
}
    
///определяет Аватар(главнуя картинку галереи)
function btpSetMain(el){
    var id = btpIdByEl(el);
    $.post('', {
        'action': 'setMain', 
        'id':id
    });
    $('.btp-main').removeClass('btp-main');
    $(btpByInnerEl(el)).addClass('btp-main');
}


function btpIdByEl(el){
    return $(el).closest('.btpicture').attr('pic-id');
}

function btpDelete(el){
    var id = btpIdByEl(el);
    $.post('', {
        'action': 'delete', 
        'id':id
    },$(btpByInnerEl(el)).hide('slow'));
     
}
////update dialog
function btpUpdate(el){
    var id = btpIdByEl(el);
    $.post('', {
        'action': 'update', 
        'id':id
    }, function(data){
        ///createing of dialog
        $('#dialog').css({
            'display': 'none'
        }).html(data).dialog({
            'width':814
        });
        
        //autosaving on change
        $('#dialog').delegate('input, select', 'change', function(){
            $(this).css({
                'background-color' : 'rgb(106, 209, 106)'
            });   
            updateSave();
        });
    });
}
//////////////////////////////////// CROP /////////////////////////////////////    
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
    