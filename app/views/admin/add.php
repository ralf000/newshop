<h3>Добавить новый товар</h3>
<form action="<?= htmlentities($_SERVER['REQUEST_URI']) ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="cat">Категория</label>
        <div class="input-group">
            <select id="cat" class="form-control" name="cat">
                <option value="1">Кофеварки</option>
                <option value="2">Кофемашины</option>
                <option value="3">Френчпрессы</option>
            </select>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus"></span> Новая категория</button>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label for="subcat">Подкатегория</label>
        <div class="input-group">
            <select id="subcat" class="form-control" name="subcat">
                <option value="1">Капсульные</option>
                <option value="2">Рожковые</option>
                <option value="3">Капельные</option>
                <option value="4">Для кофе по-турецки</option>
            </select>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus"></span> Новая подкатегория</button>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label for="title">Наименование</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Заголовок"/>
    </div>
    <div class="form-group">
        <label for="desc">Описание</label>
        <input type="text" name="desc" id="desc" class="form-control" placeholder="Описание"/>
    </div>
    <div class="form-group">
        <label for="spec">Характеристики</label>
        <input type="text" name="spec" id="spec" class="form-control" placeholder="Характеристики"/>
    </div>
    <div class="form-group">
        <label for="price">Цена руб.</label>
        <input type="text" name="price" id="price" class="form-control" placeholder="Цена в рублях"/>
    </div>
    <div class="form-group">
        <label for="quant">Количество</label>
        <input type="text" name="quant" id="quant" class="form-control" placeholder="Количество"/>
    </div>
    <div class="form-group">
        <label for="mainimage">Главное изображение</label>
        <input type="file" name="mainimage" id="mainimage" class="form-control"/>
    </div>
    <div class="form-group">
        <label for="images">Остальные изображения</label>
        <input type="file" name="images[]" id="images" class="form-control" multiple/>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="published" value="1">
            Опубликовать?
        </label>
    </div>
    <button type="submit" class="btn btn-default">Отправить</button>
</form>

