<?php

require_once __DIR__ . "/Connection.php";

require_once __DIR__ . "/../src/services/MotoristaService.php";

require_once __DIR__ . "/../src/services/VeiculoService.php";


$connection = new Connection(
    "localhost",
    "logistica",
    "root",
    ""
);

$pdo = $connection->obterConexao();

$motoristaService = new MotoristaService($pdo);
$veiculoService = new VeiculoService($pdo);

$mensagem = "";


try {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $acao = $_POST["acao"];


        /*
        |--------------------------------------------------------------------------
        | MOTORISTA
        |--------------------------------------------------------------------------
        */

        if ($acao === "cadastrar_motorista") {

            $motoristaService->cadastrarMotorista(
                $_POST["nome"],
                $_POST["cpf"]
            );

            $mensagem = "Motorista cadastrado com sucesso!";
        }


        elseif ($acao === "atualizar_motorista") {

            $motoristaService->atualizarNome(
                (int) $_POST["id"],
                $_POST["nome"]
            );

            $mensagem = "Motorista atualizado com sucesso!";
        }


        elseif ($acao === "inativar_motorista") {

            $motoristaService->inativarMotorista(
                (int) $_POST["id"]
            );

            $mensagem = "Motorista inativado com sucesso!";
        }


        /*
        |--------------------------------------------------------------------------
        | VEÍCULO
        |--------------------------------------------------------------------------
        */

        elseif ($acao === "cadastrar_veiculo") {

            $veiculoService->cadastrarVeiculo(
                $_POST["placa"],
                $_POST["modelo"],
                $_POST["marca"],
                (int) $_POST["ano"]
            );

            $mensagem = "Veículo cadastrado com sucesso!";
        }


        elseif ($acao === "atualizar_placa") {

            $veiculoService->atualizarPlaca(
                (int) $_POST["id"],
                $_POST["placa"]
            );

            $mensagem = "Placa atualizada com sucesso!";
        }


        elseif ($acao === "atualizar_modelo") {

            $veiculoService->atualizarModelo(
                (int) $_POST["id"],
                $_POST["modelo"]
            );

            $mensagem = "Modelo atualizado com sucesso!";
        }


        elseif ($acao === "atualizar_marca") {

            $veiculoService->atualizarMarca(
                (int) $_POST["id"],
                $_POST["marca"]
            );

            $mensagem = "Marca atualizada com sucesso!";
        }


        elseif ($acao === "atualizar_ano") {

            $veiculoService->atualizarAno(
                (int) $_POST["id"],
                (int) $_POST["ano"]
            );

            $mensagem = "Ano atualizado com sucesso!";
        }


        elseif ($acao === "associar_motorista") {

            $veiculoService->associarMotorista(
                (int) $_POST["veiculo_id"],
                (int) $_POST["motorista_id"]
            );

            $mensagem = "Motorista associado com sucesso!";
        }


        elseif ($acao === "desassociar_motorista") {

            $veiculoService->desassociarMotorista(
                (int) $_POST["veiculo_id"],
                (int) $_POST["motorista_id"]
            );

            $mensagem = "Motorista desassociado com sucesso!";
        }


        elseif ($acao === "inativar_veiculo") {

            $veiculoService->inativarVeiculo(
                (int) $_POST["id"]
            );

            $mensagem = "Veículo inativado com sucesso!";
        }
    }

} catch (Exception $e) {

    $mensagem = $e->getMessage();
}


$motoristas = $motoristaService->listarMotoristas();

$veiculos = $veiculoService->listarVeiculos();

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Gestão de Frota</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>


<body>


<header>

    <div class="header-container">

        <div>

            <h1>Gestão de Frota</h1>

            <p>Sistema de cadastro de veículos e motoristas</p>

        </div>


        <nav>

            <a href="#cadastro">Cadastro</a>
            <a href="#motoristas">Motoristas</a>
            <a href="#veiculos">Veículos</a>
            <a href="#associacao">Associação</a>
            <a href="historico.php">Historico</a>

        </nav>

    </div>

</header>



