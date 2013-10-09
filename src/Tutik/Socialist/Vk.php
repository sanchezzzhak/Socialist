<?php

/**
 * Класс для работы с VK API
 * @usage
 * <pre>
 * $vk = new VK(array(
 *   'app_id' =>  '',
 *   'app_key' => '',
 *   'api_url' => 'api.vk.com/api.php'
 * ));
 * $result = $vk->api(<method> , <params> );
 * </pre>
 **/

class VK {

    protected
        $app_key,
        $app_id,
        $api_url;

    /**
     * Иницелизация задаем настройки
     * @param array $config
     *  app_id    Апп ID
     *  app_key   Ключ ID
     *  api_url   Url на api
     *
     **/
    public function __construct($config) {
        $this->app_id = $config['app_id'];
        $this->app_key = $config['app_key'];
        $api_url = !isset($config['api_url']) ? 'api.vk.com/api.php' : $config['api_url'];
        if (!strstr($api_url, 'http://')) $api_url = 'http://'.$api_url;
        $this->api_url = $api_url;
    }

    /**
     * Метод посылает запрос на VK
     * @param  string $method   имя метода в api
     * @param  array  $params   массив параметров которые нужно передать в api
     * @return array
     **/
    public function api( $method , $params= array() )
    {
        $params['api_id']    = $this->app_id;
       // $params['v']         = '3.0';
        $params['method']    = $method;
        $params['timestamp'] = time();
        $params['format']    = 'json';
        $params['random']    = rand(0,10000);
        ksort($params);
        $sig = '';
        foreach($params as $k=>$v)
        {
            $sig .= $k . '=' . $v;
        }
        $sig .= $this->app_key;
        $params['sig'] = md5($sig);
        $query = $this->api_url . '?' . $this->params($params);


        $res = file_get_contents($query);
        return json_decode($res, true);
    }

    /**
     * Создает query строку параметров PS^ http_build_query для вк не прокатывает (
     * @param array $params массив параметров
     * @return string
     **/
    protected function params($params)
    {
        $pice = array();
        foreach($params as $k=>$v)
        {
            $pice[] = $k . '=' . urlencode($v);
        }
        return implode('&' , $pice);
    }

    /**
     * Получаем данные пользователя
     * @param  integer $user_id
     * @param  string $access_token  Токен от доступа к пользователю
     * @return  array|false  Возвращаем данные о пользователе или false;
     **/
    public function getProfile($user_id, $access_token){
        $fealds = 'uid,first_name,last_name,nickname,screen_name,sex,bdate,city,country,timezone,photo'.
                  ',photo_medium,photo_big,has_mobile,rate,contacts,education,online,counters';

        /*
           $response = json_decode(file_get_contents('https://api.vk.com/method/getProfiles?uids='.$user_id .
          '&access_token='. $access_token . '&fields=' . $fealds, true));
           return $response;
        */
        return $this->api('getProfiles',array(
            'uids'         => $user_id,
            'fealds'       => $fealds,
            'access_token' => $access_token,
        ));

    }

    /**
     * Получить по коду access_token
     * @param  string $code секретный код от пользователя...
     * @return  array|false  получаем данные в виде массива или false
     **/
    public function getAccessToken($code){
        $response = json_decode(file_get_contents('https://api.vk.com/oauth/token?client_id=' . $this->app_id .
        '&code=' . $code . '&client_secret=' . $this->app_key . '&grant_type=client_credentials'),true);

        if (isset($response['access_token'])) {
            return $response;
        }
        return false;
    }


    public function getAppId(){
        return $this->app_id;
    }

}
