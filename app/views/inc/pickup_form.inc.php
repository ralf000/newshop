<form action="/order/checkout" class="order_form" method="post" id="pickup">
    <input type="hidden" class="user_id" name="user_id" value="<?= \app\services\Session::get('user_id') ?>">
    <input type="hidden" class="delivery_type" name="delivery_type" value="3"/>
    <div class="row area checkout_area pickup_box" style="display: none;">
        <div class="col-sm-6">
            <div class="chose_area" style="padding: 30px 20px">
                <p>Наш пункт выдачи расположен по адресу:</p>
                <p><i class="fa fa-map-marker"></i> Химки, ул. Пролетарская д. 23</p>
                <p><b>Как добраться:</b></p>
                <p>Пункт расположен в 10 минутах от метро Тимирязевская и в 2 минутах от станции монорельсовой дороги Улица Милашенкова.</p>
                <div class="form-group box_phone">
                    <label class="control-label" for="user_phone">Телефон</label>
                    <div class="input-group">
                        <select name="user_phone" class="user_phone">
                            <option value="0"></option>
                            <option value="1">88005553535, Домашний</option>
                            <option value="1">84996878976, Рабочий</option>
                        </select>
                        <span class="input-group-btn">
                            <button class="btn btn-default phone_cancel" style="height: 28px;" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                        </span>
                    </div>
                </div>
                <div class="new_user_phone">
                    <h2 class="or center-block" style="margin-top: 0">ИЛИ</h2>
                    <h4 class="title text-center">Укажите данные для связи:</h4>
                    <div class="form-group">
                        <label class="control-label" for="number">Телефон</label>
                        <input type="tel" name="number" id="number" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="numType">Тип телефона</label>
                        <select name="numType" id="numType" class="forn-control">
                            <option value="Домашний">Домашний</option>
                            <option value="Рабочий">Рабочий</option>
                            <option value="Другой">Другой</option>
                        </select>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="rememberPhone" value="1">
                            Запомнить телефон для следующих заказов
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pickup-map">
                <script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=w1AmasNlVtCdLv72yo4EZr-_bECbXUIm&width=100%&height=320&lang=ru_RU&sourceType=constructor"></script>
            </div>
            <div class="chose_area" style="padding: 30px 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="deliveryDate">Выберите желаемую дату доставки</label>
                    <input type="date" name="deliveryDate" class="form-control" id="deliveryDate" min="<?= date('Y-m-d', strtotime('+1 day')); ?>" max="<?= date('Y-m-d', strtotime('+2 weeks')); ?>"/>
                </div>
                <div class="form-group">
                    <label class="control-label" for="note">Комментарий к заказу</label>
                    <textarea name="note" id="note" data-type="textarea" class="form-control"></textarea>
                </div>
            </div>
            <div class="total_area">
                <ul>
                    <li>Заказ <span>4180 <i class="fa fa-rub"></i></span></li>
                    <li>Самовывоз <span>0 <i class="fa fa-rub"></i></span></li>
                    <li><b>Итого <span>250 <i class="fa fa-rub"></i></span></b></li>
                </ul>
                <input type="button" class="btn btn-default check_out confirm_btn" data-form="#pickup" style="margin: 0 auto; display: block;" value="Подтвердить заказ">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="confirm_order" style="display: none">

                <div class="step-one">
                    <h2 class="heading">Проверьте правильность данных заказа:</h2>
                </div>
                <div class="confirm-content"></div>
                <div class="register-req">
                    <p>Нажимая на кнопку "Заказать" вы подтверждаете достоверность введенных данных.</p>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default form-control check_out" style="margin: 0 auto; display: block;" value="Заказать">
                </div>
                <div class="form-group">
                    <input type="button" class="btn btn-default form-control reorder" data-form="#pickup" style="margin: 0 auto; display: block;" value="Отредактировать заказ">
                </div>
            </div>
        </div>
    </div>
</form>