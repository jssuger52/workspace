
var KF = KF || {};
KF.Fncs = {};
KF.Run = {};

KF.Fncs.Tab = function(options){
	this.tab = options.tabName;
	this.btn = options.btnName;
	this.content = options.contentsName;
	this.inner = options.contentsInner;
	this.type = options.btnType;
	this.memory = options.memory;
	this.history = options.history;
	this.animation = options.animation;
	this.speed = options.animationSpeed;
	
	this.hashVal = null;
	
	this.stayBtn = {};
	this.stayContents = {};
	this.tabInner = {};
	this.stayImg = {};
	
	this.animeFinish = false;
	
	if(this.history ){
	    $(window).hashchange();
	}
};

KF.Fncs.Tab.prototype = {
	getHash : function(tab){
		var btn = this.btn,
			content = this.content,
			index = 0,
			id_name,
			that = this,
			i;

		if(location.hash === ''){
			return 0;
		}
		
		var hash = location.hash.replace(/#first-/,'');

		if(hash === undefined){
			return 0;
		}
			
		tab.find(content).each(function(i){
			id_name = this.getAttribute('id');
	
			if(hash.replace(/#first-/,'') === id_name){
				index = i;
			}
		});
		
		return index;
	},
	getCookie : function(id){
		var cookie = $.cookie(id);
		if(!cookie){
			return 0;
		}else{
			return cookie;
		}
	},
	setCookie : function(id,index){
		$.cookie(id, index, {
			expires: 365
		});
	},
	hashChecker : function(){
		var tab = this.tab,
			btn = this.btn,
			content = this.content,
			inner = this.inner,
			type = this.type,
			that = this;
			
		$(window).hashchange(function(){
			
			var timer = setInterval(function(){
				if (!that.animeFinish) {
					
					clearInterval(timer);
					
					var hash = location.hash;
					
					if (hash === '') {
						return false;
					}
					
					if (that.hashVal !== hash) {
					
						that.hashVal = hash.replace(/#history-/, '');
						
						$(tab).each(function(i){
							var container = $(this);
							
							container.find(content).each(function(j){
								if ($(this).attr('id') === that.hashVal) {
								
									that.stayBtn[i].removeClass('active');
									that.stayContents[i].removeClass('active');
									that.tabInner[i].removeAttr('style');
									
									that.stayBtn[i] = $($(container.find(btn).get(0)).children().get(j));
									that.stayContents[i] = $(container.find(content).get(j));
									that.tabInner[i] = $(that.stayContents[i].find(inner).get(j));
									
									that.stayBtn[i].addClass('active');
									that.stayContents[i].addClass('active');
									
									if (type === 'image') {
										that.stayImg[i].attr('src', that.stayImg[i].attr('src').replace(/_o/, ""));
										that.stayImg[i] = $(that.stayBtn[i].find('img').get(0));
										that.stayImg[i].attr('src', that.stayImg[i].attr('src').replace(/(\.[^\.]+$)/, "_o$1"));
									}
								}
							});
						});
					}
				}
			},1000);
		});
	},
	runTab : function(){
		var tab = this.tab,
			btn = this.btn,
			content = this.content,
			inner = this.inner,
			type = this.type,
			memory = this.memory,
			history = this.history,
			animation = this.animation,
			speed = this.speed,
			that = this;
		
		$(tab).each(function(i){

			var id_name = this.getAttribute('id'),
				stay_num = that.getHash($(this)),
				contents = $(this).find(content),
				btns = $($(this).find(btn).get(0)).children(),
				stay_image;

			if(id_name && memory){
				stay_num = that.getCookie(id_name);
			}
			
			if(history){
				location.href = btns.find('a').get(stay_num).getAttribute('href',2).replace(/#/,'#history-');
			}
			
			that.stayBtn[i] = $($(btns).get(stay_num)),
			that.stayContents[i] = $($(contents).get(stay_num)),
			that.tabInner[i] = $(that.stayContents[i].find(inner).get(stay_num));
			
			$(this).addClass('active');
			that.stayBtn[i].addClass('active');	
			that.stayContents[i].addClass('active');
			
			if(type === 'image'){
				that.stayImg[i] = $(that.stayBtn[i].find('img').get(0));
				that.stayImg[i].attr('src', that.stayImg[i].attr('src').replace(/(\.[^\.]+$)/, "_o$1"));
				
				$(btns).mouseover(function(){
					if(!$(this).is('.active')){
						var img = $(this).find('img');
						img.attr('src', img.attr('src').replace(/(\.[^\.]+$)/, "_o$1"));
					}
				});
				$(btns).mouseout(function(){
					if (!$(this).is('.active')) {
						var img = $(this).find('img');
						img.attr('src', img.attr('src').replace(/_o/, ""));
					}
				});
			}
			
			if (history) {
				that.hashChecker();
			}
		
			$(btns).click(function(){

				var index = btns.index(this),
					btn = $(this),
					tab_height;
				
				
				that.tabInner[i].removeAttr('style')
				
				if($(this).is('.active')){
					return false;
				}
				
				if(memory){
					that.setCookie(id_name,index);
				}
				
				that.stayBtn[i].removeClass('active');
				
				that.stayContents[i].removeClass('active');
				that.tabInner[i].removeAttr('style');
				that.tabInner[i].stop();
				
				that.stayBtn[i]  = $($(btns).get(index));
				that.stayContents[i] = $($(contents).get(index));
				that.tabInner[i] = $(that.stayContents[i].find(inner).get(0));
				
				if (type === 'image') {
					that.stayImg[i].attr('src', that.stayImg[i].attr('src').replace(/_o/, ""));
					that.stayImg[i] = $($(this).find('img').get(0));
				}
				
				if(animation.fade || animation.slide){
					
					that.stayBtn[i].addClass('active');
					that.stayContents[i].addClass('active');
					
					if(animation.fade === true && animation.slide === false){
						that.tabInner[i].css({
							opacity : 0
						});
						
						that.animeFinish = true;
						
						that.tabInner[i].animate({
							opacity: 1
						}, {
							duration: speed,
							easing: "linear",
							complete: function(){
								that.animeFinish = false;
							}
						}
						, false);
					}else if(animation.fade === false && animation.slide === true){
						
						tab_height = that.tabInner[i].height();
						
						that.tabInner[i].css({
							height : 0
						});
						
						that.animeFinish = true;
						
						that.tabInner[i].animate({
							height : tab_height
						}, {
							duration: speed,
							easing: "linear",
							complete: function(){
								that.tabInner[i].css({
									height : 'auto'
								});
								that.animeFinish = false;
							}
						}
						, false);
					}else if(animation.fade === true && animation.slide === true){
						
						tab_height = that.tabInner[i].height();
						
						that.tabInner[i].css({
							opacity : 0,
							height : 0
						});
						
						that.animeFinish = true;
						
						that.tabInner[i].animate({
							opacity: 1,
							height:tab_height
						}, {
							duration: speed,
							easing: "linear",
							complete: function(){
								that.tabInner[i].css({
									height : 'auto'
								});
								that.animeFinish = false;
							}
						}
						, false);
					}
				}else{
					that.stayBtn[i].addClass('active');
					that.stayContents[i].addClass('active');
				}
				
				if(history){
					location.hash = btn.find('a').get(0).getAttribute('href',2).replace(/#/,'#history-');
				}
				
				return false;
			});			
		});
	}
};

KF.Run.Tab = function(options){
	var ins_tab = new KF.Fncs.Tab(options);
	ins_tab.runTab();
};

$(document).ready(function(){

	KF.Run.Tab({
		tabName : '.tab-container-01',
		btnName : '.tab-btns',
		contentsName : '.tab-contents',
		contentsInner : '.tab-inner',
		memory : false,
		history : false,
		animation : {fade : true , slide : true}
	});
	
	KF.Run.Tab({
		tabName : '.tab-container-02',
		btnName : '.tab-btns',
		contentsName : '.tab-contents',
		contentsInner : '.tab-inner',
		memory : true,
		history : false,
		animation : {fade : false , slide : true},
		animationSpeed : 300
	});
	
	KF.Run.Tab({
		tabName : '.tab-container-03',
		btnName : '.tab-btns',
		contentsName : '.tab-contents',
		contentsInner : '.tab-inner',
		memory : false,
		history : false,
		animation : {fade : true , slide : false},
		animationSpeed : 300
	});
	
	KF.Run.Tab({
		tabName : '.tab-container-04',
		btnName : '.tab-btns',
		contentsName : '.tab-contents',
		contentsInner : '.tab-inner',
		memory : false,
		history : true,
		animation : {fade : true , slide : false},
		animationSpeed : 300
	});
	
	KF.Run.Tab({
		tabName : '.tab-container-05',
		btnName : '.tab-btns',
		contentsName : '.tab-contents',
		contentsInner : '.tab-inner',
		btnType : 'image',
		memory : true,
		history : false,
		animation : {fade : false , slide : false}
	});

});
