<?php 
// inserindo arquivo de conexão.
include "conexao.php";

// Verificando se o método de envio de dados foi $_POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
// trim remove espaços em branco antes e depois da string
// 'nome', entre as aspas simples, referencia o name da txt dada em cadastro.pgp
$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
// Não colocamos a função trim na senha, pois pode ser que os espaços em branco façam parte da senha
$senha = $_POST['senha'];
$tipoPerfil = trim($_POST['tipo_perfil']);

$_verificaEmail = "SELECT id from tbl_usuarios where email : email";
$preparaConsulta = $cn=prepare($_verificaEmail);
// A seta serve passar dados através de mpétodo.
$preparaConsulta->bindvalue(':email', $email, PDP::PARAM_STR);
$preparaConsulta->execute();
}

// Se tiver alguma dessas informações apresentadas acima
if($preparaConsulta->rowCount > 0){
    echo "<script>
        alert("O email informado já está cadastrado! Tente fazr o login");
        widowns.location.href="login.php";
         </script>";


}


?>