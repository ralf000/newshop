<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">    		
            <div class="col-sm-12">    			   			
                <h2 class="title text-center">Активация аккаунта</h2>
                <h5 class="bg-success">Ваш аккаунт успешно активирован.
                    <br> <br>Через <span id="secs"></span> секунд вы будете перемещены на главную страницу. Если не хотите ждать, нажмите <a href="/">сюда</a></h5>
                <br><br>
            </div>    			
        </div>  
    </div>	
</div><!--/#contact-page-->
<script type="text/javascript">
    $(function () {
        var secs = 5, box = $('#secs');
        $('#secs').append(secs);
        setInterval(function () {
            box.empty();
            $('#secs').append(--secs);
            if (secs === 0)
                location.href = '/';
        }, 1000);
    });
</script>