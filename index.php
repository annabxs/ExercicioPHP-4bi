<?php 
include "conexao.php";

$consultaSQL = "select id, titulo, descricao, salario, localizacao from tbl_vagas";

//executando a consulta. É a variával $cn que tem acesso ao banco de dados
// Seta sempre significa que ele vai acessar um método
// Comando query executa a consulta que foi guardado dentro da variável consultaSQL
$execConsulta = $cn->query($consultaSQL);

// transforma essas vagas(consulta) em um array
$vagas = $execConsulta->fetchAll();
// o isset, se vier verdadeiro, executa a função que está depois do ponto de interrogação; caso o isset vier falso, ele executa o que está após os dois pontos, ou seja, ele deixa vazio.
$busca = isset($_GET['busca']) ? trim ($_GET['busca']):"";

// SISTEMA DE BUSCA
$consultaVaga = "select id, titulo, salario, localizacao
                from tbl_vagas 
                where status = 'ativa' and titulo like :buscaVaga
                or descricao like :buscaVaga";
                // Operador like está pegando o que vimos como numero e mexe apenas com caracteres

// o comando prepare "prepara" o comando para ser executado, porém ainda não foi executado porque ainda falta uma variável para ser atribuida, no caso o buscavaga.
$preparaVaga = $cn->prepare($consultaVaga);
// atribui a string da busca a variável que ela não sabia antes para a variável buscaVaga, permitindo ela ser executada.
$preparaVaga->bindValue(':buscaVaga',"%$busca%");
$preparaVaga->execute();
// a função fetchAll transforma as informações da tabela de banco de dados em um vetor.
$vagas = $preparaVaga->fetchAll();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agência de Empregos - Conectando Talentos</title>
    <link rel="stylesheet" href="./css/estilos.css">
</head>
<body>

    <!-- 1. TOPNAV (Navegação Semântica) -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo">AgênciaJobs</a>
                <ul class="nav-menu">
                    <li><a href="#" class="nav-link">Início</a></li>
                    <li><a href="#vagas" class="nav-link">Vagas</a></li>
                    <!-- Futuramente o PHP do aluno vai controlar se exibe Login ou Painel aqui -->
                    <li><a href="login.php" class="btn-login">Entrar / Cadastrar</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- 2. SEÇÃO HERO -->
    <section class="hero">
        <div class="container">
            <h1 class="hero-title">Sua próxima oportunidade profissional está aqui</h1>
            <p class="hero-subtitle">Encontre as melhores vagas de tecnologia e desenvolvimento de sistemas em um só lugar.</p>
            <div class="hero-buttons">
                <a href="#vagas" class="btn-hero btn-hero-primary">Quero uma Vaga</a>
                <a href="#" class="btn-hero btn-hero-secondary">Anunciar Vaga</a>
            </div>
        </div>
    </section>

    <!-- 3. BARRA DE FILTROS -->
    <section class="search-section">
        <div class="container">
            <!-- Os alunos usarão o method="GET" aqui para realizar a busca via PHP -->
            <form class="search-form" action="index.php" method="GET">
                <input type="text" name="busca" class="search-input" placeholder="Digite o cargo ex: Desenvolvedor PHP, Estágio...">
                <button type="submit" class="btn-search">Buscar Vagas</button>
            </form>
        </div>
    </section>

    <!-- 4. CONTEÚDO PRINCIPAL (FEED DE VAGAS) -->
    <main class="container jobs-section" id="vagas">
        <h2 class="section-title">Vagas Disponíveis</h2>
        
        <div class="jobs-grid">
            
            <!-- [AQUI ENTRARÁ O LOOP DO PHP DOS ALUNOS (while/foreach)] -->
            <?php 
            // se 
            if(count($vagas) > 0):
                // $vagas -> variável vetor criada lá em cima; $vaga -> linha individual do array. Ele diz que a cada (novo registro) linha deste array, transforme em outra linha.
                foreach($vagas as $vaga):

            ?>
            <!-- CARD EXEMPLO 1 (MOCK) -->
            <article class="job-card">
                <div>
                    
                    <!-- htmlspecialchars(): converte tudo que a pessoa digita em caracteres - evita falhas de segurança -->
                    <h3 class="job-title"><?= htmlspecialchars($vaga['titulo']) ?></h3>
                    <div class="job-details">
                        <p><strong>Localização:</strong> <?= htmlspecialchars($vaga['localizacao']) ?></p>
                        <p><strong>Salário:</strong> <?= htmlspecialchars($vaga['salario']) ?></p>
                    </div>
                </div>
            
                <a href="vagas.php?id=<?= $vaga['id']; ?>" class="btn-apply">Ver Detalhes</a>
            </article>
        

            <!-- [FIM DO LOOP DO PHP] -->
        <?php 
            endforeach;
            endif; 
        ?>

        </div>
    </main>

    <!-- 5. RODAPÉ -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 AgênciaJobs. Desenvolvido para fins didáticos nas aulas de Desenvolvimento de Sistemas.</p>
        </div>
    </footer>

</body>
</html>