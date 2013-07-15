****BtPictures****
==========

yii extension for conection images to any yii model
# Опис:
Основна суть розширення заключається у можливості для екземпляра любого класу (де є поле id), можна створити
галерею тобто групу картинок, до яких можна буде доступитися, тільки використвоючи екземпляр цього класу.

## Поняття:
Галерея - сукупність усіх картинок, яким відповідають записи в бд з однаковими owner_name и owner_id
        Також може називатися екземпляр любого класу класу(повинна бути поле id), що передається у віджет в якості параметра model
Аватар - головна картинка певної галереї. Визначається присвоєнням полю is_main = 1 для конкретного запису.
         Аватар воинен бути тільки один, серед всієї галереї(тобто картинок з однаковими полями)
 


Розширення містить три елемента керування куартинками:
BtPictureController  - контроллер. Скоріше за все призначений для адміністраторів сайту
BtPictureWidget      - віджет. Слугує для загрузки картинок в галерею,
BtPictureBehavior    - Behavior(Поведінка для моделей). Слугую для добавлення в модель функцію getPictures(), 
                       що повертає евземпляри класу Btpicture для кожної картинки, що відноситься до цієї галереї 

# INSTALL

## Загальні 
Yii::setPathOfAlias('btpicture', dirname(__FILE__) . DS . '..'. DS . '..'.DS.'images'.DS.'btpicture');

Всі налаштування можна прописати у методі getConfig() моделі model/Btpicture.php 
 'dir' => Yii::getPathOfAlias('btpicture'), ////папка куда будуть поміщені директорії із різними розмірами картинок
            ///в масиві визначаються всі розміра. Передбачено один за замовчуванням. original
            'sizes' => array(
                ///'sizeName' =>  array('task' => '(resize|crop)', 'target' => '(sizeName|original)', 'width' => '999', 'height' => false),
                /* croped the largest */
                'c' => array('task' => 'crop', 'target' => 'original', 'width' => '1000', 'height' => false), ///if is set aspectRatio btImage don't use height; aspectRatio mast be like "1:1"
                /* resized form c, trumbnail1 */
                't1' => array('task' => 'resize', 'target' => 'c', 'width' => '425', 'height' => false),
                /* resized form c, trumbnail2 */
                't2' => array('task' => 'resize', 'target' => 'c', 'width' => '82', 'height' => false),
            ),
        );

## Контроллер
  у файлі конфігурації
  'controllerMap' => array(
        'btpicture' => 'core.extensions.btpicture.BtpictureController',
    ),

## Віджет
$this->widget('core.extensions.btpicture.BtPictureWidget', array(
    'model' => $model,
    'controllerRoute' => 'gallery', //route to gallery controller
));




Welcome to the BtPictures wiki!