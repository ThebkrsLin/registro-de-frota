<?php

require_once __DIR__ . "/Connection.php";
require_once __DIR__ . "/../src/services/VeiculoService.php";

try {

    // Cria a conexão com o banco
    $conexao = new Connection("localhost", "logistica", "root", "");
    $pdo = $conexao->obterConexao();

    // Cria o Service
    $veiculoService = new VeiculoService($pdo);

    // Busca o histórico
    $historicos = $veiculoService->listarHistorico();

} catch (Exception $e) {

    $erro = $e->getMessage();
    $historicos = [];

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Histórico de Veículos</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .descricao {
            color: #666;
            margin-bottom: 25px;
        }

        .voltar {
            display: inline-block;
            margin-bottom: 25px;
            padding: 10px 16px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .voltar:hover {
            background-color: #555;
        }

        .tabela-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        tr:hover {
            background-color: #fafafa;
        }

        .ativo {
            color: green;
            font-weight: bold;
        }

        .encerrado {
            color: #777;
        }

        .sem-registros {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        .erro {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #ffe5e5;
            color: #b00000;
            border-radius: 5px;
        }

    </style>

</head>

<body>

    <div class="container">

        <h1>Histórico de Veículos e Motoristas</h1>

        <p class="descricao">
            Consulte as associações atuais e anteriores entre veículos e motoristas.
        </p>

        <a href="index.php" class="voltar">
            Voltar para veículos
        </a>

        <?php if (isset($erro)): ?>

            <div class="erro">
                <?= htmlspecialchars($erro) ?>
            </div>

        <?php endif; ?>

        <div class="tabela-container">

            <table>

                <thead>

                    <tr>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Motorista</th>
                        <th>CPF</th>
                        <th>Data de início</th>
                        <th>Data de fim</th>
                        <th>Situação</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (empty($historicos)): ?>

                        <tr>

                            <td colspan="8" class="sem-registros">
                                Nenhum histórico de associação encontrado.
                            </td>

                        </tr>

                    <?php else: ?>

                        <?php foreach ($historicos as $historico): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($historico["placa"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($historico["marca"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($historico["modelo"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($historico["motorista"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($historico["cpf"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($historico["data_inicio"]) ?>
                                </td>

                                <td>

                                    <?php if ($historico["data_fim"] !== null): ?>

                                        <?= htmlspecialchars($historico["data_fim"]) ?>

                                    <?php else: ?>

                                        —

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <?php if ($historico["data_fim"] === null): ?>

                                        <span class="ativo">
                                            Associação atual
                                        </span>

                                    <?php else: ?>

                                        <span class="encerrado">
                                            Encerrada
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>