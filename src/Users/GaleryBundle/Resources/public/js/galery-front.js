/*
* @param int id, string path
* @return alert message (success or fail)
* Removes image from galery
 */
function removeGaleryImage(id,path){
    $.ajax({
       url: path,
       type: "POST",
       dataType: "json",
       data: {"picture_id" : id},
       beforeSend:function(){
         $('#loader').show();
       },
       success:function(data){
           $('#loader').hide();
            alert(data.message);
           location.reload();
       },
       error:function(){
           alert("Error in connection");
       }
    });
}
