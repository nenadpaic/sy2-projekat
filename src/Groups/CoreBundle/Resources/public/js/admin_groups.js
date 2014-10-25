/**
 *
 * @param group
 * @param route
 * @returns {*}
 *
 * Uploading timeline image for group
 */
function upload_timeline_photo(group,route){
    var formData = new FormData();
    var file1 = $("#upload-timeline");
    var action = 1;
    if (!$(file1).val()){
        return alert("You must choose image first");
    }
    formData.append('image', file1[0].files[0]);
    formData.append('group',group);
    formData.append('action',action);
    $.ajax({
        url: route,
        type: "POST",
        data: formData,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#upload-timeline-modal-body .btn-success").prop("disabled",true);
        },
        success: function(data){
            $("#upload-timeline-modal-body .btn-success").prop("disabled",false);
            $('#upload-timeline-modal').modal('hide');
            $("#warnings").html("<p class='bg-success'>"+data.message+"</p>");
            $("#group-cover-photo img").attr("src", data.file);
        },
        error: function(data){
            $("#upload-timeline-modal-body .btn-success").prop("disabled",false);
            alert(data.responseText)
        }
    })
}

/**
 *
 * @param group
 * @param route
 * @returns {*}
 *
 * Uploading logo photo, admin
 */
function upload_logo_photo(group,route){
    var formData = new FormData();
    var file1 = $("#upload-logo");
    var action = 2;

    if (!$(file1).val()){
        return alert("You must choose image first");
    }
    formData.append('image', file1[0].files[0]);
    formData.append('group',group);
    formData.append('action',action);
    $.ajax({
        url: route,
        type: "POST",
        data: formData,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#upload-logo-modal-body .btn-success").prop("disabled",true);
        },
        success: function(data){
            $("#upload-logo-modal-body .btn-success").prop("disabled",false);
            $('#upload-logo-modal').modal('hide');
            $("#warnings").html("<p class='bg-success'>"+data.message+"</p>");
            $("#group-logo-photo img").attr("src", data.file);
        },
        error: function(data){
            $("#upload-logo-modal-body .btn-success").prop("disabled",false);
            alert(data.responseText)
        }
    })
}

/**
 *
 * @param action
 * @param user
 * @param group
 * @param route
 *
 * Accepting or declining user, if he sent request to enter group
 */
function accept_to_group(action,user,group,route){
    $.ajax({
        url: route,
        type: "POST",
        dataType: "JSON",
        data: {group: group, action: action, user: user},
        beforeSend: function(){
            $("#group-requests-"+user+"> button").prop('disabled',true);
        },
        success: function(data){
            if(data.message == 1){
                $("#group-requests-"+user).html("<p class='bg-success'>User accepted to group</p>")
            }
            else if (data.message == 0){
                $("#group-requests-"+user).html("<p class='bg-warning'>User declined</p>")
            }
        },
        error:function(data){
            alert(data.responseText)
        }
    })

}