/*
 * @params int group_id, int action, string route
 * @returns alert with message
 * Add role to user from show users action, target addRoleAction in User controller
 */
function user_group_status(group,action,route){
    if(action == 1) {
        var r = confirm("Are you sure you want to leave this group?");
        if (r === false) {
            return "";
        }
    }
    $.ajax({
        url: route,
        method: 'POST',
        dataType: "JSON",
        data: {group_id: group, action: action},
        beforeSend: function(){
            $("#enter-group-"+group +"> button").prop('disabled',true);
        },
        success: function(data){
            if(action == 0) {
                $("#enter-group-" + group).html('<button class="btn btn-default" disabled>' +
                    'Request Sent' +
                    '</button>'
                );
            }
            else if(action == 1){
                $("#enter-group-"+group).html('<button class="btn btn-default" onclick="user_group_status('+group+',0,\''+route+'\')">'+
                'Join Group'+
                '</button>'
                );
            }
            alert(data.message);

        },
        error:function(){
            alert("Error with connection, try again");
        }
    });

}