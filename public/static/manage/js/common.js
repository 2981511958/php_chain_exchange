/**
 * 公共函数库
 * @author HuangYu
 */


//获取当前请求URL
function getUrl(){
	return document.location.href;
}


//获取当前页面Title
function getTitle(){
	return $('title').text();
}


//获取客户端屏幕宽度
function getScreenWidth(){
	return window.screen.width;
}


//获取客户端屏幕高度
function getScreenHeight(){
	return window.screen.height;
}


//获取设备操作系统
function getOS(){
	var sUserAgent = navigator.userAgent;
	var isWin = (navigator.platform == "Win32") || (navigator.platform == "Windows"); 
	var isMac = (navigator.platform == "Mac68K") || (navigator.platform == "MacPPC") || (navigator.platform == "Macintosh") || (navigator.platform == "MacIntel"); 
	if (isMac) 
		return "Mac"; 
	var isUnix = (navigator.platform == "X11") && !isWin && !isMac; 
	if (isUnix) 
		return "Unix"; 
	var isLinux = (String(navigator.platform).indexOf("Linux") > -1);
	var bIsAndroid = sUserAgent.toLowerCase().match(/android/i) == "android";
	if (isLinux) {
		if(bIsAndroid) 
			return "Android";
		else 
			return "Linux";
	}
	if (isWin) { 
		var isWin2K = sUserAgent.indexOf("Windows NT 5.0") > -1 || sUserAgent.indexOf("Windows 2000") > -1; 
		if (isWin2K) return "Win2000"; 
			var isWinXP = sUserAgent.indexOf("Windows NT 5.1") > -1 || sUserAgent.indexOf("Windows XP") > -1; 
		if (isWinXP) return "WinXP"; 
			var isWin2003 = sUserAgent.indexOf("Windows NT 5.2") > -1 || sUserAgent.indexOf("Windows 2003") > -1; 
		if (isWin2003) return "Win2003"; 
			var isWinVista= sUserAgent.indexOf("Windows NT 6.0") > -1 || sUserAgent.indexOf("Windows Vista") > -1; 
		if (isWinVista) return "WinVista"; 
			var isWin7 = sUserAgent.indexOf("Windows NT 6.1") > -1 || sUserAgent.indexOf("Windows 7") > -1; 
		if (isWin7) return "Win7"; 
	} 
	return navigator.platform;
}


//获取具体IE版本号
function checkIEVersion() { 
	var ua = navigator.userAgent; 
	var s = "MSIE"; 
	var i = ua.indexOf(s)          
	if (i >= 0) { 
	   	//获取IE版本号 
		var ver = parseFloat(ua.substr(i + s.length)); 
	   	return ver;
	} 
	return false;
}


//验证电子邮箱地址格式
function checkEmailFomat(emailStr){
	var myreg = /[\w!#$%&'*+\/=?^_`{|}~-]+(?:\.[\w!#$%&'*+\/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?/;
	if(myreg.test(emailStr))
		return true;
	return false;
}


//验证上传的文件是否是需要的文件格式（后缀）
//typeStr是希望的文件格式组成的字符串，多个用'，'分开。如"jpg,jpeg,png,gif,bmp,JPG,JPEG,PNG,GIF,BMP"
function checkUploadFileType(filepath, typeStr){
	if(filepath == '')
		return false;
	//为了避免转义反斜杠出问题，这里将对其进行转换
	var re = /(\\+)/g; 
	var filename=filepath.replace(re,"#");
	//对路径字符串进行剪切截取
	var one=filename.split("#");
	//获取数组中最后一个，即文件名
	var two=one[one.length-1];
	//再对文件名进行截取，以取得后缀名
	var three=two.split(".");
	 //获取截取的最后一个字符串，即为后缀名
	var last=three[three.length-1];
	//返回符合条件的后缀名在字符串中的位置
	var rs=typeStr.indexOf(last);

	//如果返回的结果大于或等于0，说明包含允许上传的文件类型
	if(rs<0){
		return false;
	}
	return true;
}


/**
 * 获取上传的图片的可预览地址
 * objId 上传控件的ID
 * return string 返回图片的预览地址
 */
function getUploadImgUrl(objId){
	var f= document.getElementById(objId).files[0];
	var src=window.URL.createObjectURL(f);
	return src;
}


/**
 * 判断一个值是否为正整数
 * value 需要检测的值
 * return boolean 如果是正整数返回true，否则返回false
 */
function isNum(value){
	var re = /^[1-9]+[0-9]*]*$/;
	if (re.test(value)){
		return true; 
	} 
	
	return false;
}


/**
* 校验只要是数字（包含正负整数，0以及正负浮点数）就返回true
**/

function isNumber(val){

    var regPos = /^\d+(\.\d+)?$/; //非负浮点数
    var regNeg = /^(-(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*)))$/; //负浮点数
    if(regPos.test(val) && regNeg.test(val)){
        return true;
    }else{
        return false;
    }

}


/**
 * 判断一个值是否为人民币货币值
 * @param  {string}  value 需要判断的值
 * @return {Boolean}       返回检测结果，是货币值返回true，不是货币值返回false
 */
function isMoney(value){

	var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;

	return reg.test(value);
}


/**
 * 只允许输入数字的情况下，行内监听以下脚本
 * 例：onkeydown="myNumberKeyDown(event)" onkeypress="myNumberKeyPress(event)"
 */
function myNumberKeyDown(event) {

	if(event.keyCode==13)event.keyCode=9;
}
function myNumberKeyPress(event) {

	if ((event.keyCode<48 || event.keyCode>57)) event.returnValue=false;
}

/* oninput="value=value.replace(/[^\d]/g,'')" */


/**
 * 获取最小值和最大值之间原整数(包含最小值和最大值,并可以指定一个数组,数组中放不希望得到的数字)
 * @param  {int}   _min 最小值
 * @param  {int}   _max 最大值
 * @param  {array} _not 不希望出现的数字组成的数组
 * @return {int}        返回包含最小值和最大值的一个随机整数
 */
function randNum(_min, _max, _not){

    var _this = this;

    //判断是否传入了第三个参数,并赋缺省值
    _not = _not == undefined ? new Array() : _not;

    //生成一个随机数
    var _result = parseInt(Math.random() * (_max - _min + 1) + _min, 10);

    //遍历不希望数组
    for(var i in _not){

        //判断生成的随机数是否是不希望的数字,如果是不希望的数字,递归执行,直到返回一个不是不希望的数字
        _result = _result == _not[i] ? _this.rand_num(_min, _max, _not) : _result;
    }

    return _result;
}


/**
 * 替换文本中所有需要替换的字符串
 * @param  {string} _str     需要被替换的字符串
 * @param  {stirng} _search  需要搜索的字符串
 * @param  {string} _replace 需要替换为新的字符串
 * @return {stirng}          返回完全替换过的字符串
 */
function replaceAll(_str, _search, _replace){

    return _str.replace(new RegExp(_search, "g"), _replace);
}


// 格式化限制数字文本框输入，只能数字或者两位小数
function format_input_num(obj){
    // 清除"数字"和"."以外的字符
    obj.value = obj.value.replace(/[^\d.]/g,"");
    // 验证第一个字符是数字
    obj.value = obj.value.replace(/^\./g,"");
    // 只保留第一个, 清除多余的
    obj.value = obj.value.replace(/\.{2,}/g,".");
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
}
