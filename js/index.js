var app = angular.module('app', ['ngMaterial','angularGrid']);

app.controller('MainCtrl', function($scope, $http, $q) {
  var vm = this;
  $scope.card = {};
  $scope.card.title = 'test';
  vm.page = -1;
  vm.shots = [];
  vm.loadingMore = false;
  vm.category = 'popular';
/*
  $('.category').click(function(){
  	$scope.card = {};
  	$scope.card.title = 'test';
  	vm.page = -1;
 	vm.shots = [];
  	vm.loadingMore = false;
	vm.category = $(this).text(); 
  	vm.loadMoreShots();
  });
*/
  vm.loadMoreShots = function() {
    if(vm.loadingMore) return;
    vm.page++;
    // var deferred = $q.defer();
    vm.loadingMore = true;
    var promise = $http.get("../includes/ajax/getIdeas.php?num="+vm.page+"&category="+vm.category);
    promise.then(function(data) {
      var shotsTmp = angular.copy(vm.shots);
      shotsTmp = shotsTmp.concat(data.data);
      vm.shots = shotsTmp;
      vm.loadingMore = false;
    
    }, function() {
      vm.loadingMore = false;
    });
    return promise;
  };

  vm.loadMoreShots();

});
app.filter('unsafe', function($sce) { return $sce.trustAsHtml; });



