<?php

namespace app\controllers\admin;

class ProductController extends MainController
{
    public function indexAction()
    {
        $viewCountProducts = \store\Register::get('config')['admin']['view_count_products'];

        $currentPage = !empty($_GET['page']) ? $_GET['page'] : 1;
        $startProduct = ($currentPage - 1) * $viewCountProducts;
        $products = $this->db->query("SELECT product.id, category.title as category_title, product.title, price, status FROM product JOIN category ON product.category_id=category.id ORDER BY product.id LIMIT {$startProduct}, {$viewCountProducts}");
        $countProduct = $this->db->query('SELECT COUNT(*) FROM product')[0]['COUNT(*)'];
        $pagination = new \widgets\pagination\Pagination($countProduct, $currentPage, $viewCountProducts);

        $this->setParams(['countProduct' => $countProduct, 'pagination' => $pagination, 'products' => $products]);
    }

    public function editAction()
    {

    }

    public function addAction()
    {
        if(isset($_POST['sub'])){
            $data = filterData($_POST);
            $alias = \widgets\category\Category::get()[$data['cat_id']]['alias'];
            $old_price = !empty($data['old_price']) ? $data['old_price'] : 0;
            $status = isset($data['status']) ? 1 : 0;
            $hit = isset($data['hit']) ? 1 : 0;
            $big_spec = !empty($data['big_specifications']) ? htmlspecialchars_decode($data['big_specifications']) : '';

            $mainImg = isset($_SESSION['single']) ? $alias . '/' .  $_SESSION['single'] : '';

            $arrGaleryImg = isset($_SESSION['multi']) ? $_SESSION['multi'] : null;

            $folderImg = WWW . '/images/' . $alias;

            $galeryImgs = '';
            if($arrGaleryImg){
                foreach ($arrGaleryImg as $img){
                    $galeryImgs .= $alias . '/' . $img . ',';
                }
                $galeryImgs = rtrim($galeryImgs, ',');
            }


            //d("INSERT INTO product (title, alias, category_id, price, old_price, status, img, hit) VALUES ('{$data['title']}', '{$data['alias']}', {$data['cat_id']}, {$data['price']}, $old_price, $status, $mainImg, $hit)", 1);


            if($this->db->exec("INSERT INTO product (title, alias, category_id, price, old_price, status, img, hit) VALUES ('{$data['title']}', '{$data['alias']}', {$data['cat_id']}, {$data['price']}, $old_price, $status, '$mainImg', $hit)")){
                $id = $this->db->conn->lastInsertId();
                $this->db->exec("INSERT INTO product_info (id_product, hrefs_img, little_specifications, big_specifications) VALUES ($id, '$galeryImgs', '{$data['little_specifications']}', '{$big_spec}')");
                rename(WWW . '/images/tmp/' . $_SESSION['single'], WWW . '/images/' . $mainImg);

                if($galeryImgs){
                    foreach ($_SESSION['multi'] as $key => $img){
                        rename(WWW . '/images/tmp/' . $img, WWW . '/images/' . $alias . '/' . $img);
                    }
                }

                $_SESSION['success'] = 'Товар успешно добавлен!';
                redirect();
            }

            unset($_SESSION['single']);
            unset($_SESSION['multi']);
            $_SESSION['error'] = 'Произошла ошибка! Попробуйте позже.';
            redirect();
        }

        $categories = $this->db->query('SELECT * FROM category WHERE id NOT IN (SELECT parent_id FROM category)');
        $this->setParams(['categories' => $categories]);
    }

    public function addImageAction()
    {
        if(isset($_GET['upload'])) {
            $uploaddir = WWW . '/images/tmp/';
            $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES[$_POST['name']]['name'])); // расширение картинки
            $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // массив допустимых расширений
            if ($_FILES[$_POST['name']]['size'] > 1048576) {
                $res = array("error" => "Ошибка! Максимальный вес файла - 1 Мб!");
                exit(json_encode($res));
            }
            if ($_FILES[$_POST['name']]['error']) {
                $res = array("error" => "Ошибка! Возможно, файл слишком большой.");
                exit(json_encode($res));
            }
            if (!in_array($_FILES[$_POST['name']]['type'], $types)) {
                $res = array("error" => "Допустимые расширения - .gif, .jpg, .png");
                exit(json_encode($res));
            }
            $new_name = md5(time()) . ".$ext";
            $uploadfile = $uploaddir . $new_name;
            if (@move_uploaded_file($_FILES[$_POST['name']]['tmp_name'], $uploadfile)) {
                if ($_POST['name'] == 'single') {
                    $_SESSION['single'] = $new_name;
                } else {
                    $_SESSION['multi'][] = $new_name;
                }
                $res = array("file" => $new_name);
                exit(json_encode($res));
            }
        }
    }

    public function deleteAction()
    {
        if(empty($_GET['id']) || !is_numeric($_GET['id'])) redirect();

        $productImgs = $this->db->query("SELECT img, hrefs_img FROM product JOIN product_info ON product.id = product_info.id_product WHERE id={$_GET['id']}");

        if(empty($productImgs)) redirect();

        $galeryImgs = explode(',', $productImgs[0]['hrefs_img']);
        $mainImg = $productImgs[0]['img'];
        $checkIsset = false;

        if($this->db->exec("DELETE FROM product_info WHERE id_product={$_GET['id']}")){
            if($this->db->exec("DELETE FROM product WHERE id={$_GET['id']}")){
                foreach ($galeryImgs as $img){
                    unlink(WWW . '/images/' . $img);
                    if($img == $mainImg){
                        $checkIsset = true;
                    }
                }
                if(!$checkIsset)
                    unlink(WWW . '/images/' . $mainImg);

                $_SESSION['success'] = 'Товар успешно удален!';
                redirect();
            }
        }

        $_SESSION['error'] = 'Произошла ошибка! Попробуйте позже.';
        redirect();


    }

}