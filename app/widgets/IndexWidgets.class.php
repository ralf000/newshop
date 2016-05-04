<?php

 namespace app\widgets;

use app\helpers\Generator;
use app\models\ArticleTableModel;
use app\models\CategoryTableModel;
use app\models\ProductTableModel;
use app\models\SliderTableModel;
use app\models\SubCategoryTableModel;
use Exception;
use PDO;

 class IndexWidgets extends WidgetAbstract {

     public static function getSliderWidget() {
         $model  = new SliderTableModel();
         $model->setTable('slider');
         $model->readAllRecords();
         $slides = $model->getAllRecords();
         return Generator::sliderGenerator($slides);
     }

     public static function sideBarMenuWidget() {
         $catsNsubs = IndexWidgets::getCatsAndSubCats(TRUE);
         if (count($catsNsubs) !== 2)
             throw new Exception('Передан неверный массив категорий и подкатегорий');
         $cats      = current($catsNsubs);
         $subs      = end($catsNsubs);
         foreach ($cats as $key => $c) {
             foreach ($subs as $s) {
                 if ($c['id'] === $s['category_id'])
                     $cats[$key]['subcategories'][] = $s;
             }
         }
         return [
             'catsAndSubCats' => $cats,
             'brands'         => (new ProductTableModel)->getBrandsOrColors('brand'),
             'colors'         => (new ProductTableModel)->getBrandsOrColors('color')
         ];
     }
     
     public static function footerWidget(){
         $model = new ArticleTableModel();
         $model->setTable('article');
         $model->readAllRecords('id, title, main_image, created_time', 'ORDER BY created_time LIMIT 4');
         return $model->getAllRecords();
     }

     public function currentCategoryWidget($id) {
         try {
             $st = $this->db->prepare("SELECT * FROM category as c LEFT JOIN subcategory as s ON c.id = s.category_id WHERE c.id = ? ORDER BY c.id LIMIT 4");
             $st->execute([$id]);
             return $st->fetchAll(PDO::FETCH_ASSOC);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function recAndPopProductsWidget($condField = 'popular', $limit = 12) {
         $limit = "LIMIT $limit";
         try {
             $st = $this->db->query("SELECT p.id, p.title, p.price, i.image FROM product as p LEFT JOIN image as i ON p.id = i.product_id WHERE i.main = 1 AND p.{$condField} = 1 $limit");
             return $st->fetchAll(PDO::FETCH_ASSOC);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public static function getCatsAndSubCats($flag = FALSE) {
         $condition        = '';
         $categoryModel    = new CategoryTableModel();
         $categoryModel->setTable('category');
         $categoryModel->readAllRecords();
         $subCategoryModel = new SubCategoryTableModel();
         $subCategoryModel->setTable('subcategory');
         if (!$flag)
             $condition .= "WHERE subcategory.category_id = " . end($categoryModel->getAllRecords())['id'];
         $subCategoryModel->readAllRecords('*', $condition);
         return [
             'cats'    => array_reverse($categoryModel->getAllRecords()),
             'subcats' => array_reverse($subCategoryModel->getAllRecords())
         ];
     }
 }
 