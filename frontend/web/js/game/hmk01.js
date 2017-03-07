var progress=document.querySelector('.pros');
var start=document.querySelector('.start');
var pros=document.getElementsByClassName('pro')[0];
var over=document.getElementsByClassName('over')[0];
var restart=document.getElementsByClassName('restart')[0];
var container=document.querySelector('.container');
var scores=document.querySelector('h1');
var s=0;
var rules=document.querySelector('.rules');
var rule=document.querySelector('.rule');
var close=document.querySelector('a');
// 开始游戏
start.onclick=function(){
	// 按钮移除
	this.remove();
	// 进度条
	var proLeft=0;
	var timer_pro=setInterval(function(){
		proLeft-=0.045;
		pros.style.backgroundPositionX=proLeft+'px';
		if (proLeft<=-270) {
			clearInterval(timer_pro);
			clearInterval(circle);
			over.style.display='block';
			restart.style.display='block';
		}
	},5)
	star();	// 第一次游戏的函数
	res();	// 调用重新开始的函数
}

// 游戏开始函数
function star(){
	//=============================================================================游戏进行时
	circle=setInterval(function(){
	//灰太狼随机出现的位置
	var arrPos = [
		{left:"170px",top:"210px"},
		{left:"50px",top:"280px"},
		{left:"45px",top:"370px"},
		{left:"70px",top:"480px"},
		{left:"200px",top:"450px"},
		{left:"330px",top:"480px"},
		{left:"320px",top:"356px"},
		{left:"305px",top:"250px"},
		{left:"200px",top:"450px"}
	];
	// 将图片存进数组
	var wolf_1=['/images/game/h0.png','/images/game/h1.png','/images/game/h2.png','/images/game/h3.png','/images/game/h4.png','/images/game/h5.png','/images/game/h6.png','/images/game/h7.png','/images/game/h8.png','/images/game/h9.png'];
	var wolf_2=['/images/game/x0.png','/images/game/x1.png','/images/game/x2.png','/images/game/x3.png','/images/game/x4.png','/images/game/x5.png','/images/game/x6.png','/images/game/x7.png','/images/game/x8.png','/images/game/x9.png'];
	var appearWolf=['/images/game/h0.png','/images/game/x0.png'];
	var newImg=document.createElement('/images/game');
	container.appendChild(newImg);
	var wfLocation=rand(0,8);	// 狼的随机位置
	newImg.style.left=arrPos[wfLocation].left;
	newImg.style.top=arrPos[wfLocation].top;
	newImg.style.position='relative';
	var X=rand(0,2);		// 选择灰太狼还是小灰灰
	if (X<2){
		X='h';
	}else{
		X='x';
	}
	var y=0;
		newImg.style.display='block';
		var appear0=setInterval(function(){
			newImg.src='/images/game/'+X+y+'.png';
			y++;
			var indexs=0;
			newImg.onclick=function(){
				indexs++;
				if (indexs>1) {
					return false;		// 鼠标只能点击1次 而不能无限点
				}
				y=5;
				for (var i=0;i<4;i++) {
					y++;
					newImg.src=wolf_1[y];
					if(y>9){
						y--;
					}
				}
				if (X=='h') {
					s+=10;
					scores.innerHTML=s;
				}else if (X=='x'){
					s-=10;
					if (s<=0) {
						s=0;
					}
					scores.innerHTML=s;
				}
			}
			if (y>5) {
				clearInterval(appear0);
				setTimeout(function(){
					y=5;
					var appear1=setInterval(function(){
						newImg.src='/images/game/'+X+y+'.png';
						console.log(y);
						y--;
						if (y<0) {
							clearInterval(appear1);
							// newImg.style.display='none';
							newImg.remove();
						}
					},50)
				},stay)
			}
		},50);
},secs)
	s=0;
	scores.innerHTML=s;
//=============================================================================游戏结束
}
// 重新开始函数
function res(){
	restart.onclick=function(){
		// 按钮移除
		restart.style.display='none';
		over.style.display='none';
		var proLeft=0;
		var timer_pro=setInterval(function(){
			proLeft-=0.045;
			pros.style.backgroundPositionX=proLeft+'px';
			if (proLeft<=-270) {
				clearInterval(timer_pro);
				over.style.display='block';
				restart.style.display='block';
			}
		},5)
		star();
	}
}
rules.onclick=function(){
	rule.style.display='block';
}
close.onclick=function(){
	rule.style.display='none';
}



// 随机函数
function rand(min,max){
	return Math.round(Math.random()*(max-min)+min);
}
var secs=rand(1200,1500);
var stay=rand(150,250);
var phoneWidth = parseInt(window.screen.width);
var phoneScale = phoneWidth/640;

var ua = navigator.userAgent;
if (/Android (\d+\.\d+)/.test(ua)){
	var version = parseFloat(RegExp.$1);
	// andriod 2.3
	if(version>2.3){
		document.write('<meta name="viewport" content="width=640, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
		// andriod 2.3以上
	}else{
		document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
	}
	// 其他系统
} else {
	document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
}
