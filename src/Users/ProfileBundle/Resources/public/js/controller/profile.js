angular.module('profileControllers', ['services']).controller('TimeLineControllerEdit', function($scope){

}).controller('TimeLineGetController', function($scope, timeLineConnection){
    var params = {"user_id" : user_id, "nonce" : nonce};
    $scope.timelineData = timeLineConnection.query(params);
});
