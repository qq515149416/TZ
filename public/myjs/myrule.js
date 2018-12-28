
// 正则规则 
var ENG = /^[A-Za-z]+$/;
var chn = /^[\u0391-\uFFE5]+$/;
var MAIL = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; 
var URL = /^http[s]?:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/;
var CURRENCY = /^\d+(\.\d+)?$/; 
var NUMBER = /^\d+$/; 
var INT = /^[0-9]{1,30}$/; 
var DOUBLE = /^[-\+]?\d+(\.\d+)?$/; 
var USERNAME = /^[a-zA-Z]{1}([a-zA-Z0-9]|[._]){4,19}$/;
var DOMAIN = /^[a-zA-Z0-9]{1}([a-zA-Z0-9-]|[._]){1,19}$/;
var PASSWORD = /^(\S){6,20}$/; 
var SAFE = />|<|,|\[|\]|\{|\}|\?|\/|\+|=|\||\'|\\|\"|:|;|\~|\!|\@|\#|\*|\$|\%|\^|\&|\(|\)|`/i; 
var DBC = /[ａ-ｚＡ-Ｚ０-９！＠＃￥％＾＆＊（）＿＋｛｝［］｜：＂＇；．，／？＜＞｀～　]/; 
var QQ = /[1-9][0-9]{4,15}/; 
var DATE = /^((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-))$/; 
var YEAR = /^(19|20)[0-9]{2}$/; 
var MONTH = /^(0?[1-9]|1[0-2])$/; 
var DAY = /^((0?[1-9])|((1|2)[0-9])|30|31)$/; 
var HOUR = /^((0?[1-9])|((1|2)[0-3]))$/; 
var MINUTE = /^((0?[1-9])|((1|5)[0-9]))$/; 
var SECOND = /^((0?[1-9])|((1|5)[0-9]))$/; 
var MOBILE = /^1[3|4|5|8|9][0-9]\d{8}$/;
var PHONE = /^[+]{0,1}(\d){1,3}[ ]?([-]?((\d)|[ ]){1,12})+$/; 
var ZIPCODE = /^[1-9]\d{5}$/; 
var BODYCARD = /^((1[1-5])|(2[1-3])|(3[1-7])|(4[1-6])|(5[0-4])|(6[1-5])|71|(8[12])|91)\d{4}((19\d{2}(0[13-9]|1[012])(0[1-9]|[12]\d|30))|(19\d{2}(0[13578]|1[02])31)|(19\d{2}02(0[1-9]|1\d|2[0-8]))|(19([13579][26]|[2468][048]|0[48])0229))\d{3}(\d|X|x)?$/; 
var IP = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/; 
var FILE = /^[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; 
var IMAGE = /.+\.(jpg|gif|png|bmp)$/i; 
var WORD = /.+\.(doc|rtf|pdf)$/i; 

function eq(arg1,arg2){ return arg1==arg2 ? true:false;};
function gt(arg1,arg2){ return arg1>arg2 ? true:false;};
function gte(arg1,arg2){ return arg1>=arg2 ? true:false;};
function lt(arg1,arg2){ return arg1<arg2 ? true:false;};
function lte(arg1,arg2){ return arg1<=arg2 ? true:false;};

//循环匹配正则表达式
//text要比较的字符串  rules比较项目数组
function compareReAndText (text,rulesParam) {
	if (!text) {
		return -1;
	}
	var rules = undefined;
	if (rulesParam instanceof Array) {
		//参数是多个正则数组
		rules = rulesParam;
	} else {
		//参数可传递一个直接的正则表达式,如果正则参数非数组,则要封装为数组
		rules = new Array(rulesParam);
	}
	text = $.trim(text);
	//循环匹配表达式，可是同时匹配多个正则
	for (var i = 0 ; i < rules.length ; i++) {
		var re = rules[i];
		if (re.exec(text)) {
			return 0;
		} else {
			return -1;
		}
	}
}

//返回文字信息提示
function showSuccessMes (mesid,mes) {
	mesid = "#"+mesid;
	$(mesid).html(mes);
}


//输入验证,rxrules正则表达式,elemId获取输入值的节点ID,errorid错误提示的显示节点ID,requied是否必填(requied=true必填),mes错误信息
function valiInput(rxrules,elemId,errorid,requied,mes) {
	var id = "#"+elemId;
	var errid = "#"+errorid;
	var value = $(id).val();
	if (requied==false && !value){
		return true;
	}
	var rules = new Array(rxrules);
	var rs = compareReAndText(value,rules);
	if (errorid) {
		checkImgShow(errid,rs,mes);
	}
	if (rs == 0) {
		return true;
	} else if (rs == -1) {
		return false;
	} 
}
//eng: 英文 
//mail: 邮箱 
//url: 网址 
//currency: 货币 
//number: 数字 
//int: 整数 
//double: 浮点数 
//username:数字和英文及下划线和.的组合，开头为字母，6-20个字符 
//password: 数字和英文及下划线的组合，6-20个字符 
//safe:不含特殊字符 
//dbc: 含全角字符(汉字除外) 
//qq: 5-9位数字 
//date: 时间 
//year: 年 
//month:月 
//day: 日 
//hour: 小时 
//minute:分 
//second 秒 
//mobile:手机 
//phone:电话 
//zipcode: 邮编 
//bodycard: 身份证，支持15位、18位源码天空，x字母 
//ip: IP 
//file: 文件类型 
//image: 图片文件类型 
//word: 文档文件类型 


