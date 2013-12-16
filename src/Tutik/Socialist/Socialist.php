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
            case 'tw':
                return new TwitterOAuth($config['tw']['app_id'],$config['tw']['app_key']);
            break;
            case 'facebook':
            case 'fb':
                return new Facebook (
                    [   'appId'  => $config['fb']['app_id'],
                        'secret' => $config['fb']['app_key']
                    ]);
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
            '&response_type=code'. 
            '&scope=notify,friends'.
            '&redirect_uri=' . urldecode( $config['vk']['redirect_url']) ,

            'mailru' => 'https://connect.mail.ru/oauth/authorize?client_id=' . $config['mailru']['app_id'] .
            '&response_type=code&redirect_uri='. urldecode($config['mailru']['redirect_url'] . '?auth=mailru'),

            'fb'     => 'https://www.facebook.com/dialog/oauth?client_id=' . $config['fb']['app_id'] .
            '&redirect_uri=' .urldecode( $config['fb']['redirect_url'] . '?auth=fb'),

            'google_plus' => 'https://accounts.google.com/o/oauth2/auth?redirect_uri=' . urldecode( $config['google_plus']['redirect_url'] . '?auth=google_plus') .
                             '&response_type=code&client_id='. $config['google_plus']['app_id'] .'&approval_prompt=force'.
                             '&scope='. urlencode('https://www.googleapis.com/auth/plus.me') .'&access_type=offline',

            'tw' => '/socialist?auth=tw' ,

        ];
    }


}