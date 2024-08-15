// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['ionic', 'starter.controllers', 'starter.services', 'firebase'])

.run(function($ionicPlatform,$http,$ionicPopup) {
  $ionicPlatform.ready(function() {
    // Checar Conexão com internet
    if(window.Connection) {
      if(navigator.connection.type == Connection.NONE) {
        $ionicPopup.confirm({
          title: 'Falha na Conexão',
          content: 'Não foi possivel estabelecer uma conexão com a Internet'
        })
        .then(function(result) {
          if(!result) {
            ionic.Platform.exitApp();
          }
        });
      }
    }
  })
  $http.defaults.headers.common;
  $http.defaults.headers.common.Authorization = 'Basic aWdvcjp0ZXN0ZQ==';
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      cordova.plugins.Keyboard.disableScroll(true);

    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider, $ionicConfigProvider) {

  $ionicConfigProvider.tabs.position('bottom');

  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider

  // rota tela de Login
  .state('loginFB', {
    cache: false,
    url: '/loginFB',
    templateUrl: 'templates/loginFB.html',
    controller: 'LoginFBCtrl'
  })

  .state('loginComplete', {
    url: '/loginComplete',
    templateUrl: 'templates/loginComplete.html',
    controller: 'LoginCompleteCtrl'
  })

  .state('login', {
    url: '/login',
    templateUrl: 'templates/login.html',
    controller: 'LoginCtrl'
  })

  // setup an abstract state for the tabs directive
    .state('tab', {
    url: '/tab',
    abstract: true,
    templateUrl: 'templates/tabs.html'
  })

  // Each tab has its own nav history stack:

  .state('tab.principal', {
      url: '/principal',
      views: {
        'tab-principal': {
          templateUrl: 'templates/tab-principal.html',
          controller: 'PrincipalCtrl'
        }
      }
    })
    .state('tab.post-detalhe', {
      url: '/principal/:postId',
      views: {
        'tab-principal': {
          templateUrl: 'templates/post-detalhe.html',
          controller: 'PostDetalheCtrl'
        }
      }
    })

  .state('tab.perfil', {
      cache: false,
      url: '/perfil',
      views: {
        'tab-perfil': {
          templateUrl: 'templates/tab-perfil.html',
          controller: 'PerfilCtrl'
        }
      }
    });

  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/loginFB');

});
