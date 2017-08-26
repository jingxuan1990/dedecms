/**
 * Created by hzliwenhao on 2017/8/19.
 */

// 改变新闻中心list_news4中的图片的显示位置.
function changePicLocation() {
  $('.news_con>dl>dt').each(function (index, element) {
    if ((index + 1) % 2 == 0) {
      $(element).removeClass("fr");
      $(element).addClass("fl");
    }
  });
}