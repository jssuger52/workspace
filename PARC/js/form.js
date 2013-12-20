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
		var textList = new Array();
		if ($('input[name=privacy]', this).prop('checked') == false) {
		alert('個人情報の取り扱いについて同意していません');
		}		
		$('.form-01 li').each(function(){
			var tgt = $('input', this).val();
			if ($('option', this).is(':selected')) {
			tgt = $('option:selected', this).text();
			}
		console.log(tgt)
		textList.push(tgt);
		});
		var f = !$('.error').size();
		var p = $('input[name=privacy]', this).is(':checked');
		if (f && p){
			var body = textList.join('%0D%0A');
			location.href=('mailto:info@parc-manther.com?subject=商品の購入&body=' + body + '%0D%0A%0D%0Aお買い上げありがとうございます。%0D%0A入力内容を確認してメールを送信してください。');
		} 
		return false;
	});
});