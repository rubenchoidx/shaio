angular.module('starter.services', [])

.factory('GeneralInterceptor', function($q, $rootScope, $injector) {
	
	var loadingCount = 0;
        
    return {
        request: function (config) {
            
            if (config.url.indexOf('http://') == 0 || config.url.indexOf('https://') == 0) {     
        
                if (config.timeout == null)
                    config.timeout = 20000;
                
                $rootScope.$broadcast('loading:show')
                    
                loadingCount++;
            }
            
            return config
        },
        response: function (response) {
            
            if (response.config.url.indexOf('http://') == 0 || response.config.url.indexOf('https://') == 0) {
            
                loadingCount--;
                
                if (loadingCount == 0)
                    $rootScope.$broadcast('loading:hide')
            }
            
            return response
        },
        responseError: function (rejection) {
            
            if (rejection.config.url.indexOf('http://') == 0 || rejection.config.url.indexOf('https://') == 0) {
            
                loadingCount--;
                
                if (loadingCount == 0)
                    $rootScope.$broadcast('loading:hide')
                    
                var dfd = $q.defer();
                
                $rootScope.$broadcast('response:error', { rejection: rejection, promise: dfd });
            
                return dfd.promise
            }
            
            return $q.reject(rejection)
        }
    }
})