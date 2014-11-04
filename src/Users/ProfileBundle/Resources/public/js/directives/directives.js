app.directive('newline', function(){
    return {
        restrict: 'E',
        compile: function(tElement, attrs){
            var content = angular.element('<div class="row"></div>');
            content.append(tElement.contents());
            tElement.replaceWith(content);
        }
    }
});
app.directive('col', function(){
    return {
        restrict: 'E',
        compile: function(tElement, attrs){
            var content = angular.element('<div class="col-md-12"></div>');
            content.append(tElement.contents());
            tElement.replaceWith(content);
        }
    }
});
app.directive('name', function(){
    return {
        restrict: 'E',
        compile: function(tElement, attrs){
            var content = angular.element('<h3></h3>');
            content.append(tElement.contents());
            tElement.replaceWith(content);
        }
    }
});
app.directive('date', function(){
    return {
        restrict: 'E',
        compile: function(tElement, attrs){
            var content = angular.element('<small></small>');
            content.append(tElement.contents());
            tElement.replaceWith(content);
        }
    }
});
app.directive('content',function(){
    return {
        restrict: 'E',
        compile:function(tElement, attrs){
            var content = angular.element('<p></p>');
            content.append(tElement.contents());
            tElement.replaceWith(content);
        }
    }
});
