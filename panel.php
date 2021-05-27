<!DOCTYPE html>
<html lang="ru">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <!-- <link href="css/flexslider.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Aguafina+Script&family=Roboto:ital@0;1&display=swap" rel="stylesheet">
    <!-- <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"> -->
    <title>MyCMS - Панель управления</title>
    <style>
        tr{
            text-align:center;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="fpcontainer">
            <div class="title">MyCMS</div>
            <div class="workplace">
                <div class="workplace__left">
                    <div class="workplace__item" data-item="1">Конфигурация сайта</div>
                    <div class="workplace__item" data-item="2">Товары</div>
                    <div class="workplace__item" data-item="3">Пользователи</div>
                    <div class="workplace__item" data-item="4">Заказы</div>
                    <div class="workplace__item" data-item="5">Отчёты</div>
                    <a href="../index.php" target="_blank" class="workplace__item back">Ваш сайт</a>
                </div>
                <div class="workplace__right">
                    <div class="workplace__config active" data-field="1">
                        <fieldset class="shopName">
                            <legend>Изменить название сайта</legend>
                            <div class="input__label">Название сайта</div>
                            <div class="input__text">
                                <input type="text" name="shopName" id="shopName" class="rinput">
                                <button class="workplace__ok">OK</button>
                                <span class="error vh"><img src="./img/error.svg" width="30px" height="30px" alt="error"
                                        title="Введите название"></span>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="design">
                            <legend>Изменить дизайн сайта</legend>
                            <div class="workplace__designs">
                                <div class="workplace__design" data-designname="electro">
                                    <img src="img/preview.jpg" alt="">
                                </div>
                                <div class="workplace__design panel__design-selected"
                                    data-designname="Другой тестовый дизайн">
                                    <img src="img/desert.png" alt="">
                                </div>
                                <div class="workplace__design" data-designname="newdesign">
                                    <img src="img/test.jpg" alt="">
                                </div>
                                <div class="workplace__design" data-designname="newdesign1">
                                    <img src="img/test2.png" alt="">
                                </div>
                                <div class="workplace__design" data-designname="Другой тестовый дизайн">
                                    <img src="img/desert.png" alt="">
                                </div>
                                <div class="workplace__design" data-designname="Другой тестовый дизайн">
                                    <img src="img/desert.png" alt="">
                                </div>
                                <div class="workplace__design" data-designname="Другой тестовый дизайн">
                                    <img src="img/desert.png" alt="">
                                </div>
                                <div class="workplace__design" data-designname="Другой тестовый дизайн">
                                    <img src="img/desert.png" alt="">
                                </div>
                                <div class="okbutton">
                                    <button class="workplace__ok des">OK</button>
                                </div>
                            </div>

                        </fieldset>
                        
                        <br>
                        <fieldset class="payment">
                            <legend>Изменить способы оплаты</legend>
                            <div class="panel__payments">
                                <div class="payments__payment">
                                    <div class="payment__label">Способ №1</div>
                                    <div class="payment__text">
                                        <input type="text" id="payment" class="rinput">
                                    </div>
                                    <div class="payment__plusminus">
                                        <img src="img/plus.svg" alt="" class="plus" title="Добавить ещё">
                                        <img src="img/minus.svg" alt="" class="minus hide" title="Убрать">
                                    </div>
                                </div>
                                <div class="okbutton">
                                    <button class="workplace__ok pay">OK</button>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="delivery">
                            <legend>Изменить способы доставки</legend>
                            <div class="panel__payments">
                                <div class="payments__payment">
                                    <div class="payment__label">Способ №1</div>
                                    <div class="payment__text">
                                        <input type="text" id="delivery" class="rinput">
                                    </div>
                                    <div class="payment__plusminus">
                                        <img src="img/plus.svg" alt="" class="plus" title="Добавить ещё">
                                        <img src="img/minus.svg" alt="" class="minus hide" title="Убрать">
                                    </div>
                                </div>
                                <div class="okbutton">
                                    <button class="workplace__ok del">OK</button>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="contactPhone">
                            <legend>Изменить контактный телефон</legend>
                            <div class="input__label">Телефон</div>
                            <div class="input__text">
                                <input type="text" name="contactPhone" id="contactPhone" class="rinput">
                                <button class="workplace__ok phone">OK</button>
                                <span class="error vh"><img src="./img/error.svg" width="30px" height="30px" alt="error"
                                        title="Введите номер телефона"></span>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="contactMail">
                            <legend>Изменить контактный e-mail</legend>
                            <div class="input__label">E-mail</div>
                            <div class="input__text">
                                <input type="text" name="contactMail" id="contactMail" class="rinput">
                                <button class="workplace__ok mail">OK</button>
                                <span class="error vh"><img src="./img/error.svg" width="30px" height="30px" alt="error"
                                        title="Введите e-mail"></span>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="size">
                            <legend>Изменить размер изображений товаров</legend>
                            <div class="input__label">Новый размер</div>
                            <div class="input__text">
                                <input type="text" name="newSize" id="newSize" class="rinput">
                                <button class="workplace__ok size">OK</button>
                                <span class="error vh"><img src="./img/error.svg" width="30px" height="30px" alt="error"
                                        title="Введите e-mail"></span>
                            </div>
                        </fieldset>
                    </div>

                    <div class="workplace__goods hide" data-field="2">
                        <fieldset>
                            <legend>Импорт товаров из Avito</legend>
                            <div class="input__label">Введите URL страницы с товаром на Avito</div>
                            <div class="input__text">
                                <input type="text" name="urlAvitoProduct" id="urlAvitoProduct" class="rinput">
                                <button class="workplace__ok import-avito-product">OK</button>
                                <span class="error vh"><img src="./img/error.svg" width="30px" height="30px" alt="error"
                                        title="Введите название"></span>
                            </div><br>
                            <div class="import-avito-product-result"></div>
                        </fieldset><br>

                        <fieldset>
                            <legend>Импорт товаров из каталога товаров Avito</legend>
                            <div class="input__label">Введите URL страницы с каталогом товаров на Avito</div>
                            <div class="input__text">
                                <input type="text" name="urlAvitoCatalog" id="urlAvitoCatalog" class="rinput">
                                <button class="workplace__ok import-avito-catalog">OK</button>
                                <span class="error vh"><img src="./img/error.svg" width="30px" height="30px" alt="error"
                                        title="Введите название"></span>
                            </div><br>
                            <div class="import-avito-catalog-result"></div>
                        </fieldset>
                    </div>

                    <div class="workplace__users hide" data-field="3">
                        <fieldset>
                            <legend>Добавить название сайта</legend>
                            <div class="input__label">Название сайта</div>
                            <div class="input__text">
                                <input type="text" name="shopName" id="shopName" class="rinput">
                                <button class="workplace__ok">OK</button>
                                <span class="error vh"><img src="./img/error.svg" width="30px" height="30px" alt="error"
                                        title="Введите название"></span>
                            </div>
                        </fieldset>
                    </div>

                    <div class="workplace__orders hide" data-field="4">
                        <fieldset class="orders">
                            <legend>Просмотр заказов</legend>
                            <div class="input__label">
                            <button class="workplace__ok orders">Загрузить список заказов</button>
                                <span class="error vh"><img src="./img/error.svg" width="30px" height="30px" alt="error"
                                        title="Введите название"></span>
                            </div><br>
                            <div class="orders-result"></div>
                        </fieldset>
                    </div>

                    <div class="workplace__reports hide" data-field="5">
                        <fieldset>
                            <legend>Отчёт о добавлении товаров</legend>
                            <div class="reports__text">
                                <button class="workplace__ok report" data-reporttype="add">Сгенерировать отчёт</button>
                                <a href="" class="readreportadd">Открыть отчёт</a>
                            </div>
                        </fieldset> <br>
                        <fieldset>
                            <legend>Отчёт о наличии товаров</legend>
                            <div class="reports__text">
                                <button class="workplace__ok report" data-reporttype="product">Сгенерировать отчёт</button>
                                <a href="" class="readreportadd">Открыть отчёт</a>
                            </div>
                        </fieldset><br>
                        <fieldset>
                            <legend>Отчёт о продажах</legend>
                            <div class="reportParams">
                                <label>Выберите необходимые поля отчета</label><br><br>

                                <input type="checkbox" name="description" id="description">
                                <label for="description">Описание товара</label><br>

                                <input type="checkbox" name="price" id="price">
                                <label for="price">Стоимость</label><br>

                                <input type="checkbox" name="discount" id="discount">
                                <label for="discount">Скидка</label><br>

                                <input type="checkbox" name="count" id="count">
                                <label for="count">Количество товара</label><br>

                                <input type="checkbox" name="dateBuy" id="dateBuy">
                                <label for="dateBuy">Дата покупки товара</label><br>
                            </div>
                            <div class="reports__text">
                                
                                <button class="workplace__ok report" data-reporttype="sells">Сгенерировать отчёт</button>
                                <a href="" target="_blank" class="readreportadd">Открыть отчёт</a>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal">
        <div class="modal__text"></div>
        <a href="">
            <div class="modal__button button">ОК</div>
        </a>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/imask.js"></script>
    <script src="js/Check.class.js"></script>
    <script src="js/PanelForm.js"></script>
    <script src="js/panel.js"></script>

</body>

</html>