<main>


    <?php if ($mensagem): ?>

        <div class="mensagem">

            <?= htmlspecialchars($mensagem) ?>

        </div>

    <?php endif; ?>



    <!-- ========================================================= -->
    <!-- CADASTROS -->
    <!-- ========================================================= -->

    <section id="cadastro">

        <h2>Cadastros</h2>


        <div class="cards">


            <!-- CADASTRAR MOTORISTA -->

            <div class="card">

                <h3>Cadastrar Motorista</h3>

                <form method="POST">

                    <input
                        type="hidden"
                        name="acao"
                        value="cadastrar_motorista"
                    >

                    <label>Nome</label>

                    <input
                        type="text"
                        name="nome"
                        placeholder="Nome completo"
                        required
                    >


                    <label>CPF</label>

                    <input
                        type="text"
                        name="cpf"
                        placeholder="000.000.000-00"
                        required
                    >


                    <button type="submit">
                        Cadastrar motorista
                    </button>

                </form>

            </div>



            <!-- CADASTRAR VEÍCULO -->

            <div class="card">

                <h3>Cadastrar Veículo</h3>

                <form method="POST">

                    <input
                        type="hidden"
                        name="acao"
                        value="cadastrar_veiculo"
                    >


                    <label>Placa</label>

                    <input
                        type="text"
                        name="placa"
                        placeholder="ABC-1234"
                        maxlength="10"
                        required
                    >


                    <label>Modelo</label>

                    <input
                        type="text"
                        name="modelo"
                        placeholder="Modelo do veículo"
                        required
                    >


                    <label>Marca</label>

                    <input
                        type="text"
                        name="marca"
                        placeholder="Marca do veículo"
                        required
                    >


                    <label>Ano</label>

                    <input
                        type="number"
                        name="ano"
                        min="2010"
                        max="<?= date("Y") ?>"
                        placeholder="Ano"
                        required
                    >


                    <button type="submit">
                        Cadastrar veículo
                    </button>

                </form>

            </div>

        </div>

    </section>



    <!-- ========================================================= -->
    <!-- MOTORISTAS -->
    <!-- ========================================================= -->

    <section id="motoristas">

        <h2>Motoristas</h2>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Nome</th>

                        <th>CPF</th>

                        <th>Status</th>

                        <th>Ações</th>

                    </tr>

                </thead>


                <tbody>

                    <?php foreach ($motoristas as $motorista): ?>

                        <tr>

                            <td>
                                <?= $motorista->getId() ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $motorista->getNome()
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $motorista->getCpf()
                                ) ?>
                            </td>


                            <td>

                                <?php if ($motorista->getAtivo()): ?>

                                    <span class="status ativo">
                                        Ativo
                                    </span>

                                <?php else: ?>

                                    <span class="status inativo">
                                        Inativo
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <div class="acoes">


                                    <!-- EDITAR NOME -->

                                    <?php if ($motorista->getAtivo()): ?>

                                        <form method="POST">

                                            <input
                                                type="hidden"
                                                name="acao"
                                                value="atualizar_motorista"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $motorista->getId() ?>"
                                            >

                                            <input
                                                type="text"
                                                name="nome"
                                                value="<?= htmlspecialchars(
                                                    $motorista->getNome()
                                                ) ?>"
                                                required
                                            >

                                            <button type="submit">
                                                Editar
                                            </button>

                                        </form>


                                        <!-- INATIVAR -->

                                        <form method="POST">

                                            <input
                                                type="hidden"
                                                name="acao"
                                                value="inativar_motorista"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $motorista->getId() ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="btn-danger"
                                            >
                                                Inativar
                                            </button>

                                        </form>

                                    <?php endif; ?>


                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </section>



    <!-- ========================================================= -->
    <!-- VEÍCULOS -->
    <!-- ========================================================= -->

    <section id="veiculos">

        <h2>Veículos</h2>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Ano</th>
                        <th>Motorista</th>
                        <th>Status</th>
                        <th>Ações</th>

                    </tr>

                </thead>


                <tbody>

                    <?php foreach ($veiculos as $veiculo): ?>

                        <tr>

                            <td>
                                <?= $veiculo->getId() ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $veiculo->getPlaca()
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $veiculo->getModelo()
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $veiculo->getMarca()
                                ) ?>
                            </td>


                            <td>
                                <?= $veiculo->getAno() ?>
                            </td>

                            <td>

                                <?php
                                $motorista = $motoristaService->buscarMotoristaPorVeiculo(
                                        $veiculo->getId()
                                    );
                                ?>

                                <?php if ($motorista !== null): ?>

                                    <?= htmlspecialchars(
                                        $motorista->getNome()
                                    ) ?>

                                <?php else: ?>

                                    <span class="nao-associado">
                                        Não associado
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <?php if ($veiculo->getAtivo()): ?>

                                    <span class="status ativo">
                                        Ativo
                                    </span>

                                <?php else: ?>

                                    <span class="status inativo">
                                        Inativo
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <div class="acoes">


                                    <?php if ($veiculo->getAtivo()): ?>


                                        <!-- ALTERAR PLACA -->

                                        <form method="POST">

                                            <input
                                                type="hidden"
                                                name="acao"
                                                value="atualizar_placa"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $veiculo->getId() ?>"
                                            >

                                            <input
                                                type="text"
                                                name="placa"
                                                value="<?= htmlspecialchars(
                                                    $veiculo->getPlaca()
                                                ) ?>"
                                                required
                                            >

                                            <button type="submit">
                                                Alterar placa
                                            </button>

                                        </form>



                                        <!-- ALTERAR MODELO -->

                                        <form method="POST">

                                            <input
                                                type="hidden"
                                                name="acao"
                                                value="atualizar_modelo"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $veiculo->getId() ?>"
                                            >

                                            <input
                                                type="text"
                                                name="modelo"
                                                value="<?= htmlspecialchars(
                                                    $veiculo->getModelo()
                                                ) ?>"
                                                required
                                            >

                                            <button type="submit">
                                                Alterar modelo
                                            </button>

                                        </form>



                                        <!-- ALTERAR MARCA -->

                                        <form method="POST">

                                            <input
                                                type="hidden"
                                                name="acao"
                                                value="atualizar_marca"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $veiculo->getId() ?>"
                                            >

                                            <input
                                                type="text"
                                                name="marca"
                                                value="<?= htmlspecialchars(
                                                    $veiculo->getMarca()
                                                ) ?>"
                                                required
                                            >

                                            <button type="submit">
                                                Alterar marca
                                            </button>

                                        </form>



                                        <!-- ALTERAR ANO -->

                                        <form method="POST">

                                            <input
                                                type="hidden"
                                                name="acao"
                                                value="atualizar_ano"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $veiculo->getId() ?>"
                                            >

                                            <input
                                                type="number"
                                                name="ano"
                                                value="<?= $veiculo->getAno() ?>"
                                                min="2010"
                                                max="<?= date("Y") ?>"
                                                required
                                            >

                                            <button type="submit">
                                                Alterar ano
                                            </button>

                                        </form>



                                        <!-- INATIVAR -->

                                        <form method="POST">

                                            <input
                                                type="hidden"
                                                name="acao"
                                                value="inativar_veiculo"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= $veiculo->getId() ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="btn-danger"
                                            >
                                                Inativar
                                            </button>

                                        </form>

                                    <?php endif; ?>


                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </section>



    <!-- ========================================================= -->
    <!-- ASSOCIAÇÃO -->
    <!-- ========================================================= -->

    <section id="associacao">

        <h2>Associação de Motoristas</h2>


        <div class="cards">


            <!-- ASSOCIAR -->

            <div class="card">

                <h3>Associar motorista a veículo</h3>

                <form method="POST">

                    <input
                        type="hidden"
                        name="acao"
                        value="associar_motorista"
                    >


                    <label>Veículo</label>

                    <select
                        name="veiculo_id"
                        required
                    >

                        <option value="">
                            Selecione um veículo
                        </option>


                        <?php foreach ($veiculos as $veiculo): ?>

                            <?php if ($veiculo->getAtivo()): ?>

                                <option
                                    value="<?= $veiculo->getId() ?>"
                                >

                                    <?= htmlspecialchars(
                                        $veiculo->getPlaca()
                                    ) ?>

                                    -
                                    
                                    <?= htmlspecialchars(
                                        $veiculo->getModelo()
                                    ) ?>

                                </option>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </select>



                    <label>Motorista</label>

                    <select
                        name="motorista_id"
                        required
                    >

                        <option value="">
                            Selecione um motorista
                        </option>


                        <?php foreach ($motoristas as $motorista): ?>

                            <?php if ($motorista->getAtivo()): ?>

                                <option
                                    value="<?= $motorista->getId() ?>"
                                >

                                    <?= htmlspecialchars(
                                        $motorista->getNome()
                                    ) ?>

                                </option>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </select>


                    <button type="submit">
                        Associar motorista
                    </button>

                </form>

            </div>



            <!-- DESASSOCIAR -->

            <div class="card">

                <h3>Desassociar motorista</h3>

                <p class="descricao">
                    Informe o ID do veículo e do motorista
                    para encerrar a associação atual.
                </p>


                <form method="POST">

                    <input
                        type="hidden"
                        name="acao"
                        value="desassociar_motorista"
                    >


                    <label>ID do veículo</label>

                    <input
                        type="number"
                        name="veiculo_id"
                        min="1"
                        required
                    >


                    <label>ID do motorista</label>

                    <input
                        type="number"
                        name="motorista_id"
                        min="1"
                        required
                    >


                    <button
                        type="submit"
                        class="btn-danger"
                    >
                        Desassociar
                    </button>

                </form>

            </div>

        </div>

    </section>


</main>


<footer>

    <p>
        Sistema de Gestão de Frota — PHP + POO + PDO
    </p>

</footer>


</body>

</html>