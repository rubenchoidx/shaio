angular.module('starter.controllers', [])

.controller('AppCtrl', function($rootScope, $scope, $ionicModal, $timeout, $filter) {

  // With the new view caching in Ionic, Controllers are only called
  // when they are recreated or on app start, instead of every page change.
  // To listen for when this page is active (for example, to refresh data),
  // listen for the $ionicView.enter event:
  //$scope.$on('$ionicView.enter', function(e) {
  //});
  
  $scope.showLoading = function() {
    $ionicLoading.show({
      template: 'Cargando...'
    });
  };
  
  $scope.hideLoading = function(){
    $ionicLoading.hide();
  };
  
  $scope.loginData = {};

  // Create the login modal that we will use later
  $ionicModal.fromTemplateUrl('templates/login.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.modal = modal;
  
    if (!sessionStorage.username)      
      $scope.login();
    else
        start()
  });

  // Triggered in the login modal to close it
  $scope.closeLogin = function() {
    $scope.modal.hide();
  };

  // Open the login modal
  $scope.login = function() {
    $scope.modal.show();
  };
            
$rootScope.$on('cities_changed', function (event, cities) {
    
    $rootScope.$apply(function () {
        
        $rootScope.cities = $filter('orderBy')(cities, 'doc.land');
    })
})

var start = function () {
            
    $rootScope.$broadcast('loading:show')
    
    var remote = 'https://'+sessionStorage.username+':'+sessionStorage.pass+'@iridian.cloudant.com/cities';
    $rootScope.db = new PouchDB('cities');
        
    $rootScope.db.sync(remote, { live: true, retry: true })
        .on('paused',function(info) {
            
            $rootScope.$broadcast('loading:hide')
            
            $rootScope.db.allDocs({ descending: true, include_docs: true })
                .then(function (result) {
                    
                    $rootScope.$broadcast('cities_changed', result.rows);         
                });     
        })
}

  // Perform the login action when the user submits the login form
  $scope.doLogin = function() {
    
    sessionStorage.username = $scope.loginData.username;
    sessionStorage.pass = $scope.loginData.password;//37d6c5Qe
    
    var db = new PouchDB('https://iridian.cloudant.com/cities', {skipSetup: true});
    
    db.login(sessionStorage.username, sessionStorage.pass).then(function (user) {
        
        start();
            
        $scope.closeLogin();
    })
    .catch(function (error) {
                
        alert(error.reason);
    });
  };
})

.controller('CitiesCtrl', function($rootScope, $scope, $state, $ionicPopup) {
    
    $scope.add = function () {
        
        $state.go('app.city');
    }
    
    $scope.edit = function (city) {
        
        $state.go('app.city', { city: city });
    }
    
    $scope.delete = function (city) {
            
        var confirmPopup = $ionicPopup.confirm({
            title: 'Eliminar ciudad',
            template: '¿Está seguro que desea eliminar ' + city.doc.land + '?'
        });

        confirmPopup.then(function(res) {
            
            if(res)        
                $rootScope.db.remove(city.doc)
                    .catch(function (err) {
                        
                        alert(err);
                    });
        });
    }
})

.controller('CityCtrl', function($rootScope, $scope, $state, $stateParams) {
    
    if ($stateParams.city)
        $scope.data = $stateParams.city.doc;
    else
        $scope.data = {};
    
    $scope.submit = function (form) {
        
        if (form.$valid) {
            
            var action;
            
            if ($stateParams.city)
                action = $rootScope.db.put($scope.data);
            else
                action = $rootScope.db.post($scope.data);
            
            action
                .then(function (response) {
            
                    $state.go('app.cities');                    
                }).catch(function (err) {
                    
                    alert(err);
                });
        }
    }
});
