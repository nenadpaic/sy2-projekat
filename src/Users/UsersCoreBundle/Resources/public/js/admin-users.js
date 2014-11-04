/*
* @params int user_id, int role_id
* @returns alert with message
* Add role to user from show users action
 */
function addRole(user_id, role_id, path ){
    $.ajax({
        url: path,
        type: 'POST',
        dataType: 'json',
        data: {'user_id' : user_id, 'role_id' : role_id},
        success:function(data){
            alert(data.message);
            location.reload();
        },
        error:function(){
            alert("Error with connection, try again");
        }
    });
}
/*
* @params int user_id, int role_id
* @returns alert with message
* Removes role from user
 */
function removeRole(role_id,user_id, path ){
    $.ajax({
        url: path,
        type: 'POST',
        dataType: 'json',
        data: {'role_id': role_id, 'user_id': user_id},
        success:function(data){
            alert(data.message);
            location.reload();
        },
        error:function(){
            alert("Error with connection, try again");
        }
    });
}
/*
* @params int user_id
* @returns alert message
* Removes profile image from user
*
 */
function removeProfileImage(user_id,path){
    $.ajax({
       url: path,
       type: "POST",
       dataType: "json",
       data: {"user_id": user_id},
       success:function(data){
            alert(data.message);
           location.reload();
       } ,
       error:function(){
           alert("Error in connection, try again");
       }
    });
}

/*
 * @params int user_id
 * @returns alert message
 * Removes timeline image from user
 *
 */
function removeTimelineImage(user_id,path){
    $.ajax({
        url: path,
        type: "POST",
        dataType: "json",
        data: {"user_id": user_id},
        success:function(data){
            alert(data.message);
            location.reload();
        } ,
        error:function(){
            alert("Error in connection, try again");
        }
    });
}