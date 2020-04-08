/*建立上传插件对象*/


var upload = {};

/*上传图片表单*/



upload.form = "<form id= 'plugin-upload-form' enctype='multipart/form-data' method='post' style='display: none'>" +
    "<input id='plugin-upload-img' type ='file' name='file'>" +
    "<input type='radio' name='type' value='6' checked>"+
    "<input type='hidden' name='md5' id='md5' value=''>" +
    "</form>";


//获取完整路径
var href = window.location.href;
//以admin.php前后分离
var start = href.indexOf('admin.php');
var href_head = href.substring(0,start);
var href_end = href.substring(start);
//获取admin.php之后的模块名
var href_split = href_end.split('/');
//组装访问路径
upload.hrefHead = href_head+'admin.php/'+href_split[1];



/*上传图片,获取分辨率,获取标题,单选框选择URL*/
upload.uploadUrl = upload.hrefHead+'/Upload/newtest';

/*确定URl*/
upload.processUrl = upload.hrefHead+'/Upload/test';

/*检查数量URL*/

upload.checkNumber = upload.hrefHead+'/Upload/checkNumber';




/*加载时,检查是否有预览图片*/

upload.checkPreview = function(){
    var number = $('.myModal').length;
    for(i=0;i<number;i++){
        //开始检查是否有图片路径

        var pic_array = $('.myModal').eq(i).find('.getPicArray').val();
        var config = $('.myModal').eq(i).find('.config').val();
        console.log(pic_array);

        $.ajax({
            url: upload.uploadUrl,
            type:	'POST',
            cache:	false,
            async: false,
            data: {
                'pic_array':pic_array,
                'config':config
            }
        }).done(function(res){
            var obj = jQuery.parseJSON(res);
            console.log(obj);
            var id_string = '';
            for(o=0;o<obj.length;o++){
                if(!id_string){
                    id_string = id_string +obj[o]['id'];
                }else{
                    id_string = id_string+ ','+ obj[o]['id'];
                }
                $('.img-show').eq(i).prepend("<img src ='" + obj[o]['path'] + "' style = 'width:200px'>");

            }

            var name = $('.img-show').eq(i).attr('name');
            $('.img-show').eq(i).prepend("<input type='hidden' value='" + id_string  +"' name='"+name+"'>");



        })
    }

};

/*更改配置*/
upload.editConfig = function(){
    $('.editConfig').click(function(){
        var number = $('.editConfig').index(this);

        var default_config = jQuery.parseJSON($('.myModal').eq(number).find('.config').val());

        console.log(default_config);

        var cut_size = $('.img-show').eq(number).find('.config_cut_size').val();
        if(cut_size != ''){
            cut_size = cut_size.split(',');
        }


        var size = $('.img-show').eq(number).find('.config_size').val()*1048576;

        var width = $('.img-show').eq(number).find('.config_width').val();

        var height = $('.img-show').eq(number).find('.config_height').val();

        var type = $('.img-show').eq(number).find('.config_type').val();
        if(type !=''){
            type = type.split(',');
        }



        if(cut_size != '' && cut_size.length > 0){
            default_config['cut_size'] = cut_size;
        }
        if(type != '' && type.length > 0){
            default_config['type'] = type;
        }
        if(size != ''){
            default_config['size'] = size;
        }
        if(width != ''){
            default_config['width'] = width;
        }
        if(height != ''){
            default_config['height'] = height;
        }
        default_config = JSON.stringify(default_config);

        $('.myModal').eq(number).find('.config').val(default_config);

    })
};

