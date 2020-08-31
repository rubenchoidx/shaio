// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['ionic', 'starter.controllers', 'starter.services'])

.run(function($ionicPlatform, $rootScope, $ionicLoading) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      cordova.plugins.Keyboard.disableScroll(true);

    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
        
        $rootScope.$on('loading:show', function() {
            
            $ionicLoading.show({template: '<ion-spinner></ion-spinner> ' + 'Cargando...' })
        })

        $rootScope.$on('loading:hide', function() {
            
            $ionicLoading.hide()
        })
        
        var retryRequest = function (confirmPopup, args) {

            confirmPopup.then(function(res) {
                
                if (res) {
                    
                    $http(args.rejection.config).then(function (result) {
                        
                        args.promise.resolve(result);
                    }, function () {
                        
                        args.promise.reject(args.rejection);
                    });
                }
            });
        }

        $rootScope.$on('response:error', function(event, args) {
                    
            var confirmPopup = $ionicPopup.confirm({
                title: 'Error inesperado',
                template: '¿Deasea intentar de nuevo? Detalles: ' + args.rejection.status
            });
            
            retryRequest(confirmPopup, args);
        })
  });
})

.config(function($stateProvider, $urlRouterProvider, $httpProvider) {
    $httpProvider.interceptors.push('GeneralInterceptor');
    
  $stateProvider

    .state('app', {
    url: '/app',
    abstract: true,
    templateUrl: 'templates/menu.html',
    controller: 'AppCtrl'
  })
    .state('app.cities', {
      url: '/cities',
      views: {
        'menuContent': {
          templateUrl: 'templates/cities.html',
          controller: 'CitiesCtrl'
        }
      }
    })

  .state('app.city', {
    url: '/city',
    views: {
      'menuContent': {
        templateUrl: 'templates/city.html',
        controller: 'CityCtrl'
      }
    },
    params: { city: null }
  });
  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/app/cities');
});
