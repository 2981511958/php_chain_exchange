<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * 判断字符串是否为手机号
 * @param  String  $str 需要进行判断的字符串
 * @return boolean      返回判断结果，返回true则为手机号
 */
function isPhoneNumber($str){

    return preg_match("/^1[34578]{1}\d{9}$/", $str);
}


/**
 * 生成并获取随机码
 * @param  Int     $length   随机码的长度
 * @param  boolean $isNumber 是否指定随机码为纯数字
 * @return String            返回生成的随机码
 */
function randCode($length, $isNumber = false){

    $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';
    $code = '';

    if ($isNumber) {
        
        $charset = '0123456789';
    }

    $_len = strlen($charset)-1;

    for ($i=0;$i<$length;$i++) {

        $code .= $charset[mt_rand(0,$_len)];
    }

    return $code;
}


/**
 * 获取指定时间所属的周索引(一周从周一到周日)
 * @param unknown $time 时间戳
 * @return number       int，返回该周属于第几周
 */
function getWeekIndex($time){
    return floor((($time - 57600)/60/60/24 - 3)/7);
}


/**
 * 根据指定的周索引返回该周的起始时间和结束时间（一周从周一到周日）
 * @param unknown $weekIndex    周索引
 * @return number               array,返回起始时间戳和结束时间戳组成的数组
 */
function getWeekLimits($weekIndex){
    $limits['start'] = strtotime(date('Y-m-d',$weekIndex * 604800 + 259200)) + 86400;
    $limits['end'] = strtotime(date('Y-m-d',$weekIndex * 604800 + 259200)) + 86400 * 8 - 1;
    return $limits;
}


/**
 * 判断当前请求是否为异步请求
 * @return boolean 异步返回TRUE，否则返回FALSE
 */
function isAjax(){

    $result = false;

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        
        if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
            $result = true;
        }
    }

    return $result;
}


/**
 * 获取多级节点关系树形数组
 * @param  array  $sourceArray 原始数组,需包含主键,上级外键
 * @param  string $id          主键字符串
 * @param  string $pid         上级外键字符串
 * @param  string $sonKey      指定子节点在父节点中的键名，默认为'son'
 * @return array               返回树形数组
 */
function treeArray($sourceArray, $id, $pid, $sonKey = 'son'){

    $tree = array(); //格式化好的树

    foreach ($sourceArray as $item){

        if (isset($sourceArray[$item[$pid]])){

            $sourceArray[$item[$pid]][$sonKey][] = &$sourceArray[$item[$id]];
        }
        else{
            $tree[] = &$sourceArray[$item[$id]];
        }
    }

    return $tree;
}


/**
 * 将多级树形数组转换成保留树形结构的一维数组
 * @param  array   $treeArray 树形数组
 * @param  string  $sonKey    树形数组中的子节点索引
 * @param  string  $treeNode  希望返回数组中存放树形结构信息的索引，默认为'node'
 * @return array              返回保留树形结构的一维数组
 */
