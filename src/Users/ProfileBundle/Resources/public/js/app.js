var app = angular.module('profile', ['profileControllers', 'ngRoute', 'services'], function($interpolateProvider){
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});
