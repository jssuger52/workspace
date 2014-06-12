
$(function () {
  $('.link-next').click(function() {
    if ($(this).hasClass('link-none')) {
      // .link-noneがあったら次ページ遷移処理は行わない
      return;
    }
    var parentDiv = $(this).parents('div').get(0);
    var parentId = parentDiv.id;
    var targetId = parentId.substr(0,parentId.length-1);
    var targetNum = String(Number(parentId.substr(parentId.length-1,parentId.length)) + 1);
    var targetId = targetId + targetNum;
    $('.tab-contents').hide();
    $('#' + targetId).addClass('selected').fadeIn();
  });
  $('.link-prev').click(function() {
    if ($(this).hasClass('link-none')) {
      // .link-noneがあったら前ページ遷移処理は行わない
      return;
    }
    var parentDiv = $(this).parents('div').get(0);
    var parentId = parentDiv.id;
    var targetId = parentId.substr(0,parentId.length-1);
    var targetNum = String(Number(parentId.substr(parentId.length-1,parentId.length)) + -1);
    var targetId = targetId + targetNum;
    $('.tab-contents').hide();
    $('#' + targetId).addClass('selected').fadeIn();
  });
  $('.tab-link').click(function() {

    // .selectedがあるかどうか
    if (!$(this).hasClass('selected')) {
      $('.tab-contents').hide();
      // .selectedを削除
      $('.tab-link, .tab-contents').removeClass('selected');
      // クリックした要素に .selectedを追加
      $(this).addClass('selected');
      $('.tab-contents.type' + $(this).attr('data-type')).addClass('selected').fadeIn();
    }

    return false;
  });
});
