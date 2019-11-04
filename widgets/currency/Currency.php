<?php

namespace widgets\currency;

use \store\Register;
use \store\Cache;
use \store\Db;
use \app\controllers\CartController;

class Currency
{
    private $currenctCurrency;
    private $currencies;

    public function __construct()
    {
        $this->currencies = self::getCurrencies();
        $currenctCurrency = self::getCurrentCurrency($this->currencies);
        $this->currenctCurrency = is_string($currenctCurrency) ? $currenctCurrency : $currenctCurrency['name'];
        
        $this->run();
    }

    public static function getCurrencies()
    {
        $currency = Register::get('currencies');

        if(empty($currency)){
            $cache = new Cache;
            $currency = $cache->get('currencies');
            if(empty($currency)){
                $db = Db::getInstance();
                $currency = $db->query('SELECT * FROM currency');
                $cache->add('currencies', $currency, time() + 60 * 60 * 24 * 7);
                return $currency;
            }else{
                return $currency;
            }
        }else{
            return $currency;
        }
    }

    public static function getCurrentCurrency($currencies)
    {
        if(isset($_COOKIE['currency'])){
            foreach ($currencies as $currency){
                if($currency['name'] == $_COOKIE['currency'])
                    return $_COOKIE['currency'];

                if($currency['base'] == 1){
                    $base = $currency;
                }
            }
            return $base['name'];

        }else{
            foreach ($currencies as $currency) {
                if($currency['base'] == 1){
                    return $currency['name'];
                }
            }
        }
    }

    public function run()
    {
        $view = $this->getHtml();
        include 'layouts/default.php';
    }

    public function getHtml()
    {
        ob_start();
        $currentCurrency = $this->currenctCurrency;
        include WIDGET . '\currency\layouts\view.php';
        return ob_get_clean();
    }

    public static function getSimbol()
    {
        $simbolsCurrencies = include CONFIG . '/simbols_currency.php';

        $currentCurrency = Register::get('currentCurrency');
        if(empty($currentCurrency)){
            $currentCurrency = self::getCurrentCurrency(self::getCurrencies());
        }
        $simbolCurrency = $simbolsCurrencies[$currentCurrency];

        return $simbolCurrency;
    }

}
