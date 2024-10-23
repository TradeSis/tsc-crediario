<?php
//Lucas 09102024 criado
include_once(__DIR__ . '/../header.php');
include_once '../database/financeira/rfnparam.php';

$codigoCliente = null;
$codigoCliente = isset($_POST['codigoCliente']) ? $_POST['codigoCliente'] : $_GET['codigoCliente'];
$cpfCnpj = isset($_POST['cpfCnpj']) ? $_POST['cpfCnpj'] : null;

$elevigeisRefin = buscaElegiveisRefin($codigoCliente, $cpfCnpj);

$cliente = $elevigeisRefin["dadosSaida"]["cliente"][0];
$contratos = $elevigeisRefin["dadosSaida"]["contrato"];

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <style>
        input[readonly] {
            background-color: transparent !important;
        }
    </style>
    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body class="ts-noScroll">

    <div class="container-fluid mt-2">
        <div class="row">
             <!--<BR> MENSAGENS/ALERTAS -->
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10">
                        <h4>Elegíveis REFIN</h4>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="index.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col">
                        Cod. Cliente: <?php echo $cliente['clicod'] ?>
                    </div>
                    <div class="col">
                        CPF/CNPJ: <?php echo $cliente['ciccgc'] ?>
                    </div>
                    <div class="col">
                        Nome: <?php echo $cliente['clinom'] ?>
                    </div>
                    <div class="col">
                        Fil Cad.: <?php echo $cliente['etbcad'] ?>
                    </div>
                </div>

                <hr>
                <div class="container-fluid">
                    <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
                        <table class="table table-sm table-hover text-center">
                            <thead class="ts-headertabelafixo">
                                <tr class="ts-headerTabelaLinhaCima">
                                    <th>numeroContrato</th>
                                    <th>Dt Emissão</th>
                                    <th>Saldo Devedor Principal</th>
                                    <th>Soma Parcelas</th>
                                    <th>Valor Parcela Com Acrescimo</th>
                                    <th>Valor Parcela Principal</th>
                                    <th>qtd Parcelas</th>
                                    <th>qtd Parcelas Abertas</th>
                                    <th>Proximo Vencimento</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody class="fonteCorpo">
                                <?php if (!empty($contratos)) {
                                    foreach ($contratos as $contrato) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $contrato['numeroContrato'] ?>
                                            </td>
                                            <td>
                                                <?php echo date('d/m/Y', strtotime($contrato['dataEmissao'])) ?>
                                            </td>
                                            <td>
                                                <?php echo $contrato['saldoDevedorPrincipal'] ?>
                                            </td>
                                            <td>
                                                <?php echo $contrato['somaParcelas'] ?>
                                            </td>
                                            <td>
                                                <?php echo $contrato['valorParcelaComAcrescimo'] ?>
                                            </td>
                                            <td>
                                                <?php echo $contrato['valorParcelaPrincipal'] ?>
                                            </td>
                                            <td>
                                                <?php echo $contrato['qtdParcelas'] ?>
                                            </td>
                                            <td>
                                                <?php echo $contrato['qtdParcelasAbertas'] ?>
                                            </td>
                                            <td>
                                                <?php echo date('d/m/Y', strtotime($contrato['proximoVencimento'])) ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                    href="../clientes/contratos.php?origem=refin&&numeroContrato=<?php echo $contrato['numeroContrato'] ?>"
                                                    role="button"><i class="bi bi-eye-fill"></i></a>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>