function treeSelect($treeArray, $sonKey, $treeNode = 'node', $control = 0){

    $nowControl = $control;

    $list = array();
    foreach ($treeArray as $item) {
        
        $temp = $item;

        $str = '';
        for ($i=0; $i < $nowControl; $i++) { 
            $str .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        $str .= '|-&nbsp;';
        $temp[$treeNode] = $str;

        if (isset($temp[$sonKey])) {
            
            unset($temp[$sonKey]);
            $temp['has' . $sonKey] = TRUE;
            $list[] = $temp;

            $tempArr = treeSelect($item[$sonKey], $sonKey, $treeNode, ++ $control);
            foreach ($tempArr as $tempStr) {
                
                $list[] = $tempStr;
            }
        }else{

            $temp['has' . $sonKey] = FALSE;
            $list[] = $temp;
        }

        $control = $nowControl;
    }

    return $list;
}


/**
 * 向字符串指定位置插入字符串
 * @param unknown $str      原字符串
 * @param unknown $i        指定索引，从0开始
 * @param unknown $substr   需要插入的字符串
 * @return string           返回插入后的字符串
 */
function str_insert($str, $i, $substr){

    $startstr = '';
    $laststr = '';
    for($j=0; $j<$i; $j++){
        $startstr .= $str[$j];
    }
    for ($j=$i; $j<strlen($str); $j++){
        $laststr .= $str[$j];
    }
    $str = ($startstr . $substr . $laststr);
    return $str;
}


/**
 * 为字符串加密
 *
 * @param unknown $str  需要加密的字符串
 * @return string       返回加密之后的字符串
 */
function pwd_encode($str){

    //加密顺序: md5 -> 倒序 -> sha1 -> md5
    $str = md5(sha1(setStrDesc(md5($str))));

    return $str;
}


/**
 * 字符串倒序排列
 *
 * @param unknown $str  需要倒序的字符串
 * @return string       返回倒序之后的字符串
 */
function setStrDesc($str){

    //将字符串转为数组
    $strArr = str_split($str);
    for($i=0;$i<(count($strArr)-1)/2;$i++){

        //倒序操作
        $temp = $strArr[$i];
        $strArr[$i] = $str[count($strArr)-1-$i];
        $strArr[count($strArr)-1-$i] = $temp;
    }

    //重置字符串
    $str = '';
    foreach ($strArr as $v){
        $str = $str.$v;
    }

    return $str;
}



/**
 * 字符串截取
 *
 * @param unknown $str      需要进行截取的字符串
 * @param unknown $start    在字符串上开始截取的位置（从0开始的index）
 * @param unknown $len      在字符串上截取的长度
 * @param string $eCode     可选  截取后的编码（默认为utf-8）
 *
 * @return string           返回截取后的字符串
 */
function subMyStr($str, $start , $len , $eCode = 'utf8'){

    return mb_substr($str, $start, $len, $eCode);
}




/**
 * 检测字符串中是否含有非法字符
 *
 * @param unknown $str  需要检测的字符串
 * @return boolean      无非法字符返回true，有非法字符返回false
 */
function checkStrSafe($str){

    $arr = array('#',';','<','>','$',"'",'"');
    foreach($arr as $v){

        //substr_count(m,n)返回字符串n在字符串m中出现的次数
        if(substr_count($str, $v) > 0)
            return false;
    }

    return true;

}


/**
 * 处理非法字符
 *
 * @param $str      需要处理非法字符是字符串
 * @return mixed    处理非法字符后的字符串
 */
function doSafeStr($str){

    $unSafeStr = array(';','<','>','$',"'",'"',"\\");
    $safeStr = array('；','＜','＞','＄',"＇",'＂','＼');

    $str = str_replace($unSafeStr, $safeStr, trim($str));

    return $str;
}


/**
 * 自动生成文件保存路径
 * @param  Int    $timeStamp 时间戳
 * @param  String $fileType  文件后缀名
 * @return String            返回路径
 */
function autoSavePath($timeStamp, $fileType){

    return '/' . date('Ymd', $timeStamp) . '/' . md5(date('YmdHis', $timeStamp) . rand(0, 100) . rand(0, 100) . rand(0, 100)) . '.' . $fileType;
}


/**
 * 获取文件类型(后缀名)
 * @param unknown $fileName 文件路径
 * @return multitype:   返回文件的后缀名，若文件不存在返回false
 */
function getFileType($fileName){
    
    //以“.”为分界符将字符串拆成数组
    $fileType = explode('.', $fileName)[count(explode('.', $fileName)) - 1];
    return $fileType;
}


/**
 * 下载文件
 * @param unknown $fileName 文件的绝对路径
 * @param unknown $fileTempName 给下载的文件一个临时名字
 */
function downLoadFile($fileName,$fileTempName){
    //检查文件是否存在
    if (file_exists( $fileName )) {
        //打开文件
        $file = fopen ( $fileName, "r" );
        //发送浏览器头部报文
        Header ( "Content-type: application/octet-stream" );
        Header ( "Accept-Ranges: bytes" );
        Header ( "Accept-Length: " . filesize ( $fileName ) );
        Header ( "Content-Disposition: attachment; filename=" . $fileTempName );
        //读取文件内容并直接输出到浏览器
        echo fread ( $file, filesize ( $fileName ) );
        fclose ( $file );
    }
}


/**
 * 上传文件
 * @param unknown $file     文件流
 * @param unknown $fileName 保存位置绝对路径文件名
 * @return boolean          返回布尔值：上传结果，true成功，false失败
 */
function uploadFile($file, $fileName){
    
    $result = false;

    //先判断文件流是否不为空，为空时直接返回结果
    if($file['error'] == 0){
        //判断目录是否存在,不存在时创建目录
        if(!file_exists(dirname($fileName))){
            mkdir(dirname($fileName),0777, TRUE);
        }
        //上传文件,并返回上传结果
        if(move_uploaded_file($file['tmp_name'],$fileName) && file_exists($fileName)){
            $result = true;
        }
    }

    return $result;
}



/**
 * 计算分页时当前页显示页码的起始页码和结束页码
 * @param unknown $count            总数量
 * @param unknown $pageIndex        当前页的页码
 * @param unknown $pageSize         每页数量
 * @param unknown $LRNum            当前页的左右分别允许显示的页码个数最大值
 * @param unknown $action           访问路径：/xxx/
 * @return ArrayAccess              返回数组：包含当前页显示页码的起始页码和结束页码以及左右是否显示省略号
 */
function getPagingInfo($count, $pageIndex, $pageSize, $LRNum, $action){

    $pageInfo = null;

    //计算分页信息
    $pageInfo['pagesum'] = $count % $pageSize == 0 ? $count / $pageSize : floor($count / $pageSize) + 1;
    $pageInfo['pagesum'] = $pageInfo['pagesum'] ? $pageInfo['pagesum'] : 1;
    $pageInfo['pageindex'] = $pageIndex > $pageInfo['pagesum'] ? $pageInfo['pagesum'] : ($pageIndex < 1 ? 1 : $pageIndex);
    $pageInfo['action'] = $action;

    switch (true){
        //当总页数小于每页页码数量最大值时，直接显示所有页码
        case ($pageInfo['pagesum'] <= ($LRNum * 2 + 1)):
            $pageInfo['pageindexstart'] = 1;
            $pageInfo['pageindexend'] = $pageInfo['pagesum'];
            $pageInfo['left'] = false;  //左边是否需要放页码省略号，下同
            $pageInfo['right'] = false; //右边是否需要放页码省略号，下同
            break;
            //当前页码左侧不需要省略页码时
        case ($pageInfo['pageindex'] <= ($LRNum + 1)):
            $pageInfo['pageindexstart'] = 1;
            $pageInfo['pageindexend'] = $LRNum * 2 + 1;
            $pageInfo['left'] = false;
            $pageInfo['right'] = true;
            break;
            //当前页码左右都需要省略页码时
        case (($LRNum + 1) < $pageInfo['pageindex'] && $pageInfo['pageindex'] <= ($pageInfo['pagesum'] - $LRNum - 1)):
            $pageInfo['pageindexstart'] = $pageInfo['pageindex'] - $LRNum;
            $pageInfo['pageindexend'] = $pageInfo['pageindex'] + $LRNum;
            $pageInfo['left'] = true;
            $pageInfo['right'] = true;
            break;
            //当前页码右侧不需要省略页码时
        case ($pageInfo['pageindex'] > $pageInfo['pagesum'] - $LRNum - 1):
            $pageInfo['pageindexstart'] = $pageInfo['pagesum'] - ($LRNum * 2) - 1;
            $pageInfo['pageindexend'] = $pageInfo['pagesum'];
            $pageInfo['left'] = true;
            $pageInfo['right'] = false;
            break;
    }
    return $pageInfo;
}



/**
 * 不区分大小写的in_array实现
 */
function in_array_case($value,$array){
    return in_array(strtolower($value),array_map('strtolower',$array));
}



/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}



