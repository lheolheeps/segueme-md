window.fbAsyncInit = function() {
  FB.init({
    appId      : '551390258376077',
    xfbml      : true,
    version    : 'v2.5'
  });
};

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));
 
 //Usada com os resultados da função FB.getLoginStatus
function statusChangeCallback(response) {
    //retorno com o status de autenticação do usuario
    if (response.status === 'connected') {
        //conectado com sucesso
        usuarioConectado();
    } else if (response.status === 'not_authorized') {
        //Logado no fb mas nn no app
        //alert('Necessário Autorizar Aplicação');
        usuarioConectado();
    } else {
        // não Logado no fb
        //alert('Necessário Logar no Facebook');
        FB.login();
        usuarioConectado();
    }
}

// Usada quando alguem termina a sessao clicando no botão login
function checkLoginState() {
    FB.getLoginStatus(function (response) {
        statusChangeCallback(response);
    });
}

// Obter dados do usuario
function usuarioConectado() {
    FB.login(function () {
        // usada para chamar  o Graph API - parametro '\me' é usado para obter as informações do uruario
        // fields define oq vc quer receber do usuario
        FB.api('/me', {fields: 'id,email'}, function (response) {
            var ajax = iniciaAjax();
            if (ajax) {
                ajax.open("GET", "index.php?Logon/loginFB/email/" + response.email, true);
                ajax.onreadystatechange = function () {
                    if (ajax.readyState == 4) {
                        if (ajax.status == 200) {
                            tratarRetorno(ajax.responseText);
                        } else {
                            alert("Um Erro inesperado aconteceu, Por favor contate o administrador [ERFBAJAX001]");
                        }
                    }
                };
                ajax.send(null);
            }
            else {
                alert("Um Erro inesperado aconteceu, Por favor contate o administrador [ERFBAJAX002]");
            }
        });
    }, {scope: 'public_profile,email'}); // permissoes do usuario
}


function iniciaAjax() {
    var req;

    try {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch (e) {
        try {
            req = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (ex) {
            try {
                req = new XMLHttpRequest();
            }
            catch (exc) {
                alert("Browse Não suportado, Favor Tente em Outro Navegador!");
                req = null;
            }
        }
    }
    return req;
}

function tratarRetorno(result) {
    if (result === 'erro' || result === 'tipo' || result === 'status') {
        // usuario não encontrado
        window.location = "index.php?Logon/login";
    }else if(result === 'ok'){
        // Confirmado
        window.location = "index.php?Index/index";
    } else {
        alert('Um Erro inesperado aconteceu, Por favor contate o administrador [ERFBAJAX003]');
    }
}
