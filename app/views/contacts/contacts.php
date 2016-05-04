<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">    		
            <div class="col-sm-12">    			   			
                <h2 class="title text-center">Контакты</h2>    			    				    				
                <div id="gmap" class="contact-map">
                    <script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=w1AmasNlVtCdLv72yo4EZr-_bECbXUIm&width=100%&height=428&lang=ru_RU&sourceType=constructor"></script>
                </div>
            </div>			 		
        </div>    	
        <div class="row">  	
            <div class="col-sm-8">
                <div class="contact-form">
                    <h2 class="title text-center">Напишите нам!</h2>
                    <!--                    <div class="status alert alert-success" style="display: none"></div>-->
                    <?= app\services\Session::showUserMsg() ?>
                    <form action="/contacts" id="main-contact-form" class="contact-form row" name="contact-form" method="post">
                        <div class="form-group col-md-6">
                            <input type="text" name="name" class="form-control" required="required" placeholder="Имя">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" name="email" class="form-control" required="required" placeholder="Email">
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" name="subject" class="form-control" required="required" placeholder="Тема">
                        </div>
                        <div class="form-group col-md-12">
                            <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Ваше сообщение"></textarea>
                        </div>                        
                        <div class="form-group col-md-12">
                            <input type="submit" name="submit" class="btn btn-primary pull-right" value="Отправить">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact-info">
                    <h2 class="title text-center">Как нас найти</h2>
                    <address>
                        <p><b>NewShop</b></p>
                        <p>Химки, ул. Пролетарская д. 23</p>
                        <p>Телефон: +2346 17 38 93</p>
                        <p>Факс: 1-714-252-0026</p>
                        <p>Email: info@newshop.ru</p>
                    </address>
                    <div class="social-networks">
                        <h2 class="title text-center">Мы в социальных сетях</h2>
                        <ul>
                            <? if (isset($cfg->social) && !empty($cfg->social)): ?>
                                 <? foreach ($cfg->social as $v): ?>
                                     <li><a href="<?= $v->link ?>"><i class="<?= $v->icon ?>"></i></a></li>
                                 <? endforeach; ?>
                             <? endif; ?>
                        </ul>
                    </div>
                </div>
            </div>    			
        </div>  
    </div>	
</div><!--/#contact-page-->