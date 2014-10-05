/*
* @params int user_id, int role_id
* @returns alert with message
* Add role to user from show users action, target addRoleAction in User controller
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
* Removes role from user, target removeRoleFromUserAction UserController
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