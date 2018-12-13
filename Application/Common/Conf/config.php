<?php
$config = array(
    'PWD_ENCRYPT_STR' => 'jiankangweilai',
    'CSS_VER'         => 1,
    'JS_VER'          => 1,
    //'SHOW_PAGE_TRACE' => true,              // 显示页面Trace信息
    'SHOW_ERROR_MSG'  => true,
    'COOKIE_PREFIX'   => 'care_',
    'COOKIE_EXPIRE'   => 86400 * 7,
    'COOKIE_PATH'     => '/',
    /* URL设置 */
    'URL_MODEL'       => 2,                  //URL模式

    'MODULE_ALLOW_LIST'     => array('Home', 'Admin', 'Api'),
    'DEFAULT_MODULE'        => 'Home',

    /*自定义配置*/
    'LOAD_EXT_CONFIG'       => 'db,cache',

    //url 区分大小写
    'URL_CASE_INSENSITIVE'  => false,
    /* 子域名配置 */
    'APP_SUB_DOMAIN_DEPLOY' => 1,             // 开启子域名配置
    'APP_SUB_DOMAIN_RULES'  => array(
        'admin' => 'Admin',
        'api'   => 'Api',
    ),
);
return $config;