/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $isCmd 是否是在命令行输出
 * @return void|string
 */
function dump($var, $isCmd = false) {

    ob_start();
    var_dump($var);
    $output = ob_get_clean();
    if (!extension_loaded('xdebug')) {
        $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);

        if (!$isCmd) {
            
            $output = '<pre>' . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    
    echo($output);
}



/**
 * 验证电子邮箱地址的格式
 * @param unknown $emailStr 电子邮箱地址
 * @return boolean          验证通过返回true，验证不通过返回false
 */
function checkEmailFomat($emailStr){
    if (preg_match("/[\w!#$%&'*+\/=?^_`{|}~-]+(?:\.[\w!#$%&'*+\/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/", $emailStr)){
        return true;
    }
    return false;
}



/**
 * 从代理信息中获取浏览器的标识
 * @param  String $str 代理信息
 * @return String      浏览器标识
 */
function formatBrowserStr($agent){
    
    if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
        return "IE";
    else if(strpos($agent,'Firefox')!==false)
        return "Firefox";
    else if(strpos($agent,'Chrome')!==false)
        return "Chrome";
    else if(strpos($agent,'Opera')!==false)
        return 'Opera';
    else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
        return 'Safari';
    else if(strpos($agent,'MicroMessenger')!==false)
        return 'Wechat';
    else
        return 'unknown';
}


/**
 * 文件系统函数库
 */

/**
 * 遍历指定目录下的目录文件结构
 * @param unknown $path 目录的绝对路径
 * @param string $full  boolean 指定是否遍历目录下的所有子目录，true为遍历所有，false为只遍历指定目录，默认为true
 * @return Ambigous <boolean, string>   array，返回目录结构组成的数组
 */
function selectFileSystem($path, $full = true){
    //初始化目录结构
    $dirArr = null;
    //判断指定的目录路径是否合法
    if(file_exists($path)){
        if(is_dir($path)){
            //遍历目录
            $dirTemp = scandir($path);
            foreach ($dirTemp as $key => $dir){
                //将.与..的成员剔除
                if($dir != '.' && $dir != '..'){
                    //判断是否遍历所有
                    if($full){
                        //判断当前成员是否是一个拥有子目录成员的目录
                        if(is_dir($path.'\\'.$dir) && count(scandir($path.'\\'.$dir)) > 2){
                            //递归获取子目录成员结构
                            $dirArr[iconv('gbk', 'utf-8', $path.'\\'.$dir)] = selectFileSystem($path.'\\'.$dir);
                        }else{
                            //无子目录成员或是文件时，取得目录或文件名
                            $dirArr[iconv('gbk', 'utf-8', $path.'\\'.$dir)] = iconv('gbk', 'utf-8', $dir);
                        }
                    }else{
                        //不遍历所有子目录时，取得当前目录成员
                        $dirArr[iconv('gbk', 'utf-8', $path.'\\'.$dir)] = iconv('gbk', 'utf-8', $dir);
                    }
                }
            }
        }else{
            $dirArr[iconv('gbk', 'utf-8', $path)] = get_basename($path);
        }
    }

    return $dirArr;
}


/**
 * 在浏览器中输出通过selectFileSystem()获取到的目录结构
 * @param unknown $dirArr   获取到的目录结构数组
 * @param number $nbspNum   遍历输出时控制目录成员位置的属性，不用指定，使用默认就可以
 */
function dumpFileSystem($dirArr, $nbspNum = 0){
    //判断是否是一个数组
    if(is_array($dirArr)){
        //遍历数组
        foreach ($dirArr as $key => $dir){
            //控制当前成员的位置
            for ($i = 0; $i <= $nbspNum - 1; $i ++){
                echo '| &nbsp;';
            }
            echo '|-&nbsp;';
            //判断当前成员是否是一个拥有子目成员的目录
            if(is_array($dir)){
                //先打印当前成员名
                echo explode('\\', $key)[count(explode('\\', $key)) - 1];
                echo '<br />';
                //递归输出子目录成员信息
                $nbspNum ++;
                dumpFileSystem($dir, $nbspNum);
                $nbspNum --;
            }else{
                //无子目录成员或是一个文件时，直接打印成员名
                echo $dir;
                echo '<br />';
            }
        }
    }else{
        echo 'Error Path';
    }
}


/**
 * 兼容中文路径的basename()
 * @param unknown $fileName 文件系统的路径
 * @return mixed            string 返回路径中的文件名部分
 */
function get_basename($fileName){

    return preg_replace('/^.+[\\\\\\/]/', '', $fileName);
}


/**
 * 复制文件系统，支持复制目录到目录，复制文件到目录，复制文件为目标文件
 * @param unknown $source   需要复制的源路径，如果是一个目录的话，会将连带着该目录一起复制到目标目录中
 * @param unknown $dest     需要复制到的目标路径
 * @return boolean          复制成功返回true，复制失败（权限不足、源文件系统不存在、复制目录到文件等）时返回false
 */
function copyFileSystem($source, $dest){

    //确认源路径是一个已经存在的文件或目录，且源路径和目标路径不是指向同一个文件系统，因为会陷入死循环
    if(file_exists(iconv('utf-8', 'gbk', $source)) && !($source == $dest)){

        //当源路径是一个目录，且目标路径也是一个已存在的目录时
        if(is_dir(iconv('utf-8', 'gbk', $source)) && is_dir(iconv('utf-8', 'gbk', $dest))){

            //当目标目录中不存在源根目录，试着创建一个，如果创建失败，结束函数
            if(!file_exists(iconv('utf-8', 'gbk', $dest.'\\'.get_basename($source))) && !mkdir(iconv('utf-8', 'gbk', $dest.'\\'.get_basename($source)))){
                return false;
            }

            //获取源目录的子成员
            $dirArr = selectFileSystem(iconv('utf-8', 'gbk', $source), false);
            if($dirArr){
                //遍历源目录的子成员
                foreach ($dirArr as $sonSource => $fileName){

                    //递归复制子成员，如果复制失败，结束函数
                    if(!copyFileSystem($sonSource, $dest.'\\'.get_basename($source))){
                        return false;
                    }
                }
            }

            //遍历执行完也没有结束函数，就算复制成功
            return true;

        }else{
            //当源路径是一个文件时
            //如果目标路径是一个目录，拼装目标路径
            if(is_dir(iconv('utf-8', 'gbk', $dest))){
                $dest = $dest.'\\'.get_basename($source);
            }

            //返回文件的复制操作结果
            return copy(iconv('utf-8', 'gbk', $source), iconv('utf-8', 'gbk', $dest));
        }
    }

    return false;
}


/**
 * 删除文件系统(同时删除目录下的目录及文件)，兼容中文路径
 * @param unknown $path 需要删除的路径
 * @return boolean      删除成功返回true，删除失败返回false
 */
function removeFileSystem($path){

    //判断要删除的路径是否是已存在的路径
    if(file_exists(iconv('utf-8', 'gbk', $path))){

        //判断需要删除的是目录还是文件
        if(is_dir(iconv('utf-8', 'gbk', $path))){

            //获取目录的子成员
            $dirArr = selectFileSystem(iconv('utf-8', 'gbk', $path));
            //判断目录是否有子成员
            if($dirArr){
                //遍历子成员
                foreach ($dirArr as $sonSource => $fileName){

                    //递归删除子成员，如果删除失败，结束函数执行
                    if(!removeFileSystem($sonSource)){
                        return false;
                    }
                }
            }

            //子成员删除成功后会执行到这里，把当前这个空的目录也删除了，并返回删除操作的执行结果
            return rmdir(iconv('utf-8', 'gbk', $path));

        }else{
            //尝试删除文件，并返回删除操作的执行结果
            return unlink(iconv('utf-8', 'gbk', $path));
        }
    }

    return false;
}
