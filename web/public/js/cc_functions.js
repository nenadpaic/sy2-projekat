function check_the_size_of_image(size,id){
//get the file size and file type from file input field
    var img = $("#"+id);
    if(img[0].files[0] != "undefined"){
        var velicina = size;
        var fsize = img[0].files[0].size;
        var ftype = img[0].files[0].type;
        if(fsize>velicina){
            var img_size_in_mb = velicina/1024/1024;
            img_size_in_mb = img_size_in_mb.toFixed(1);
            alert("Image size must be less than "+ img_size_in_mb +"mb, please upload another image or resize this one");
            img.replaceWith( img = img.clone( true ) );
        }
        switch(ftype){
            case 'image/png':
            case 'image/jpeg':
            case 'image/pjpeg':
            case 'image/jpg':
                break;
            default:
                alert('Image must be jpg,jpeg or png format');
                img.replaceWith( img = img.clone( true ) );
        }
    }
}
