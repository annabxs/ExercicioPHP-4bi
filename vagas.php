<?php
include "conexao.php";
// método isset serve para determinar se a variável é null ou notnull. Na linha abaixo, caso o valor for null
// O ? é um operador ternário que separa a condição (o que vem antes dele), do resultado CASO SEJA VERDADEIRA
// O : separador do operador ternário. Significa um else, ou seja, se o id não for enviado na url, ou o isset
// der falso, a variável $codvada receberá o número 0.
$codvaga = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$vagaSQL = "select * from tbl_vagas
            where status = 'ativa'
            and id = :id";
// $cn -> string de conexão
$prepararConsulta = $cn->prepare($vagaSQL);
// utilizamos o método bindvalue() para associar um valor fixo/variável a um marcador (como :exemplo ou ?) em
// uma consulta SQL já preparada, como o $codvaga lá em cima. -> $vagaSQL
// ele evita SQL injection e permite o SQL a compilar o comando uma única vez.
// Já o PDO:PARAM_INT é uma constante do PHP que é utilizada para indicar que um valor enviado a uma consulta
// de banco de dados é um número inteiro, como o id, informação apresentada abaixo.
$prepararConsulta->bindValue(':id', $codvaga, PDO::PARAM_INT);
$prepararConsulta->execute();
// a função fetchAll transforma as informações da tabela de banco de dados em um vetor.
$filtrarVaga = $prepararConsulta->fetch();
if(!$filtrarVaga){
    header("location:index.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Vaga - AgênciaJobs</title>
    <link rel="stylesheet" href="./css/estilosvagas.css">
</head>
<body>

    <!-- TOPNAV -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="index.php" class="logo">AgênciaJobs</a>
                <ul class="nav-menu">
                    <li><a href="index.php" class="nav-link">Início</a></li>
                    <li><a href="index.php#vagas" class="nav-link">Vagas</a></li>
                    <li><a href="login.php" class="btn-login">Entrar / Cadastrar</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL DA VAGA -->
    <main class="container details-container">
        
        <!-- Botão para retornar à listagem -->
        <a href="index.php" class="btn-back">&larr; Voltar para as vagas</a>


        <article class="job-detail-card">
            
            <!-- Cabeçalho do Card -->
            <header class="job-detail-header">
                <span class="badge"><?= htmlspecialchars($filtrarVaga['status']); ?></span>
                <h1 class="job-detail-title"><?= htmlspecialchars($filtrarVaga['titulo']) ?></h1>
                <p class="job-detail-company">Verificar na entrevista</p>
            </header>

            <!-- Painel de Metadados (Grade com Informações Rápidas) -->
            <div class="job-meta-grid">
                <div class="job-meta-item">
                    <span class="meta-label">Localização</span>
                    <span class="meta-value"><?= htmlspecialchars($filtrarVaga['localizacao']) ?></span>
                </div>
                <div class="job-meta-item">
                    <span class="meta-label">Salário</span>
                    <span class="meta-value">R$ <?= number_format($filtrarVaga['salario'],2,",",".") ?></span>
                </div>
                <div class="job-meta-item">
                    <span class="meta-label">Publicado em</span>
                    <!-- A função date basicamente apenas formata a data e hora apresentada e a função strtotime converte uma string de texto para uma data ou hora  -->
                    <span class="meta-value"><?= date('d/m/Y', strtotime($filtrarVaga['data_criacao'])) ?></span>
                </div>
            </div>

            <hr class="divider">

            <!-- Descrição Completa -->
            <section class="job-section">
                <h2>Descrição da Vaga</h2>
                <p><?= htmlspecialchars($filtrarVaga['descricao']) ?></p>
            </section>

            <!-- Requisitos do Cargo -->
            <section class="job-section">
                <h2>Requisitos Necessários</h2>
                <p><?= htmlspecialchars($filtrarVaga['requisitos']) ?></p>
            </section>

            <!-- Caixa de Ação -->
            <div class="job-action-box">
                <!-- O ID da vaga é repassado via GET para o fluxo de candidatura/login -->
                <a href="candidatar.php?id=1" class="btn-apply-large">Candidatar-se a esta Vaga</a>
            </div>

        </article>
    </main>

    <!-- RODAPÉ -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 AgênciaJobs. Desenvolvido para fins didáticos nas aulas de Desenvolvimento de Sistemas.</p>
        </div>
    </footer>

</body>
</html>