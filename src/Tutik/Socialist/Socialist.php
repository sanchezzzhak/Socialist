<?php namespace Tutik\Socialist;


class Socialist {


    /**
     * Получить класс для указанной соц сети
     **/
    public static function factory($class)
    {
        $config =  \Config::get('api/socialist');
        switch($class)
        {
            case 'vk':
                return new Vk($config['vk']);
            case 'mailru':
                return new MailRu($config['mailru']);
            case 'fb':

            break;
        }

    }

    /**
     * Получить линки соц. сетей
     **/
    public static function getRegistrationLinks()
    {
        $config =  \Config::get('api/socialist');

        return [
            'vk' => 'http://api.vk.com/oauth/authorize?client_id=' . $config['vk']['app_id'] .
            '&response_type=token'.

            '&scope=notify,friends'.
            '&redirect_uri=' . urldecode( $config['vk']['redirect_url'] . '?auth=vk') ,

            'mailru' => 'https://connect.mail.ru/oauth/authorize?client_id=' . $config['mailru']['app_id'] .
            '&response_type=code&redirect_uri='. urldecode($config['mailru']['redirect_url'] . '?auth=mailru'),

            'fb'     => 'https://www.facebook.com/dialog/oauth?client_id=' . $config['fb']['app_id'] .
            '&redirect_uri=' .urldecode( $config['fb']['redirect_url'] . '?auth=fb'),


        ];
    }


}