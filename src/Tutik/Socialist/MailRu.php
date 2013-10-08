<?php namespace Tutik\Socialist;


/**
 *   $MR = new MailRu($appId, $appSecret)
 *   $MR->api();
 **/

class MailRu {

    protected
         $app_key,
         $app_id,
         $app_key_private,
         $api_url = 'http://www.appsmail.ru/platform/api';

    private $cookie = array();


    public function  __construct($config)
    {
        $this->app_id  = $config['app_id'];
        $this->app_key = $config['app_key'];
        $this->app_key_private = $config['app_key_private'];
    }

    public function api($method, array $params = array())
    {
        $params = array_merge($params, array(
            'format' => 'json',
            'app_id' => $this->app_id,
            'secure' => '1',
            'method' => $method,
            'session_key' => $this->getSessionKey()
        ));
        ksort($params);
        $sig = '';
        foreach($params as $k=>$v)
        {
            $sig .= $k . '=' . $v;
        }
        $sig .= $this->app_key;
        $params['sig'] = md5($sig);

        $query = $this->api_url . '?' . $this->paramsToString($params);
        $res = @file_get_contents($query);

        return json_decode($res, true);
    }

    protected function paramsToString($params)
    {
        // http_build_str?
        $pice = array();
        foreach($params as $k => $v)
        {
            $pice[] = $k . '=' . urlencode($v);
        }
        return implode('&', $pice);
    }



    public function getSessionKey()
    {
        return isset($this->cookie['session_key']) ? $this->cookie['session_key'] : false;
    }

    /**
     * Проверка авторизован ли пользователь mail ru на сайте
     **/
    public function isAuth()
    {
        if (!isset($_COOKIE['mrc']))
            return false;

        $mrcCookie = $_COOKIE['mrc'];

        if (!empty($mrcCookie)) {
            $data = array();

            foreach (explode('&', $mrcCookie) as $item) {
                list($key, $value) = explode('=', $item);
                $data[$key] = $value;
                $this->cookie[$key] = $value;
            }

            if (null === $this->api('users.isAppUser')) {
                return false;
            }

            // ID пользователя mail ru.
            return $data['vid'];
        }
        return false;
    }

    public function getAppId()
    {
        return $this->app_id;
    }

    public function getAppKeyPrivate()
    {
        return $this->app_key_private;
    }



}