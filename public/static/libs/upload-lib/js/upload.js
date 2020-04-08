
var uploadUrl = 'newtest.php';
var processUrl = 'test.php';
function getresolution(){
    $.ajax({
        url: uploadUrl,
        type:	'POST',
        cache:	false,
        data: {
            'resolution':'true',
        },
    }).done(function(res){
        var obj = jQuery.parseJSON(res);
        console.log(obj);

        $('.resolution').html('最低分别率'+obj.resolution);


    })
}

function getTitle(){
    $.ajax({
        url: uploadUrl,
        type:	'POST',
        cache:	false,
        data: {
            'title':'true',
        },
    }).done(function(res){
        var obj = jQuery.parseJSON(res);
        console.log(obj);

        $('.title').html(obj.title);


    })
}
getTitle();
getresolution();


$('#cancle').click(function(){
    $('.inUse').remove();
    $('#myModal').hide();
})



$('#addUploadDiv').click(function(){

    var clone = $('.clone:first').clone(true);


    $('.modal-body').append(clone);
    $(".clone").show();
    $('.clone:first').hide();
    $('.clone:visible').addClass('inUse');
    $('.inUse:visible').removeClass('clone');

    var a= $('.inUse').length;
    $('.inUse').eq(a-1).hide();
    $('.inUse').eq(a-1).find('.change').trigger('click');





})



$(".test").click(function(){
    /*
     *  检查当前div 是否已传图
     */

    var a = $(".test").index(this);

    $(".formBlock").eq(a).hide();
    $(".formBlock").eq(a).removeClass('clone');





})

$(".change").change(function() {
    var a= $('.inUse').length;
    console.log(a);

    //var a = $(".change").index(this);
    $.ajax({
        url: uploadUrl,
        type:	'POST',
        cache:	false,
        data: new FormData($('.inUse').eq(a-1).find('form')[0]),
        processData: false,
        contentType: false
    }).done(function(res){
        var obj = jQuery.parseJSON(res);
        console.log(obj);
        if(obj.code != 1){

            mizhu.toast(obj.msg);
            $('.inUse').eq(a-1).remove();
            return;
        }
        $('.inUse').eq(a-1).find(".change").parent().prev().html("<div style='width: 450px;height: 300px;text-align: center'><img style='max-width: 100%;display: inline-block' src=" + obj.path + "></div>");
        $('.inUse').eq(a-1).show();


    })




});


/**
 * 选择单选框事件
 */

$('input[type=radio][name=type]').change(function(){
//获取这是第几个表单
    var a = $('form').index(this.parentNode.parentNode.parentNode.parentNode);

    var sf = $('form').eq(a).find('p');

    var useNumber = $('.inUse').length;
    if(sf.length == 0){
        var b = $('form').eq(a).find('input[type=radio]:checked').val();
        console.log(b);

        $.ajax({
            url: uploadUrl,
            type:	'POST',
            cache:	false,
            data:  {
                'in_turn': a,
                'checked': b,
                'use_number': useNumber,
            },
        }).done(function(res){
            var obj = jQuery.parseJSON(res);
            console.log(obj);
            if(obj.code != 1){
                mizhu.toast(obj.msg);
                return;
            }
            $(".change").eq(a).parent().prev().html("<div style='width: 450px;height: 300px;text-align: center'><img style='max-width: 100%;display: inline-block' src=" + obj.path + "></div>");

        })
    }
})

/*
*  按确定按钮
*/
$('#confirm').click(function(){
//获取已经上传的图片数量
    var a = $('.inUse:visible').length;

    var b = 0;
    for(i=0;i<a;i++){
        if($('.inUse:visible').eq(i).find('p').length != 0){
            b = b +1;
        }
    }

    var c = a-b;
    console.log(c);
    if(c == 0 ){

        alert('请至少添加一张图片');
        return;
    }

    var formdata = [];

    var Inuse_number = $('.inUse').length;
    for(var i=0;i<Inuse_number;i++){

            if($('.inUse').eq(i).css('display') != 'none'){
                input = $('.inUse').eq(i).find("input[name='type']:checked");
                formdata.push(input[0].value);
            }else{
                if($('.inUse').eq(i).find('.sf').length == 0){
                    formdata.push(0);
                }

            }
    }
    console.log(formdata);


    var json_formdata = JSON.stringify(formdata);


    $.ajax({
        url: processUrl,
        type:	'POST',
        cache:	false,
        data: {
            'number':c,
            'data':json_formdata,
        },
    }).done(function(res){
        var obj = jQuery.parseJSON(res);
        console.log(obj);
        alert(obj.msg)

        if(obj.code == 1){
            $('.inUse').remove();
            $('#myModal').hide();
        }


    })

})

