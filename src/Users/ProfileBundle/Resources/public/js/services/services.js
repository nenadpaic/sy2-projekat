angular.module('services', ['ngResource'])
    .factory('timeLineConnection', function($resource){
        return $resource(path_time_line)
    })
    .factory('timeLineConnectionSingle', function($resource){
        return $resource(path_time_single)
    })
