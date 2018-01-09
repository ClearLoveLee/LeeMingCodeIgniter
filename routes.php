<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2018/1/8
 * Time: 下午4:44
 * 自定义路由
 */

$routes['default_controller'] = 'home';

$routes['welcome/hello'] = 'welcome/saysomething/hello';

//解析路由, 使用uri_segments和$routes两个全局变量
function  parse_routes()
{
    global $uri_segments, $routes, $rsegments;
    $uri = implode('/', $uri_segments);

//    print_r($uri_segments);  Array ( [0] => welcome [1] => saysomething [2] => hello )
//    echo '<br/>';
//    echo $uri; welcome/saysomething/hello
//    print_r($routes);

    if (isset($routes[$uri])) {
        $rsegments = explode('/', $routes[$uri]);
        return set_request($rsegments);
    } else {
        echo '无效的路由';
    }
}

//设置请求，指定相应的
function set_request($segments = array())
{
    global $class, $method;
    $class = $segments[0];
    if (isset($segments[1])) {
        $method = $segments[1];
    } else {
        $method = 'index';
    }
}
