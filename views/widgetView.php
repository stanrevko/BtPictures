<div class="btp-content">
	<!-- Область для перетаскивания -->
	<div id="drop-files" ondragover="return false">
		<p>Перетащите изображение сюда</p>
        <form id="frm">
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
		<ul id="uploaded-files">
			<h1>Загруженные файлы</h1>
		</ul>
	</div>
    
</div>
