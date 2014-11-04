angular.module('profileControllers', ['services']).controller('TimeLineControllerEdit', function($scope){

}).controller('TimeLineGetController', function($scope, $location,  timeLineConnection){
    var params = {"user_id" : user_id, "nonce" : nonce};
    $scope.timelineData = timeLineConnection.query(params);
    $scope.editor = false;
    $scope.content = "";
    $scope.editorEnabled = function(id){
        $location.url('/edit/'+id);
    }

})
.controller('editController', function($scope,$location, $routeParams, timeLineConnectionSingle){
        var id = parseInt($routeParams.id);
        var params = {"post_id" : id, 'nonce' : nonce};
        $scope.post = timeLineConnectionSingle.get(params);
        $scope.updatePost = function(){
            var params = {"content" : $scope.post.content, "post_id": $scope.post.id};
            timeLineConnectionSingle.save(params);
        };
        $scope.cancelUpdate = function(){
            $location.url('/');
        };

    });