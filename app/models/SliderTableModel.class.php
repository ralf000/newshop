<?php

 namespace app\models;

use app\dataContainers\Slide;
use app\helpers\Generator;
use app\helpers\Helper;
use app\helpers\Path;
use app\helpers\Validate;
use app\services\Session;
use Exception;

 class SliderTableModel extends TableModelAbstract {

     protected $slide;

     public function addRecord() {
         try {
             if (empty($this->slide) && !(is_object($this->slide)))
                 throw new Exception('Объект slide не инициализирован');
             $st       = $this->db->prepare("INSERT INTO slider (title_h1, title_h2, content, link, published, time_created) VALUES (:title_h1, :title_h2, :content, :link, :published, :time_created)");
             $st->execute([
                 ':title_h1'     => $this->slide->getTitleH1(),
                 ':title_h2'     => $this->slide->getTitleH2(),
                 ':content'      => $this->slide->getContent(),
                 ':link'         => $this->slide->getLink(),
                 ':published' => $this->slide->getPublished(),
                 ':time_created' => date('Y-m-d H:i:s')
             ]);
             $this->id = $this->db->lastInsertId();
             $this->addSlideImagePath();
             Helper::moveFile('mainimage', FALSE, $this->id, 'slide');
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     public function updateRecord() {
         try {
             if (empty($this->id))
                 throw new Exception('Не задан id слайда');
             if (empty($this->slide) && !(is_object($this->slide)))
                 throw new Exception('Объект slide не инициализирован');
             $st = $this->db->prepare("UPDATE slider SET title_h1 = :title_h1, title_h2 = :title_h2, content = :content, link = :link WHERE id = :id");
             $st->execute([
                 ':title_h1' => $this->slide->getTitleH1(),
                 ':title_h2' => $this->slide->getTitleH2(),
                 ':content'  => $this->slide->getContent(),
                 ':link'     => $this->slide->getLink(),
                 ':id'       => $this->id
             ]);
             if (!empty($image = $this->slide->getImage())){
                 $this->addSlideImagePath();
                 Helper::deleteDir($this->id, 'slider');
                 Helper::moveFile('mainimage', FALSE, $this->id, 'slide');
             }
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     private function addSlideImagePath() {
         try {
             if (empty($this->id))
                 throw new Exception('Не задан id слайда');
             if (empty($image = $this->slide->getImage()))
                 throw new Exception('Объект slide не инициализирован');
             $st    = $this->db->prepare("UPDATE slider SET image = ? WHERE id = ?");
             $path = $this->getPath($image);
             $st->execute([$path, $this->id]);
         } catch (Exception $ex) {
             $ex->getMessage();
         }
     }

     protected function getPath($image) {
         return Path::IMG_UPLOAD_DIR_SLIDER . $this->id . '/' . Generator::strToLat($image);
     }

     public function setData($formType = '', $method = '') {
         try {
             if ($formType === 'slider') {
                 $method  = 'POST';
                 $titleH1 = Validate::validateInputVar('title_h1', $method, 'str');
                 $titleH2 = Validate::validateInputVar('title_h2', $method, 'str');
                 $content = Validate::validateInputVar('content', $method, 'html');
                 $link    = Validate::validateInputVar('link', $method, 'str');
                 $image   = filter_var($_FILES['mainimage']['name']);
//                 if (!$image) {
//                     throw new Exception('Не задано изображение!');
//                 }
                 $published   = Validate::validateInputVar('published', $method, 'int');
                 if ($id = Validate::validateInputVar('id', $method, 'int'))
                     $this->id = $id;
                 if (!$published)
                     $published   = 0;
                 $this->slide = new Slide($titleH1, $titleH2, $content, $link, $image, $published);
             }
         } catch (Exception $ex) {
             Session::setMsg($ex->getMessage(), 'danger');
             header('Location: /admin/addslide');
             exit;
         }
     }

 }
 