var reader = new FileReader();

    reader.onload = function(e) {
        $("#preview_img").attr("src", e.target.result);
    }

    $("#id_pic").change(function() {
        var upload_file = $("#id_pic")[0].files[0];
        if(!upload_file.type.match('image.*')){
            alert ("請上傳正確的圖片格式(jpg/png/jepg)");
            $("#id_pic")[0].files[0] = null;
            
        }
        else reader.readAsDataURL(upload_file);
    })