upload.show = function(){
    $('.triggerBtn').click(function(){

        var number = $('.triggerBtn').index(this);
        $('.myModal').eq(number).show();


        var in_use =  $('.myModal').eq(number).find('.inUse').length;
        var a = '';
        //开始检查是否有图片路径
        var pic_array = $('.myModal').eq(number).find('.getPicArray').val();
        var config = $('.myModal').eq(number).find('.config').val();
        if(pic_array.length > 0 && in_use == 0){  //有初始图片, 并且是第一次加载初始图片
            $.ajax({
                url: upload.uploadUrl,
                type:	'POST',
                cache:	false,
                data: {
                    'pic_array':pic_array,
                    'config':config
                }
            }).done(function(res){
                var obj = jQuery.parseJSON(res);
                console.log(obj);
                var i;
                for(i=0;i<obj.length;i++){
                    var clone = $('.modal-body').eq(number).find('.clone:first').clone(true);
                        upload.addEditImg(number,clone,obj,a,i);


                }



            })
        }
    })
};

upload.addEditImg = function(number,clone,obj,a,i){
    $('.modal-body').eq(number).append(clone);
    $('.modal-body').eq(number).find('.clone').css('display','inline-block');
    $('.modal-body').eq(number).find('.clone:first').hide();
    $('.modal-body').eq(number).find('.clone:visible').addClass('inUse');
    $('.modal-body').eq(number).find('.inUse:visible').removeClass('clone');


    a = $('.modal-body').eq(number).find('.inUse').length;



    var newname = 'type_'+number + '_' + (a-1);


    $('.modal-body').eq(number).find('.inUse').eq(a-1).find('input[type=radio]').attr('name',newname);
    $('.modal-body').eq(number).find('.inUse').eq(a-1).find('input[type=radio][value='+obj[i].type+ ']').prop('checked',true);


    $('.modal-body').eq(number).find('.inUse').eq(a-1).find(".previewa").html("<div style='width: 450px;height: 300px;text-align: center'>" +
        "<img style='max-width: 100%;display: inline-block' src=" + obj[i].path + ">" +
        "<input style='display: none' class='temp-img' value=" + obj[i].temp_path + ">" +
        "</div>");
    $('.modal-body').eq(number).find('.inUse').eq(a-1).addClass('available');
};


/*获取添加图片按钮*/
upload.addUploadDivBtn = $('#addUploadDiv');

/*获取确定按钮*/
upload.confirm = $('#confirms');

/*取消按钮*/
upload.cancel = function () {

    $('.cancel').click(function(){

        var a = $('.cancel').index(this);


        //$('.myModal').eq(a).find('.inUse').remove();
        $('.myModal').eq(a).hide();
    })

    //$('.inUse').remove();
    //$('#myModal').hide();
};



