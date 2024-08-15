//Inicio o modulo de controle e uso o ngCordova que sera usado no compartilhamento
angular.module('starter.controllers', [])

.controller('PrincipalCtrl', function($scope, WebApi, $ionicPopup,$state,$ionicLoading) {
  // Variavel do scrll
  var userId = localStorage.getItem('userId');
  var facebook = localStorage.getItem('facebook');
  console.log(facebook);
  if(userId == null){
    $state.go('loginFB');
  }
  var buscaOK = true;
  $scope.scroll = true;
  $scope.qtd = 2;
  //Campo de busca
  $scope.textoBusca = "";
  //Realizo a limpeza do campo e busco de novo
  $scope.limparBusca = function () {
      refreshAll();
  }
  //Realizo a busca passando o texto da busca
  $scope.buscar = function () {
    getPosts();
    if (!buscaOK){
      popupAlert('Busca não encontrada','Nenhum resultado foi encontrado para a Palavra-chave informada');
      refreshAll();
    }
  }
  //curte post
  $scope.curtir = function(post){
    WebApi.post("Publicacao", "DesCurtir", "", {usuario: userId,publicacao: post.id}).success(function (data, status, headers, config) {
      if(data.retorno){
        if(post.curtido){
          post.curtidas = data.newcurtidas;
          post.curtido = false;
          post.btnCurtir = "-outline";
        }else{
          post.curtidas = data.newcurtidas;
          post.curtido = true;
          post.btnCurtir = "";
        }
      }else{
        popupAlert('ERRO!','Não foi possivel concluir a Solicitação. tente novamente');
      }
      console.log(data);
    }).error(function (data, status, headers, config) {
      console.log(data);
    });
  }
  //Faz atualização dos posts infinitamente
  $scope.carregarPosts = function(){
    $scope.qtd = $scope.qtd + 2;
    getPosts();
    $scope.$broadcast('scroll.infiniteScrollComplete');
  }
  //busca novos posts
  $scope.reload = function () {
      refreshAll();
      $scope.$broadcast('scroll.refreshComplete');
  }
  //emite mensagem popup
  function popupAlert(titulo,mensagem){
    $ionicPopup.alert({
      title: titulo,
      content: mensagem
    });
  }
  //reload na tela
  function refreshAll(){
    $scope.textoBusca = "";
    getPosts();
  }
  //Função principal da view
  function getPosts(){
    console.log(userId);
    WebApi.post("Publicacao", "lista", "", {qtd: $scope.qtd,filtro: $scope.textoBusca,usuario: userId}).success(function (data, status, headers, config) {
      $scope.posts = data.posts;
      if (!data.posts){
        buscaOK = false;
      }
      if(data.posts.length == data.totalPost){
        $scope.scroll = false;
      }
      $ionicLoading.hide();
      console.log(data);
    }).error(function (data, status, headers, config) {
      console.log(data);
    });
  }

  $ionicLoading.show({
    template: 'Carregando...'
  });
  getPosts();
})

