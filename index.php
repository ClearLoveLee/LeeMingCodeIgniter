<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2018/1/8
 * Time: 上午11:39
 */

function detect_uri()
{
    //'SCRIPT_NAME' 包含当前脚本的路径。这在页面需要指向自己时非常有用。__FILE__ 常量包含当前脚本(例如包含文件)的完整路径和文件名。
    //'REQUEST_URI' URI 用来指定要访问的页面。例如 “/index.html”。
    if (!isset($_SERVER['REQUEST_URI']) or ! isset($_SERVER['SCRIPT_NAME']))
    {
        return '';
    }

    $uri = $_SERVER['REQUEST_URI'];

    // strpos() 查找字符串首次出现的位置
    if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
    {
        $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
    }

    if ($uri == '/' || empty($uri))
    {
        return '/';
    }

    //parse_url :  解析 URL，返回其组成部分
    $uri = parse_url($uri, PHP_URL_PATH);

    //将路径中的'//'或'../'等进行清理
    return str_replace(array('//', '../'), '/', trim($uri, '/'));
}

//$uri = detect_uri();
//echo $uri.'<br/>';

//提取uri中的分段信息
function explode_uri($uri)
{
    foreach (explode('/', preg_replace("|/*(.+?)/*$|", "\\1", $uri)) as $val)
    {
        $val = trim($val);
        if ($val != '')
        {
            $segments[] = $val;
        }
    }
    return $segments;
}

//$uri_segments = explode_uri($uri);
//print_r($uri_segments);

$uri_string = detect_uri();
$class = explode_uri($uri_string)[0];
$method = explode_uri($uri_string)[1];

function loadClass($class)
{
    //定位到类的路径, ucfirst()把字符串首字母大写
    $file = ucfirst($class).'.class.php';
    if (is_file($file))
    {
        require($file);
    }
}

//注册
spl_autoload_register('loadClass');

$class = ucfirst($class);
$obj = new $class();
$obj->$method();