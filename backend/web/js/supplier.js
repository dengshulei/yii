
//点击选中一个checkbox
function id_click() {
    let ids = '';
    $( "input[name$='id[]']:checked" ).each(function (){
        ids += $(this).val() + ',';
    });
    $('#suppliersearch-ids').val(ids);
    check_all_click();
}
//点击全选checkbox
function check_all_click(){
    //let ids = $("#grid").yiiGridView("getSelectedRows");  //获取ids，形如：123,456,789
    if ($(".select-on-check-all").get(0).checked) {
        //全选，先统计选中了多少条，然后更新并显示提示消息
        let id_len = $( "input[name$='id[]']" ).length;
        $('#warn-total').html(id_len);
        $('#warn-body').css('display', '');
        $('#warn-1').css('display', '');
        $('#warn-2').css('display', 'none');
        $('#suppliersearch-all-type').val('1');

        //alert(ids);
    } else {
        //取消全选
        selected_all_disable();
    }
}

//取消全选
function selected_all_disable(){
    $('#warn-total').html(10);
    //$('#warn-body').css('display', 'none');
    $('#warn-1').css('display', 'none');
    $('#warn-2').css('display', 'none');
    $('#suppliersearch-all-type').val('0');
}
//选中所有搜索出来的结果，不仅限本页展示
function warn_select_all(){
    $('#warn-body').css('display', '');
    $('#warn-1').css('display', 'none');
    $('#warn-2').css('display', '');
    $('#suppliersearch-all-type').val('2');
}
//取消选中所有搜索出来的结果，仅限本页展示全选
function warn_select_clear(){
    $('#warn-body').css('display', '');
    $('#warn-1').css('display', '');
    $('#warn-2').css('display', 'none');
    $('#suppliersearch-all-type').val('1');
}

//导出
function export_click(){
    let  ids = $('#suppliersearch-ids').val() + '';
    let  all_type = parseInt($('#suppliersearch-all-type').val());
    if (ids === '' && all_type === 0) {
        alert('Which column(s) to be included in the CSV and column "id" is mandatory.')
        return false;
    }
    let url = '/supplier/export?rnd=' + (Math.random() * 99999999).toString();
    if (all_type === 1) {
        console.log(getUrlParam('page'));
        url += '&page=' + getUrlParam('page');
    }
    if (all_type === 2) {
        url += '&page=1&per-page=100000';
    }
    $( "input[name^='SupplierSearch']" ).each(function (){
        url += '&' + $(this).prop('name') + '=' + $(this).val();
    });
    $( "select[name^='SupplierSearch']" ).each(function (){
        url += '&' + $(this).prop('name') + '=' + $(this).val();
    });
    console.log(url)
    window.open(url)
    //alert('You haven\'t selected any data yet!');
}

function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg); //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}