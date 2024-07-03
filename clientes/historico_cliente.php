<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 27022023 13:51 - ajustado direcionamento para consulta de contrato
// gabriel 23022023 09:50

include_once '../header.php';
include_once '../database/crediariocliente.php';

if (isset($_GET['parametros'])) {
    $codigoCliente = $_POST['codigoCliente'];
    $cpfCNPJ = $_POST['cpfCNPJ'];
}
if (isset($_GET['codigoCliente'])) {
    $codigoCliente = $_GET['codigoCliente'];
}

if (empty($cpfCNPJ)) {
    $cpfCNPJ = null;
}
$situacao = 'LIB';

$historico = buscaHistoricoCliente($codigoCliente, $cpfCNPJ, $situacao);
//echo json_encode($historico);
$cliente = $historico["cliente"][0];
$codigoCliente = $cliente["codigoCliente"];
if (isset($historico["contratos"])) {
    $contratos = $historico["contratos"];
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body class="ts-noScroll">

    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10">
                        <h4>Cod. <?php echo $cliente['codigoCliente'] ?> - <?php echo $cliente['nomeCliente'] ?></h4>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="historico_parametros.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>


            <div class="container-fluid">
                <h5>Dados Cliente</h5>
                <div class="row">
                    <div class="col">
                        <label>Código Cliente</label>
                        <input type="text" class="form-control"
                            value=" <?php echo $cliente['codigoCliente'] ?> - <?php echo $cliente['nomeCliente'] ?>"
                            readonly>

                    </div>
                    <div class="col">
                        <label>CPF/CNPJ</label>
                        <input type="text" class="form-control" value="<?php echo $cliente['cpfCNPJ'] ?>" readonly>
                    </div>
                </div>
                <hr>
                <div class="row mt-1">
                    <div id="ts-tabs">
                        <a class="tab whiteborder" href="#">Abertos</a>
                        <a class="tab" href="historico_clientepag.php?codigoCliente=<?php echo $codigoCliente ?>">Pagos</a>
                        <div class="line"></div>
                    </div>
                </div>
                <h5>Contratos</h5>
                <div class="table table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Contrato</th>
                                <th class="text-center">Dt Emissão</th>
                                <th class="text-center">Dt Venc</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Entrada</th>
                                <th class="text-center">Aberto</th>
                                <th class="text-center">Sit</th>
                                <th class="text-center">Parcelas</th>
                            </tr>
                        </thead>
                        <?php if (!empty($contratos)) { 
                        foreach ($contratos as $contrato) { ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $contrato['codigoCliente'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $contrato['numeroContrato'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo date('d/m/Y', strtotime($contrato['dtemissao'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if ($contrato['dtProxVencimento'] !== null) {
                                        echo date('d/m/Y', strtotime($contrato['dtProxVencimento']));
                                    } ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $contrato['valorTotal'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $contrato['valorEntrada'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $contrato['valorAberto'] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $contrato['situacao'] ?>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm"
                                        href="contratos.php?origem=cliente&&numeroContrato=<?php echo $contrato['numeroContrato'] ?>"
                                        role="button"><i class="bi bi-eye-fill"></i></a>
                                </td>
                            </tr>
                        <?php } } ?>

                    </table>
                </div>
            </div>
        </div>
    </div>


<!-- LOCAL PARA COLOCAR OS JS -->

<?php include_once ROOT . "/vendor/footer_js.php"; ?>

<!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>