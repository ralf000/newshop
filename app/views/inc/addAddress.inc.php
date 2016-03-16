<div class="modal fade" id="addAddressPopup" tabindex="-1" role="dialog" aria-labelledby="addAddressPopup" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить новый адрес</h4>
            </div>
            <div class="modal-body" id="addAddressPopupBody">
                <input type="hidden" name="id" value="<?= $userProfile['id'] ?>" id="userid"/>
                <div class="form-group">
                    <label for="naddress">Адрес</label>
                    <input type="text" name="naddress" id="naddress" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="npostal">Почтовый Индекс</label>
                    <input type="text" name="npostal" id="npostal" class="form-control"/>
                </div>
                <button type="button" class="btn btn-default" name="newaddress" id="newaddress">Добавить</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>