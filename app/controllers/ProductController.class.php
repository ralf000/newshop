<?php

 namespace app\controllers;

 use app\helpers\Generator;
 use app\models\CategoryTableModel;
 use app\models\FrontModel;
 use app\models\ImageTableModel;
 use app\models\ProductTableModel;
 use app\widgets\AdminWidgets;
 use app\widgets\IndexWidgets;

 class ProductController extends AbstractController {

     protected function requiredRoles() {
         
     }

     function allAction() {
         $fc    = FrontController::getInstance();
         $model = new FrontModel();

         $productModel = new ProductTableModel();
         $productModel->setTable('product');
         $params       = $fc->getParams();
         $condition    = '';
         $paramsMap    = ['brand', 'color', 'category_id', 'subcategory_id'];
         if (!empty($params)) {
             $condition .= 'WHERE';
             foreach ($params as $name => $value) {
                 if (in_array(strtolower($name), $paramsMap))
                     $condition .= " product.$name = '$value' AND";
             }

             $condition .= ' main = 1';
             if (strpos(strtolower($condition), 'join') || strpos(strtolower($condition), 'union'))
                 $condition = '';
         }

         //for pagination
         $num       = (new AdminWidgets)->getNum('product', substr($condition, 0, -13));
         $page      = $fc->getParams()['page'] ? filter_var($fc->getParams()['page'], FILTER_SANITIZE_NUMBER_INT) : 1;
         $limit     = $fc->getParams()['limit'] ? filter_var($fc->getParams()['limit'], FILTER_SANITIZE_NUMBER_INT) : 20;
         $orderBy   = $fc->getParams()['orderBy'] ? filter_var($fc->getParams()['orderBy'], FILTER_SANITIZE_STRING) : 'id';
         $direction = $fc->getParams()['direction'] ? filter_var($fc->getParams()['direction'], FILTER_SANITIZE_STRING) : 'asc';
         $offset    = $limit * $page - $limit;

         $popProducts = (new IndexWidgets)->recAndPopProductsWidget('popular', 3);
         $recProducts = (new IndexWidgets)->recAndPopProductsWidget('recommended');
//         \app\helpers\Helper::g($condition); exit;
         $model->setData([
             'products'            => $productModel->getAllProducts('*', $condition . " ORDER BY product.$orderBy " . strtoupper($direction) . " LIMIT $limit OFFSET $offset"),
             'popularProducts'     => Generator::popularProducts($popProducts, 3),
             'recommendedProducts' => Generator::recommendedProducts($recProducts),
             'page'                => $page,
             'offset'              => $offset,
             'start'               => $offset + 1,
             'end'                 => ($limit * $page < $num) ? $limit * $page : $num,
             'paginationOptions'   => [
                 'brand' => $fc->getParams()['brand'] ? filter_var($fc->getParams()['brand'], FILTER_SANITIZE_STRING) : '',
                 'color' => $fc->getParams()['color'] ? filter_var($fc->getParams()['color'], FILTER_SANITIZE_STRING) : '',
                 'category_id' => $fc->getParams()['category_id'] ? filter_var($fc->getParams()['category_id'], FILTER_SANITIZE_STRING) : '',
                 'subcategory_id' => $fc->getParams()['subcategory_id'] ? filter_var($fc->getParams()['subcategory_id'], FILTER_SANITIZE_STRING) : '',
                 'limit'     => $limit,
                 'orderBy'   => $orderBy,
                 'direction' => $direction,
                 'table'     => 'product',
                 'num'       => $num
             ]
         ]);
         $output      = $model->render('../views/product/all.php', 'withoutSlider');
         $fc->setPage($output);
     }

     function viewAction() {
         $fc    = FrontController::getInstance();
         $model = new FrontModel();
         $id    = filter_var($fc->getParams()['id'], FILTER_SANITIZE_NUMBER_INT);
         if (!$id) {
             header('Location: /admin/notFound');
             exit;
         }
         $productModel           = new ProductTableModel();
         $productModel->setId($id);
         $productModel->setTable('product');
         $ImageModel             = new ImageTableModel();
         $ImageModel->setId($id);
         $ImageModel->setTable('image');
         $images                 = $ImageModel->readRecordsById('product_id', '*', 'ORDER BY main');
         $product                = $productModel->readRecordsById()[0];
         $categoryModel          = new CategoryTableModel();
         $product['category']    = $categoryModel->getCategoryById($product['category_id'])['category_name'];
         $product['subCategory'] = $categoryModel->getSubCategoryById($product['subcategory_id'])['subcategory_name'];
         if (!$product) {
             header('Location: /admin/notFound');
             exit;
         }
         $recProducts = (new IndexWidgets)->recAndPopProductsWidget('recommended');
         $model->setData([
             'product'             => $product,
             'images'              => $images,
             'recommendedProducts' => Generator::recommendedProducts($recProducts)
         ]);
         $output      = $model->render('../views/product/product.php', 'withoutSlider');
         $fc->setPage($output);
     }

 }
 