/*弹出框上传图片按钮*/
upload.addUploadDiv = function () {
    $('.addUploadDiv').click(function(){
        //定位上传插件

        var m = $('.addUploadDiv').index(this);
        var config = $('.myModal').eq(m).find('.config').val();
        var n = $('.modal-body').eq(m).find('.inUse:visible').length;
        var o = 0;
        for (i = 0; i < n; i++) {
            if ($('.modal-body').eq(m).find('.inUse:visible').eq(i).find('p').length != 0) {
                o = o + 1;
            }
        }

        var p = n - o;  //已上传的图片数量
        $.ajax({
            url: upload.checkNumber,
            type:	'POST',
            cache:	false,
            async: false,
            data: {
                'number':p,
                'config':config
            },

        }).done(function(res){
            var obj = jQuery.parseJSON(res);
            console.log(obj);
            if(obj.code != 1){
                alert(obj.msg);
                constructor();
            }


        })

        var number = $('.addUploadDiv').index(this);

        var clone = $('.modal-body').eq(number).find('.clone:first').clone(true);

        var config_input_clone = $('.myModal').eq(number).find('.config').clone(true);




        $('.modal-body').eq(number).append(clone);
        $('.modal-body').eq(number).find('.clone').css('display','inline-block');
        $('.modal-body').eq(number).find('.clone:first').hide();
        $('.modal-body').eq(number).find('.clone:visible').addClass('inUse');
        $('.modal-body').eq(number).find('.inUse:visible').removeClass('clone');


        var a = $('.modal-body').eq(number).find('.inUse').length;



        var newname = 'type_'+ number +'_'+(a-1);


        $('.modal-body').eq(number).find('.inUse').eq(a-1).find('input[type=radio]').attr('name',newname);
        $('.modal-body').eq(number).find('.inUse').eq(a-1).find("input[type=radio][value='6']").prop('checked',true);


        $('.modal-body').eq(number).find('.inUse').eq(a-1).hide();

        if($('#plugin-upload-form').length != 0){
            $('#plugin-upload-form').remove();
        }
        $('body').append(upload.form);



        $('#plugin-upload-form').append(config_input_clone);
        $('#plugin-upload-form').find('.config').removeAttr('disabled');




        $("#plugin-upload-img").on('change',function() {

            // var abc = document.getElementById("plugin-upload-img");
            //
            // abc.addEventListener("select", function() {

            // var a= $('.inUse').length;

            //获取文件md5

            var input = this;





            var fileReader = new FileReader(),
                file = input.files[0];



            fileReader.onload = function (e) {


                var md5 = SparkMD5.ArrayBuffer.hash(e.target.result);
                $('#md5').val(md5);


                $.ajax({
                    url: upload.uploadUrl,
                    type:	'POST',
                    cache:	false,
                    data: new FormData($('#plugin-upload-form')[0]),
                    processData: false,
                    contentType: false
                }).done(function(res){
                    var obj = jQuery.parseJSON(res);
                    console.log(obj);
                    if(obj.code != 1){

                        alert(obj.msg);
                        $('.modal-body').eq(number).find('.inUse').eq(a-1).remove();
                        return;
                    }
                    $('.modal-body').eq(number).find('.inUse').eq(a-1).find(".previewa").html("<div style='width: 450px;height: 300px;text-align: center'>" +
                        "<img style='max-width: 100%;display: inline-block' src=" + obj.path + ">" +
                        "<input style='display: none' class='temp-img' value=" + obj.temp_path + ">" +
                        "</div>");
                    $('.modal-body').eq(number).find('.inUse').eq(a-1).show();
                    $('.modal-body').eq(number).find('.inUse').eq(a-1).addClass('available');
                    $('#plugin-upload-form').remove();


                })

            };

            fileReader.readAsArrayBuffer(file);







        });

        $('#plugin-upload-img').trigger('click');







    })

};

/*图片框小X*/
upload.removeImg = function () {
    $(".remove").click(function(){
        var a = $(".remove").index(this);

        $(".formBlock").eq(a).hide();
        $(".formBlock").eq(a).removeClass('clone');

    })
};




/*单选框change事件 即选择单选框*/
upload.radioChange = function () {
    $('input[type=radio]').change(function(){

        //获取这是第几个上传框
        var myModel_number = $('.myModal').index(this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode);
        var prev_pic_number = 0;
        //之前的所有上传框数量
        for(p=myModel_number;p>0;p--){
            prev_pic_number = prev_pic_number + $('.myModal').eq(p-1).find('.available').length;
        }


        //获取这是当前上传插件第几个图片框
        var a = $('.available').index(this.parentNode.parentNode.parentNode.parentNode) - prev_pic_number;

        var c = $('.inUse').index(this.parentNode.parentNode.parentNode.parentNode) - prev_pic_number;

        var sf = $('.myModal').eq(myModel_number).find('.available').eq(a).find('p');

        var temp_path = $('.myModal').eq(myModel_number).find('.available').eq(a).find(".temp-img").val();
        var config = $('.myModal').eq(myModel_number).find('.config').val();
        if(sf.length == 0){
            var b = $('.myModal').eq(myModel_number).find('.available').eq(a).find("input[type=radio][name=type_"+ myModel_number + "_"+ c + "]:checked").val();

            console.log(b);
            $.ajax({
                url: upload.uploadUrl,
                type:	'POST',
                cache:	false,
                data:  {
                    'temp_path': temp_path,
                    'checked': b,
                    'config':config
                }
            }).done(function(res){
                var obj = jQuery.parseJSON(res);
                console.log(obj);
                if(obj.code != 1){
                    alert(obj.msg);
                    return;
                }
                $('.myModal').eq(myModel_number).find('.available').eq(a).find(".previewa").html("<div style='width: 450px;height: 300px;text-align: center'>" +
                    "<img style='max-width: 100%;display: inline-block' src=" + obj.path + ">" +
                    "<input style='display: none' class='temp-img' value=" + obj.temp_path + ">" +
                    "</div>");


            })
        }
    })
};

