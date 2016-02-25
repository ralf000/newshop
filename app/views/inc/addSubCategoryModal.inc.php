<div class="modal fade" id="addSubCategoryPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить новую подкатегорию товаров к текущей категории</h4>
            </div>
            <div class="modal-body" id="addSubCategoryPopupBody">
                <input type="hidden" name="categoryid" value="" id="categoryid" class="form-control"/>
                <div class="form-group">
                    <input type="text" name="newsubcat" id="newsubcat" class="form-control"/>
                </div>
                <button type="button" class="btn btn-default" name="newsubcarform" id="newsubcarform">Добавить</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>