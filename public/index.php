```php
<?php

require_once __DIR__ . "/Connection.php";
require_once __DIR__ . "/../src/services/MotoristaService.php";
require_once __DIR__ . "/../src/services/VeiculoService.php";

$connection = new Connection(
    "localhost",
    "registro_de_frota",
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

        // MOTORISTA

        if ($acao === "cadastrar_motorista") {

            $motoristaService->cadastrarMotorista(
                $_POST["nome"],
                $_POST["cpf"]
            );

            $mensagem = "Motorista cadastrado!";
        }

        elseif ($acao === "atualizar_motorista") {

            $motoristaService->atualizarNome(
                (int) $_POST["id"],
                $_POST["nome"]
            );

            $mensagem = "Motorista atualizado!";
        }

        elseif ($acao === "inativar_motorista") {

            $motoristaService->inativarMotorista(
                (int) $_POST["id"]
            );

            $mensagem = "Motorista inativado!";
        }


        // VEÍCULO

        elseif ($acao === "cadastrar_veiculo") {

            $motoristaId = !empty($_POST["motorista_id"])
                ? (int) $_POST["motorista_id"]
                : null;

            $veiculoService->cadastrarVeiculo(
                $_POST["placa"],
                $_POST["modelo"],
                $_POST["marca"],
                (int) $_POST["ano"],
                $motoristaId
            );

            $mensagem = "Veículo cadastrado!";
        }

        elseif ($acao === "atualizar_placa") {

            $veiculoService->atualizarPlaca(
                (int) $_POST["id"],
                $_POST["placa"]
            );

            $mensagem = "Placa atualizada!";
        }

        elseif ($acao === "atualizar_modelo") {

            $veiculoService->atualizarModelo(
                (int) $_POST["id"],
                $_POST["modelo"]
            );

            $mensagem = "Modelo atualizado!";
        }

        elseif ($acao === "atualizar_marca") {

            $veiculoService->atualizarMarca(
                (int) $_POST["id"],
                $_POST["marca"]
            );

            $mensagem = "Marca atualizada!";
        }

        elseif ($acao === "atualizar_ano") {

            $veiculoService->atualizarAno(
                (int) $_POST["id"],
                (int) $_POST["ano"]
            );

            $mensagem = "Ano atualizado!";
        }

        elseif ($acao === "associar_motorista") {

            $veiculoService->associarMotorista(
                (int) $_POST["veiculo_id"],
                (int) $_POST["motorista_id"]
            );

            $mensagem = "Motorista associado!";
        }

        elseif ($acao === "inativar_veiculo") {

            $veiculoService->inativarVeiculo(
                (int) $_POST["id"]
            );

            $mensagem = "Veículo inativado!";
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

    <h1>Gestão de Frota</h1>

    <nav>
        <a href="#motoristas">Motoristas</a>
        <a href="#veiculos">Veículos</a>
        <a href="#cadastro">Cadastro</a>
    </nav>

</header>


<main>

    <?php if ($mensagem): ?>

        <div class="mensagem">
            <?= htmlspecialchars($mensagem) ?>
        </div>

    <?php endif; ?>


    <!-- CADASTROS -->

    <section id="cadastro">

        <h2>Cadastrar Motorista</h2>

        <form method="POST">

            <input
                type="hidden"
                name="acao"
                value="cadastrar_motorista"
            >

            <input
                type="text"
                name="nome"
                placeholder="Nome"
                required
            >

            <input
                type="text"
                name="cpf"
                placeholder="CPF"
                required
            >

            <button>Cadastrar</button>

        </form>


        <h2>Cadastrar Veículo</h2>

        <form method="POST">

            <input
                type="hidden"
                name="acao"
                value="cadastrar_veiculo"
            >

            <input
                type="text"
                name="placa"
                placeholder="Placa"
                required
            >

            <input
                type="text"
                name="modelo"
                placeholder="Modelo"
                required
            >

            <input
                type="text"
                name="marca"
                placeholder="Marca"
                required
            >

            <input
                type="number"
                name="ano"
                placeholder="Ano"
                min="2010"
                max="<?= date("Y") ?>"
                required
            >

            <select name="motorista_id">

                <option value="">
                    Sem motorista
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

            <button>Cadastrar</button>

        </form>

    </section>


    <!-- MOTORISTAS -->

    <section id="motoristas">

        <h2>Motoristas</h2>

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Status</th>
                    <th>Ação</th>
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

                            <?= $motorista->getAtivo()
                                ? "Ativo"
                                : "Inativo" ?>

                        </td>

                        <td>

                            <?php if ($motorista->getAtivo()): ?>

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

                                    <button>
                                        Inativar
                                    </button>

                                </form>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </section>


    <!-- VEÍCULOS -->

    <section id="veiculos">

        <h2>Veículos</h2>

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
                    <th>Ação</th>
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

                            $motoristaNome = "Não associado";

                            if ($veiculo->getMotoristaId() !== null) {

                                foreach ($motoristas as $motorista) {

                                    if (
                                        $motorista->getId()
                                        ===
                                        $veiculo->getMotoristaId()
                                    ) {

                                        $motoristaNome =
                                            $motorista->getNome();

                                        break;
                                    }
                                }
                            }

                            ?>

                            <?= htmlspecialchars($motoristaNome) ?>

                        </td>

                        <td>

                            <?= $veiculo->getAtivo()
                                ? "Ativo"
                                : "Inativo" ?>

                        </td>

                        <td>

                            <?php if ($veiculo->getAtivo()): ?>

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

                                    <button>
                                        Inativar
                                    </button>

                                </form>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </section>

</main>

</body>

</html>
```
