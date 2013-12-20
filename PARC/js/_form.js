$(document).ready(function(){
	$("form").validate({
		rules: {
			name :{
				required: true
			},
			mail :{
				required: true,
				email: true
			},
			address :{
				required: true
			},
			products :{
				required: true
			},
			size :{
				required: true
			}
		},
		messages: {
			name :{
				required: "お名前を入力してください"
			},
			mail :{
				required: "メールアドレスを入力してください",
				email: "正しいメールアドレスを入力してください"
			},
			address :{
				required: "住所を入力してください"
			},
			products :{
				required: "商品を選択してください"
			},
			size :{
				required: "サイズを選択してください"
			}
		}
	});
	$('form').on('submit', function(){
		var f = !$('.error').size();
		var p = $('input[name=privacy]', this).is(':checked');
		if (!p) {
		alert('個人情報の取り扱いについて同意していません');
		}		
		var name = $('[name=name]', this).val();
		var mail = $('[name=mail]', this).val();
		var address = $('[name=address]', this).val();
		var products = $('.form-select-01 option:selected', this).text();
		var size = $('.form-select-02 option:selected', this).text();
		if (f && p){
			location.href=('mailto:jssuger52@gmail.com?subject=商品の購入&body=' + name + '%0D%0A' + mail + '%0D%0A' + address+ '%0D%0A' + products + '%0D%0A' + size + '%0D%0A%0D%0入力内容を確認してメールを送信してください。');
			return false;
		} 
	});
	$('.photo a').colorbox();
});