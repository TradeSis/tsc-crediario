<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 27022023 13:51

include_once '../header.php';
include_once '../database/crediariocliente.php';

$codigoCliente = $_GET['codigoCliente'];

if (empty($cpfCNPJ)) {
    $cpfCNPJ = null;
} // Se estiver vazio, coloca null

$situacao = 'PAG';

$historico = buscaHistoricoCliente($codigoCliente, $cpfCNPJ, $situacao);


$cliente = $historico["cliente"][0];
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
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-8 text-center">
                        <h4>Historico do Cliente <?php echo $cliente['nomeCliente'] ?></h4>
                    </div>
                    <div class="col-sm-2" style="text-align:right">
                        <a href="cliente_parametros.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>


            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Conta&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['codigoCliente'] ?> - <?php echo $cliente['nomeCliente'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <div class="form-group">
                            <label>CPF/CNPJ&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['cpfCNPJ'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <div class="form-group">
                            <label>Dt&nbsp;Cadastro&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo date('d/m/Y', strtotime($cliente['dataCadastro'])) ?>" readonly>
                    </div>
                </div>
                <hr>
                <div class="row mt-1">
                    <div id="ts-tabs">
                        <a class="tab" href="historico_cliente.php?codigoCliente=<?php echo $cliente['codigoCliente'] ?>">Abertos</a>
                        <a class="tab whiteborder" style="color:blue" href="#">Pagos</a>
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
                                        href="contratos.php?numeroContrato=<?php echo $contrato['numeroContrato'] ?>"
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