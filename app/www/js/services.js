angular.module('starter.services', [])

.factory('WebApi', function ($http) {

     var self = this;

     self.getPath = function () {
         return "http://seguememd.16mb.com/sistema/index.php?WebApi/index/Service/l/";
         //return "http://localhost/seguememdsistema/index.php?WebApi/index/Service/l/";
     };

     self.getUrlApi = function (logic, action, params) {
         if (params === undefined) {
             params = "";
         }
         return self.getPath() + logic + "/a/" + action + "/" + params;
     };

     self.post = function (logic, action, params, jsonDados) {
         return $http({
             method: "POST",
             url: self.getUrlApi(logic, action, params),
             headers: {
                 'Content-Type': undefined
             },
             data: jsonDados
         });
     };

     self.get = function (logic, action, params) {
         return $http({
             method: "GET",
             url: self.getUrlApi(logic, action, params)
         });
     };

     return self;
 });
