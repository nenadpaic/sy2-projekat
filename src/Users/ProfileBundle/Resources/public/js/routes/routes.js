app.config(function($routeProvider){
   $routeProvider
       .when('/', {templateUrl: '/public/views/profile/index.html'})
       .when('/edit',{templateUrl: '/public/views/edit.html'});
});
