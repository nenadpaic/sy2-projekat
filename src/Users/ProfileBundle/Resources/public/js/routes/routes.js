app.config(function($routeProvider){
   $routeProvider
       .when('/', {templateUrl: '/public/views/profile/index.html'})
       .when('/edit/:id',{templateUrl: '/public/views/profile/edit.html'});
});
