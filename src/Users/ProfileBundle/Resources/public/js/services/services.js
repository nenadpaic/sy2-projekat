angular.module('services', ['ngResource'])
    .factory('timeLineConnection', function($resource){
        return $resource(path_time_line)
    })
    .factory('timeLineConnectionSingle', function($resource){
        return $resource(path_time_single+'?nonce='+nonce)
    })
    .factory('timeLineConnectionDelete',function($resource){
    	return $resource(path_time_delete+'?nonce='+nonce)
    })
    .factory('timeLineConnectionCreate',function($resource){
    	return $resource(path_time_create+'?nonce='+nonce)
    })
    .factory('getGaleries', function($resource){
    return $resource('/api/get/galeries')
})
