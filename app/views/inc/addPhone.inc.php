<div class="modal fade" id="addPhonePopup" tabindex="-1" role="dialog" aria-labelledby="addPhonePopup" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить новый телефон</h4>
            </div>
            <div class="modal-body" id="addPhonePopupBody">
                <div class="form-group">
                    <label for="numtype">Тип</label>
                    <select name="numtype" id="numtype" class="form-control">
                    </select>
                </div>
                <div class="form-group">
                    <label for="number">Телефон</label>
                    <input type="text" name="number" id="number" class="form-control"/>
                </div>
                <button type="button" class="btn btn-default" name="newphone" id="newaddress">Добавить</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>