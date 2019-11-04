<?php

namespace app\controllers\admin;

class CurrencyController extends MainController
{
    public function indexAction()
    {
        $currencies = $this->db->query('SELECT * FROM currency');
        $this->setParams(['currencies' => $currencies]);
    }

    public function addAction()
    {
        if(isset($_POST['sub'])){

            $data = filterData($_POST);
            $base = isset($_POST['base']) ? 1 : 0;
            $msgBase = '';
            if($base){
                $this->db->exec('UPDATE currency SET base=0 WHERE base=1');
                $msgBase = 'Базовая валюта изменена.';
            }
            $code = strtoupper($data['code']);

            $this->db->exec("INSERT INTO currency (name, value, base) VALUES ('$code', {$data['value']}, $base)");

            $this->write($code, $data['symbol']);
            $cache = new \store\Cache();
            $cache->remove('currencies');
            $_SESSION['success'] = 'Валюта успешно добавленна! ' . $msgBase;
            redirect();
        }
    }

    protected function write($name, $value)
    {
        $value = htmlspecialchars_decode($value);
        $symbols = include CONFIG . '/simbols_currency.php';
        $final_str = "<?php\n\nreturn [";
        foreach ($symbols as $code => $tag){
            $final_str .=  "\n\t '{$code}' => \"{$tag}\",";
        }
        $final_str .= "\n\t '{$name}' => \"{$value}\"";

        $final_str = htmlspecialchars(rtrim($final_str,',')) . "\n];";

        file_put_contents(CONFIG . '/simbols_currency.php', htmlspecialchars_decode($final_str));
    }

    public function editAction()
    {
        if(isset($_POST['sub'])){
            $data = filterData($_POST);

            $base = isset($data['base']) ? 1 : 0;
            $msgBase = '';
            if($base){
                $this->db->exec('UPDATE currency SET base=0 WHERE base=1');

                $msgBase = 'Базовая валюта изменена.';
            }else{
                $this->db->exec("UPDATE currency SET base=1 WHERE name='USD'");
                $msgBase = 'Базовая валюта изменена.';
            }

            $this->db->exec("UPDATE currency SET name='{$data['code']}', value={$data['value']}, base={$base} WHERE id={$data['id']}");

            $this->rewrite($data['code'], $data['symbol']);

            if(!$this->db->query('SELECT COUNT(*) FROM currency WHERE base=1')[0]['COUNT(*)'])
                $this->db->exec('UPDATE currency SET base=1 WHERE name=\'USD\'');

            $cache = new \store\Cache();
            $cache->remove('currencies');
            $_SESSION['success'] = 'Валюта успешно изменена!' . $msgBase;
            redirect();
        }


        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) redirect();

        $currency = $this->db->query("SELECT * FROM currency WHERE id={$_GET['id']}");

        if(empty($currency)) redirect();
        $currency = $currency[0];

        $simbolsCurrency = include CONFIG . '/simbols_currency.php';
        $currency['tag'] = $simbolsCurrency[$currency['name']];
        $this->setParams(['currency' => $currency]);
    }

    protected function rewrite($key, $value)
    {
        $value = htmlspecialchars_decode($value);
        $symbols = include CONFIG . '/simbols_currency.php';
        $final_str = "<?php\n\nreturn [";
        foreach ($symbols as $code => $tag){
            if($code == $key){
                $final_str .=  "\n\t '{$key}' => \"{$value}\",";
            }else{
                $final_str .=  "\n\t '{$code}' => \"{$tag}\",";
            }
        }

        $final_str = htmlspecialchars(rtrim($final_str,',')) . "\n];";

        file_put_contents(CONFIG . '/simbols_currency.php', htmlspecialchars_decode($final_str));
    }

    public function deleteAction()
    {
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) redirect();

        if($this->db->exec("DELETE FROM currency WHERE id={$_GET['id']}")){
            $currencies = \store\Register::get('currencies');
            foreach($currencies as $currency){
                if($currency['id'] == $_GET['id']){
                    $this->delete($currency['name']);
                    break;
                }
            }

            if(!$this->db->query('SELECT COUNT(*) FROM currency WHERE base=1')[0]['COUNT(*)'])
                $this->db->exec('UPDATE currency SET base=1 WHERE name=\'USD\'');

            $cache = new \store\Cache();
            $cache->remove('currencies');
            $_SESSION['success'] = 'Валюта успешно удалена!';
            redirect();
        }
    }

    protected function delete($key)
    {
        $symbols = include CONFIG . '/simbols_currency.php';
        $final_str = "<?php\n\nreturn [";
        foreach ($symbols as $code => $tag){
            if($code != $key){
                $final_str .=  "\n\t '{$code}' => \"{$tag}\",";
            }
        }

        $final_str = htmlspecialchars(rtrim($final_str,',')) . "\n];";

        file_put_contents(CONFIG . '/simbols_currency.php', htmlspecialchars_decode($final_str));
    }
}