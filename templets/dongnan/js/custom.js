/**
 * Created by hzliwenhao on 2017/8/19.
 */
function addClickEventForRTab() {
  $('div.nr li,div.nr h4').click(function () {
    console.log(this);
    var SID = $(this).attr('sid')
    $.cookie("SID", SID);
  });
}
