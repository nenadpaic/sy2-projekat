angular.module('profileControllers', ['services']).controller('TimeLineControllerEdit', function($scope){

}).controller('TimeLineGetController', function($scope, $location,  timeLineConnection, timeLineConnectionDelete, timeLineConnectionCreate){
	//init page
    $scope.page = 1;
    //init array for displaying posts
    $scope.timelineData = [];

    //Calls backend to get posts
	var call = function(){
		var params = {"user_id" : user_id, "page": $scope.page, "nonce" : nonce};

        $scope.time = timeLineConnection.get(params);


	};
    //Wacher for changes in $scope.time if changed pushes objects to array timelineData
    $scope.$watch('time', function(){

             $scope.timelineData.push($scope.time);


    });

	call();
	
    //editor button
    $scope.editor = false;

    $scope.editorEnabled = function(id){
        $location.url('/edit/'+id);
    }
    //Call for delete post @param int post_id
    $scope.deletePost = function(post_id){
    	var params = {'post_id': post_id};
    	timeLineConnectionDelete.save(params);
    	location.reload();
    	
    }
    //Call for create new post
    $scope.createPost = function(){
    	var params = {'content' : $scope.contentNew};
    	timeLineConnectionCreate.save(params);
        location.reload();
    }
    //Load new page
    $scope.load = function(){
    	$scope.page +=1;
        call();
    }

})
.controller('editController', function($scope,$location, $routeParams, timeLineConnectionSingle){
        var id = parseInt($routeParams.id);
        var params = {"post_id" : id};
        $scope.post = timeLineConnectionSingle.get(params);
        //Update given post, changes location to /
        $scope.updatePost = function(){
            var params = {"content" : $scope.post.content, "post_id": $scope.post.id};
            timeLineConnectionSingle.save(params);
            $location.url('/');
        };
        //Cancel update changes location to /
        $scope.cancelUpdate = function(){
            $location.url('/');
        };

    })
.controller('name', function(){
    
})