.controller('PostDetalheCtrl', function($scope, $stateParams, WebApi, $ionicPopup,$state, $ionicActionSheet,$ionicLoading) {
  var userId = localStorage.getItem('userId');
  if(userId == null){
    $state.go('loginFB');
  }
  $scope.scrollComent = true;
  $scope.qtdComentarios = 2;
  WebApi.post("Publicacao", "ObterPost", "", {id: $stateParams.postId,usuario: userId}).success(function (data, status, headers, config) {
    $scope.publicacao = data.publicacao;
    console.log(data);
  }).error(function (data, status, headers, config) {
    console.log(data);
  });

  $ionicLoading.show({
    template: 'Carregando...'
  });
  getComentarios();

  //emite mensagem popup
  function popupAlert(titulo,mensagem){
    $ionicPopup.alert({
      title: titulo,
      content: mensagem
    });
  }

  //Faz atualização dos comentarios infinitamente
  $scope.carregarComentarios = function(){
    $scope.qtdComentarios = $scope.qtdComentarios + 4;
    getComentarios();
    $scope.$broadcast('scroll.infiniteScrollComplete');
  }
  //busca novos comentarios
  $scope.reloadComents = function () {
      getComentarios();
      $scope.$broadcast('scroll.refreshComplete');
  }

  $scope.onComentarioHold = function(e, itemIndex, comentario) {
    if(comentario.propriedade == true){
      $ionicActionSheet.show({
        buttons: [{
          text: 'Excluir Comentario'
        }],
        titleText: 'Opções',
        buttonClicked: function(index) {
          WebApi.post("Comentarios", "deleteComentario", "", {id: comentario.id}).success(function (data, status, headers, config) {
            if(data.retorno){
              getComentarios();
            }else{
              popupAlert('ERRO!','Não foi possivel concluir a Solicitação. Tente novamente!');
            }
            console.log(data);
          }).error(function (data, status, headers, config) {
            console.log(data);
          });
          return true;
        }
      });
    }
  }
  //Realizo a limpeza do campo de comentario
  $scope.limparTextoComentario = function () {
    limparTextoComentario();
  }

  function limparTextoComentario(){
    $scope.textoComentario = "";
  }

  //comentar
  $scope.comentar = function(idComent){
    WebApi.post("Comentarios", "comentar", "", {comentario: $scope.textoComentario,usuario: userId, publicacao: $stateParams.postId}).success(function (data, status, headers, config) {
      if(data.retorno){
        limparTextoComentario();
        getComentarios();
      }else{
        popupAlert('ERRO!','Não foi possivel concluir a Solicitação. tente novamente');
      }
      console.log(data);
    }).error(function (data, status, headers, config) {
      console.log(data);
    });
  }
  //Função principal da view
  function getComentarios(){
    console.log(userId);
    WebApi.post("Comentarios", "lista", "", {qtd: $scope.qtdComentarios,usuario: userId,publicacao: $stateParams.postId}).success(function (data, status, headers, config) {
      $scope.comentarios = data.comentarios;
      console.log(data);
      if(data.comentarios.length == data.totalComentarios || data.comentarios == false){
        $scope.scrollComent = false;
      }
      $ionicLoading.hide();
      console.log(data);
    }).error(function (data, status, headers, config) {
      console.log(data);
    });
  }
})

.controller('PerfilCtrl', function($scope, WebApi, $ionicPopup, $state, $ionicLoading, $ionicHistory) {
  var userId = localStorage.getItem('userId');
  if(userId == null){
    $state.go('loginFB');
  }
  $ionicLoading.show({
    template: 'Carregando...'
  });
  WebApi.post("Usuario", "obterUserLogado", "", {id: userId}).success(function (data, status, headers, config) {
    $scope.usuario = data.usuario;
    $ionicLoading.hide();
    console.log(data);
  }).error(function (data, status, headers, config) {
    console.log(data);
  });

  function popupAlert(titulo,mensagem){
    $ionicPopup.alert({
      title: titulo,
      content: mensagem
    });
  }

  $scope.editarPerfil = function(id){
    window.open('http://seguememd.16mb.com/sistema/index.php?Perfil/editar/id/'+ id, '_system');
  }

  $scope.alterarSenha = function(id){
    window.open('http://seguememd.16mb.com/sistema/index.php?Perfil/alterarSenha/id/'+ id, '_system');
  }

  $scope.deslogar = function(){
    localStorage.clear();
    $ionicHistory.clearCache().then(function(){$state.go('loginFB')});
  }

  $scope.mudarNotificacoes = function(){
    popupAlert('ERRO!','Esta função ainda nn encontra-se disponivel, aguarde próxima atualização!');
    $scope.usuario.notificacoes = false;
  }
})

