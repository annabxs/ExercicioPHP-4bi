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

$_verificaEmail = "SELECT id from tbl_usuarios where email = :email";
$preparaConsulta = $cn->prepare($_verificaEmail);
// A seta serve passar dados através de mpétodo.
$preparaConsulta->bindvalue(':email', $email, PDO::PARAM_STR);
$preparaConsulta->execute();


// Se tiver alguma dessas informações apresentadas acima
if($preparaConsulta->rowCount() > 0){
    echo "<script>
        alert('O email informado já está cadastrado! Tente fazer o login');
        windows.location.href='login.php';
         </script>";


    }

else{
    $senhahash = password_hash($senha, PASSWORD_DEFAULT);
    $inserirusuario = "INSERT INTO tbl_usuarios(nome, email, senha, tipo_perfil)
    values (:nome, :email, :senha, :tipo_perfil)";

        try{
        $prepararinsert = $cn->prepare($inserirusuario);
        $prepararinsert->bindvalue(':nome', $nome);
        $prepararinsert->bindvalue(':email', $email);
        $prepararinsert->bindvalue(':senha', $senhahash);
        $prepararinsert->bindvalue(':tipo_perfil', $tipoPerfil);
        $prepararinsert->execute();
        
        echo "<script>
                alert('Usuário cadastrado com sucesso! Clique Ok para voltar a tela de login.')
                window.location.href = 'login.php'
            </script>";
            }

        catch(PDOException $erro){
            echo "Ocorreu um erro!".$erro->getMessage();
        }
    }
}

?>  