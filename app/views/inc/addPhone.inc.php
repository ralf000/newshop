<div class="modal fade" id="addPhonePopup" tabindex="-1" role="dialog" aria-labelledby="addPhonePopup" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить новый телефон</h4>
            </div>
            <div class="modal-body" id="addPhonePopupBody">
                 <input type="hidden" name="id" value="<?= $userProfile['id'] ?>" id="userid"/>
                <div class="form-group">
                    <label for="nnumtype">Тип</label>
                    <select name="nnumtype" id="nnumtype" class="form-control">
                        <option value="1">Домашний</option>
                        <option value="2">Рабочий</option>
                        <option value="3">Другой</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nnumber">Телефон</label>
                    <input type="text" name="nnumber" id="nnumber" class="form-control"/>
                </div>
                <button type="button" class="btn btn-default" name="newphone" id="newphone">Добавить</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>