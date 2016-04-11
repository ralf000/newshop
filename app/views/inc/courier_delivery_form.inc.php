<form action="/order/checkout" class="order_form" method="post" id="courier_delivery">
    <input type="hidden" class="user_id" name="user_id" value="<?= \app\services\Session::get('user_id') ?>"/>
    <input type="hidden" class="delivery_type" name="delivery_type" value="1"/>
    <div class="row area checkout_area courier_delivery_box" style="display: none;">
        <div class="col-sm-6">
            <div class="chose_area" style="padding: 30px 20px;">
                <h4 class="title text-center">Выберите предпочитаемый адрес доставки из списка:</h4>
                <div class="form-group box_address">
                    <label class="control-label" for="user_address">Адрес</label>
                    <div class="input-group">
                        <select name="user_address" class="user_address">
                        </select>
                        <span class="input-group-btn">
                            <button class="btn btn-default address_cancel" style="height: 28px;" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                        </span>
                    </div>
                </div>
                <div class="new_user_address">
                    <h2 class="or center-block" style="margin-top: 0">ИЛИ</h2>
                    <h4 class="title text-center">Укажите адрес доставки:</h4>
                    <div class="form-group">
                        <label class="control-label" for="city">Населенный пункт (город, поселок)</label>
                        <input type="text" name="city" id="city" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="street">Улица</label>
                        <input type="text" name="street" id="street" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="home">Дом, корпус</label>
                        <input type="text" name="home" id="home" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="flat">Квартира</label>
                        <input type="text" name="flat" id="flat" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="postal">Индекс</label>
                        <input type="text" name="postal" id="postal" class="form-control"/>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="rememberAddress" value="1">
                            Запомнить адрес для следубющих заказов
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="chose_area" style="padding: 30px 20px; margin-bottom: 20px;">
                <h4 class="title text-center">Выберите контактные данные из списка:</h4>
                <div class="form-group box_phone">
                    <label class="control-label" for="user_phone">Телефон</label>
                    <div class="input-group">
                        <select name="user_phone" class="user_phone">
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
            <div class="chose_area" style="padding: 30px 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="deliveryDate">Выберите желаемую дату доставки</label>
                    <input type="date" name="deliveryDate" class="form-control" id="deliveryDate" min="<?= date('Y-m-d', strtotime('+1 day')); ?>" max="<?= date('Y-m-d', strtotime('+2 weeks')); ?>"/>
                </div>
                <div class="form-group">
                    <label for="deliveryTime">Выберите желаемое время доставки в 24 часовом формате</label>
                    <input type="time" name="deliveryTime" class="form-control" id="deliveryTime" value="18:00" min="10:00" max="20:00"/>
                </div>
                <div class="form-group">
                    <label class="control-label" for="note">Комментарий к заказу</label>
                    <textarea name="note" id="note" data-type="textarea" class="form-control"></textarea>
                </div>
            </div>
            <div class="total_area">
                <h4 class="title text-center">Окончательная стоимость:</h4>
                <ul>
                    <li class="total_order_price">Заказ <span></span></li>
                    <li class="deliveryPrice">Доставка <span></span></li>
                    <li class="total_order_price_add_delivery"><b>Итого <span></span></b></li>
                </ul>
                <input type="button" class="btn btn-default check_out confirm_btn" data-form="#courier_delivery" style="margin: 0 auto; display: block;" value="Подтвердить заказ">
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
                    <input type="button" class="btn btn-default form-control reorder" data-form="#courier_delivery" style="margin: 0 auto; display: block;" value="Отредактировать заказ">
                </div>
            </div>
        </div>
    </div>
</form>