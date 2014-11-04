angular.module('services', ['ngResource'])
    .factory('timeLineConnection', function($resource){
        return $resource(path_time_line)
    });