.controller('LoginFBCtrl', function($scope, WebApi, $ionicPopup, $state) {
  var userId = localStorage.getItem('userId');
  if(userId !== null){
    $state.go('tab.principal');
  }

  function popupAlert(titulo,mensagem){
    $ionicPopup.alert({
      title: titulo,
      content: mensagem
    });
  }

  $scope.loginFacebook = function(authMethod){
    var ref = new Firebase("https://seguemelogin.firebaseio.com");
    ref.authWithOAuthPopup("facebook", function(error, authData) {
      if (error) {
        console.log("Login Failed!", error);
      } else {
        console.log(authData);
        WebApi.post("Usuario", "verificaUsuarioFB", "", {email: authData.facebook.email}).success(function (data, status, headers, config) {
          if (data.user === null){
            $ionicPopup.confirm({
              title: 'Usuario Não Encontrado!',
              content: 'Seguidor, venha se cadastrar!!!'
            })
            .then(function(result) {
              if(result) {
                localStorage.setItem("id",authData.facebook.id);
                localStorage.setItem("nome",authData.facebook.displayName);
                localStorage.setItem("email",authData.facebook.email);
                $state.go('loginComplete');
              }
            });
          }else{
            if(data.user === false){
              popupAlert('Usuario Desativado!','Opa, Seu usuario encontra-se desativado. Tente novamente mais tarde ou Contate o Administrador.');
            }else{
              localStorage.setItem("userId",data.user);
              $state.go('tab.principal');
            }
          }
        }).error(function (data, status, headers, config) {
          console.log(data);
        });
      }
    }, {
      scope: "email,public_profile"
    });
  };
})

.controller('LoginCompleteCtrl', function($scope, WebApi, $ionicPopup, $state) {
  $scope.primo = '1';
  $scope.tio = '2';
  $scope.form = {
    hierarquia: '1'
  };
  var email = localStorage.getItem('email');
  var nome = localStorage.getItem('nome');
  var id = localStorage.getItem('id');

  function popupAlert(titulo,mensagem){
    $ionicPopup.alert({
      title: titulo,
      content: mensagem
    });
  }

  $scope.cadastrar = function(){
    alert($scope.form.apelido);
    alert($scope.form.hierarquia);
    WebApi.post("Usuario", "inserirFB", "", {email: email,nome: nome,id: id, apelido: $scope.form.apelido, hierarquia: $scope.form.hierarquia}).success(function (data, status, headers, config) {
      if (data.retorno){
        popupAlert('Usuario Cadastrado!','Seu usuario foi cadastrado com Sucesso. Por favor, Aguarda avaliação dos Administradores.');
        $state.go('loginFB');
      }else{
        console.log(data.mensagem);
        popupAlert('Usuario Não Cadastrado!','Opa, Ocorreu um erro ao finalizar seu cadastro. Tente novamente mais tarde ou Contate o Administrador.');
      }
      console.log(data);
    }).error(function (data, status, headers, config) {
      console.log(data);
    });
  };
})

.controller('LoginCtrl', function($scope, WebApi, $ionicPopup, $state) {
  var userId = localStorage.getItem('userId');
  if(userId !== null){
    $state.go('tab.principal');
  }

  $scope.form = {};

  function popupAlert(titulo,mensagem){
    $ionicPopup.alert({
      title: titulo,
      content: mensagem
    });
  }

  $scope.logar = function(){
    WebApi.post("Usuario", "verificaUsuario", "", {email: $scope.form.email,senha: $scope.form.senha}).success(function (data, status, headers, config) {
      if (data.user === null){
        popupAlert('Usuario Não Encontrado!','Combinação de E-mail e Senha não foram encontrados no Sistema, Tente Novamente.');
      }else{
        if(data.user === false){
          popupAlert('Usuario Desativado!','Opa, Seu usuario encontra-se desativado. Tente novamente mais tarde ou Contate o Administrador.');
        }else{
          localStorage.setItem("userId",data.user);
          $state.go('tab.principal');
        }
      }
      console.log(data);
    }).error(function (data, status, headers, config) {
      console.log(data);
    });
  };
});
