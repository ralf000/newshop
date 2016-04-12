<div class="modal fade" id="addProductInOrderPopup" tabindex="-1" role="dialog" aria-labelledby="addProductInOrderPopup" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить товар в заказ</h4>
            </div>
            <div class="modal-body" id="addProductInOrderBody">
                <input type="hidden" name="id" value="<?= $order['id'] ?>" id="orderId"/>
                <div class="form-group">
                    <label for="productSearch">Найти товар</label>
                    <input type="text" name="productSearch" id="productSearch" class="form-control"/>
                </div>
                <div id="searchResult"><ul></ul></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function addHandlerForAddProduct() {
        $('a.addProduct').on('click', function (e) {
            e.preventDefault();
            var orderId = Number($('#orderId').val());
            var productId = Number($(this).attr('href'));
            var url = '/ajax/addProductInOrder';
            $.get(url, {orderId: orderId, productId: productId}, function (data, status, jqXHR) {
                if (status === 'success') {
                    location.reload();
                }
            });
        });
    }

    $(function () {
        $('#productSearch').on('input', function () {
            var t = $(this);
            var text = t.val();
            var box = $('#searchResult');
            var list = box.children('ul');
            box.hide();
            if (text.length > 3) {
                var url = '/ajax/SearchProduct';
                $.getJSON(url, {text: text}, function (data, status, jqXHR) {
                    if (status === 'success') {
                        list.empty();
                        var items = [];
                        $.each(data, function (k, v) {
                            items.push('<li><a class="addProduct" data-dismiss="modal" href="' + v.id + '">' + v.id + ': ' + v.title + '</a></li>');
                        });
                        list.append(items.join(''));
                        box.fadeIn();
                        addHandlerForAddProduct();
                    }
                });
            }
        });
    });
</script>