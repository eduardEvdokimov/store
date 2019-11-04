<?php

namespace app\controllers\admin;

class CategoryController extends MainController
{
    public function indexAction()
    {

    }

    public function editAction()
    {
        if(isset($_POST['sub'])){
            $data = filterData($_POST);
            if($this->db->exec("UPDATE category SET title='{$data['title']}', parent_id={$data['parent_id']}, keywords='{$data['keywords']}', description='{$data['description']}', alias='{$data['alias']}' WHERE id={$data['id']}")){
                $_SESSION['success'] = 'Категория успешно изменена!';
                $cache = new \store\Cache();
                $cache->remove('category');
                redirect();
            }
            $_SESSION['error'] = 'Произошла ошибка! Категория не была изменена.';
            redirect();
        }

        if(empty($_GET['id']) || !is_numeric($_GET['id']))
            redirect(HOST_ADMIN);

        $category = \widgets\category\Category::get()[$_GET['id']];
        $this->setParams(['category' => $category]);
    }

    public function addAction()
    {
        if(isset($_POST['sub'])){
            $data = filterData($_POST);

            if($this->db->exec("INSERT INTO category (title, alias, parent_id, keywords, description) VALUES ('{$data['title']}', '{$data['alias']}', {$data['parent_id']}, '{$data['keywords']}', '{$data['description']}')")){
                $_SESSION['success'] = 'Категория успешно добаленна!';
                $cache = new \store\Cache();
                $cache->remove('category');
                redirect();
            }
            $_SESSION['error'] = 'Произошла ошибка! Категория не была добаленна.';
            redirect();
        }
    }

    public function deleteAction()
    {
        if(empty($_GET['id']) || !is_numeric($_GET['id']))
            redirect();

        if($this->db->exec("DELETE FROM category WHERE id={$_GET['id']}")){
            $_SESSION['success'] = 'Категория успешно удалена!';
            $cache = new \store\Cache();
            $cache->remove('category');
            redirect();
        }
        $_SESSION['error'] = 'Произошла ошибка! Категория не была удалена.';
        redirect();
    }
}