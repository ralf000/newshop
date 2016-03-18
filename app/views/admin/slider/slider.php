<?
use app\helpers\Generator;
?>

<? $slider    = $this->getData()[1]['slider'] ?>
<? $limit     = $this->getData()[1]['limit'] ?>
<? $page      = $this->getData()[1]['page'] ?>
<? $numSlides = $this->getData()[1]['num'] ?>
<? $offset    = $this->getData()[1]['offset'] ?>
<?
 $opt       = [
     'limit'     => $limit,
     'orderBy'   => $this->getData()[1]['orderBy'],
     'direction' => $this->getData()[1]['direction'],
     'num'       => $numSlides
         ]
?>
<script type="text/javascript" src="/app/template/backend/js/slider/allslides.js"></script>


<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="products" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="dataTables_length" id="showNumSlides">
                                                <label>Отображать по 
                                                    <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select> 
                                                    товаров
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div id="example1_filter" class="dataTables_filter pull-right">
                                                <label>
                                                    Поиск
                                                    <input type="search" class="form-control input-sm" placeholder="" aria-controls="example1"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <thead>
                                        <tr role="row">
                                            <th><a href="" data-name="id" class="sorting">ID</a></th>
                                            <th>Изображение</th>
                                            <th><a href="" data-name="title_h1" class="sorting">Заголовок</a></th>
                                            <th><a href="" data-name="title_h2" class="sorting">Подзаголовок</a></th>
                                            <th><a href="" data-name="content" class="sorting">Текст</a></th>
                                            <th><a href="" data-name="time_created" class="sorting">Создан</a></th>
                                            <th><a href="" data-name="time_updated" class="sorting">Обновлён</a></th>
                                            <th>Управление</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? if (!empty($slider) && is_array($slider)): ?>
                                             <? foreach ($slider as $slide): ?>
                                                 <tr role="row">
                                                     <td><?= $slide['id'] ?></td>
                                                     <td style="width: 20%"><a href="/<?= $slide['image'] ?>"><img src="/<?= $slide['image'] ?>" alt="" style="width: 100%;"/></a></td>
                                                     <td><?= $slide['title_h1'] ?></td>
                                                     <td><?= $slide['title_h2'] ?></td>
                                                     <td style="width: 20%"><?= $slide['content'] ?></td>
                                                     <td><?= $slide['time_created'] ?></td>
                                                     <td><?= $slide['time_updated'] ?></td>
                                                     <td>
                                                         <a href="/admin/editslide/id/<?= $slide['id'] ?>" class="admin-data-control"><span class="glyphicon glyphicon-pencil"></span></a>
                                                         <a href="<?= $slide['id'] ?>" class="deleteSlide admin-data-control"><span class="glyphicon glyphicon-minus"></span></a>
                                                     </td>
                                                 </tr>
                                             <? endforeach; ?>
                                         <? endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                                    <? $start = $offset + 1 ?>
                                    <? $end   = ($limit * $page < $numSlides) ? $limit * $page : $numSlides ?>
                                    На странице: <b><?= $start ?> - <?= $end ?></b> из <b><?= $numSlides ?></b> слайдов
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <? if ($limit < $numSlides): ?>
                                         <?= Generator::pagination($limit, $page, $opt) ?>
                                     <? endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
                    <a href="/admin/addslide" class="btn btn-sm btn-primary btn-flat pull-right">Новый слайд</a>

        </div><!-- /.col -->
    </div><!-- /.row -->
</section>