/*确定按钮*/
upload.process = function () {
    //获取已经上传的图片数量
    $('.confirms').click(function(){


        var number = $('.confirms').index(this);

        var a = $('.modal-body').eq(number).find('.inUse:visible').length;
        var config = $('.myModal').eq(number).find('.config').val();
        var b = 0;
        for (i = 0; i < a; i++) {
            if ($('.modal-body').eq(number).find('.inUse:visible').eq(i).find('p').length != 0) {
                b = b + 1;
            }
        }

        var c = a - b;
        console.log(c);
        if (c == 0) {

            alert('上传图片不能为空');
            return;
        }

        var formdata = [];



        var Inuse_number = $('.modal-body').eq(number).find('.inUse').length;

        for (var i = 0; i < Inuse_number; i++) {

            if ($('.modal-body').eq(number).find('.inUse').eq(i).css('display') != 'none') {
                var input = $('.modal-body').eq(number).find('.inUse').eq(i).find("input[name=type_"+ number + "_" + i +"]:checked");


                new_obj = {
                    'type':'',
                    'name':''
                };
                new_obj.type = input[0].value;
                new_obj.name = $('.modal-body').eq(number).find('.inUse').eq(i).find('.temp-img').val();


                formdata.push(new_obj);



            } else {
                var new_obj = {
                    'type':'',
                    'name':''
                };
                if ($('.modal-body').eq(number).find('.inUse').eq(i).find('.sf').length == 0) {
                    new_obj.type = 0;
                    new_obj.name = $('.modal-body').eq(number).find('.inUse').eq(i).find('.temp-img').val();
                    formdata.push(new_obj);
                }

            }
        }
        console.log(formdata);


        var name = $('.img-show').eq(number).attr('name');

        var json_formdata = JSON.stringify(formdata);


        $.ajax({
            url: upload.processUrl,
            type: 'POST',
            cache: false,
            data: {
                'number': c,
                'data': json_formdata,
                'config':config
            }
        }).done(function (res) {
            var obj = jQuery.parseJSON(res);

            alert(obj.msg);
            console.log(obj);
            if (obj.code == 1) {
                $('.img-show').eq(number).find('img').remove();
                $('.img-show').eq(number).find('input').remove();
                $('.img-show').eq(number).find('button').remove();

                //$('.modal-body').eq(number).find('.inUse').remove();
                $('.myModal').eq(number).hide();
                var path = jQuery.parseJSON(obj.path);

                var o = path.length;
                var id_string = '';
                for(i=0;i<o;i++){
                    if(id_string == ''){
                        id_string = path[i]['id'];
                    }else{
                        id_string = id_string + ','+path[i]['id'];
                    }
                    var cut_size_string = path[i]['cut_size'].join(',');
                    $('.img-show').eq(number).prepend("<img src ='" + path[i]['elements'] + "' style = 'width:200px'>"
                    );
                }

                $('.img-show').eq(number).prepend("<input type='hidden' value='" + id_string  +"' name='"+name+"'>");
            }


        })
    })

};

/*插件初始化*/
upload.init = function () {
    var that = this;
    /*加载点击弹窗事件*/
    that.show();
    /*加载取消按钮事件*/
    that.cancel();
    /*加载添加图片事件*/
    that.addUploadDiv();
    /*加载关闭图片事件*/
    that.removeImg();
    /*加载单选框选择事件*/
    that.radioChange();
    /*加载确定按钮事件*/
    that.process();
    that.editConfig();
    upload.checkPreview();

};

upload.init();





