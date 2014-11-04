"use strict";
function deletedoc(document_id, path){
    $.ajax({
        url: path,
        dataType: 'json',
        type: 'POST',
        data: {"document_id" : document_id},
        beforeSend:function(){
            $('#loader').show();
        },
        success:function(data){
            $('#loader').hide();
            alert(data.message);
            location.reload();
        },
        error:function(){
            alert("Error in connection try again");
        }
    });
}
