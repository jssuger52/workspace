//レガシーブラウザでのhtml5要素認識
(function(){
	if(!/*@cc_on!@*/0)return;
	var e = "abbr,article,aside,audio,bb,canvas,datagrid,datalist,details,dialog,eventsource,figure,figcaption,footer,header,hgroup,mark,meter,nav,output,progress,section,time,video".split(',');
	for(var i=0;i<e.length;i++){document.createElement(e[i]);}
})();