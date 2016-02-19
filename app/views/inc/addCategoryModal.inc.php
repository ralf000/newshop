<div class="modal fade" id="addCategoryPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить новую категорию товаров</h4>
            </div>
            <div class="modal-body" id="addCategoryPopupBody">
                <form id="newcarform" action="newCat" method="post">
                    <input type="text" name="newcat" id="newcat" />
                    <button type="submit" class="btn btn-default" name="newcarform">Добавить</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>