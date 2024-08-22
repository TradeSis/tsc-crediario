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

$cliente = buscaPosicaoCliente($codigoCliente, $cpfCNPJ);
$codigoCliente = $cliente["codigoCliente"];


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <style>
        .modal-fullscreen {
            max-width: 100vw !important;
        }
    </style>
    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body class="ts-noScroll">

    <div class="container-fluid">
        <!-- Modal -->
        <div class="modal" id="modalClienteVisualizar" tabindex="-1" aria-hidden="true" style="margin: 5px;">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"> <!-- Modal 1 -->
                <div class="modal-content" style="background-color: #F1F2F4;">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-5">
                            </div>
                            <div class="col-6">
                                <span class="ts-tituloPrincipalModal">Conta do Cliente</span>
                            </div>
                            <div class="col-1 border-start d-flex">
                                <a href="cliente_menu.php" role="button" class="btn-close"></a>
                            </div>
                        </div>
                    </div>


                    <div class="container-fluid" style="background-color: #F1F2F4;">
                        <!-- ROW1 CONTA CLIENTE -->
                        <div class="row mt-2">
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Conta&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['codigoCliente'] ?> - <?php echo $cliente['nomeCliente'] ?>"
                                    readonly>
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">CPF/CNPJ&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['cpfCNPJ'] ?>" readonly>
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Dt&nbsp;Cadastro&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo date('d/m/Y', strtotime($cliente['dataCadastro'])) ?>" readonly>
                            </div>
                        </div>
                        <!-- ROW1 fim -->
                        <div class="text-center mt-2 mb-2" style="background-color: lightblue;">
                            <h2>CRÉDITO&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;VENCIMENTO
                                LIMITE&nbsp;:&nbsp;<?php echo date('d/m/Y', strtotime($cliente['vvctoLimite'])) ?>
                            </h2>
                        </div>
                        <!-- ROW2 CREDITO -->
                        <div class="row mt-2">
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">CR&nbsp;Crédito&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vvlrLimite'], 2, ',', '') ?>" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Aberto&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vcomprometido'], 2, ',', '') ?>" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Principal&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vcomprometido-principal'], 2, ',', '') ?>"
                                    readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Disponível&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vsaldoLimite'], 2, ',', '') ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">EP&nbsp;Crédito&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vvlrLimiteEP'], 2, ',', '') ?>" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Aberto&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vcomprometidoEP'], 2, ',', '') ?>"
                                    readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Principal&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vcomprometido-principalEP'], 2, ',', '') ?>"
                                    readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Disponível&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vsaldoLimiteEP'], 2, ',', '') ?>"
                                    readonly>
                            </div>
                        </div>
                        <!-- ROW2 fim -->
                        <div class="text-center mt-2 mb-2" style="background-color: lightblue;">
                            <h2>COMPRAS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRESTAÇÕES
                            </h2>
                        </div>
                        <!-- ROW3 COMPRAS -->
                        <div class="row mt-2">
                            <div class="col-4 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Ultima&nbsp;Compra&nbsp;&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo date('d/m/Y', strtotime($cliente['vDTULTCPA'])) ?>" readonly>
                            </div>
                            <div class="col-4 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Contratos&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['vQTDECONT'] ?>" readonly>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Pagas&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['vPARCPAG'] ?>" readonly>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Abertas&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['vPARCABERT'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Ultima&nbsp;Novção&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo date('d/m/Y', strtotime($cliente['vDTULTNOV'])) ?>" readonly>
                            </div>
                        </div>
                        <!-- ROW3 fim -->
                        <div class="text-center mt-2 mb-2" style="background-color: lightblue;">
                            <h2>ATRASO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PARCELAS
                            </h2>
                        </div>
                        <!-- ROW4 ATRASO PARCELAS -->
                        <div class="row mt-2">
                            <div class="col-4 d-flex align-items-center">
                                <div class="form-group">
                                    <label
                                        class="form-label ts-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(até&nbsp;15&nbsp;dias)&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['qtd-15'] ?>" readonly>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['perc-15'] ?>%" readonly>
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Media&nbsp;Por&nbsp;Contrato&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vMEDIACONT'], 2, ',', '') ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4 d-flex align-items-center">
                                <div class="form-group">
                                    <label
                                        class="form-label ts-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(16&nbsp;até&nbsp;45&nbsp;dias)&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['qtd-45'] ?>" readonly>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['perc-45'] ?>%" readonly>
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Maior&nbsp;Acum.&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vMAIORACUM'], 2, ',', '') ?>" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Mês/Ano&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['vDTMAIORACUM'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4 d-flex align-items-center">
                                <div class="form-group">
                                    <label
                                        class="form-label ts-label">(acima&nbsp;de&nbsp;45&nbsp;dias)&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['qtd-46'] ?>" readonly>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['perc-46'] ?>%" readonly>
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Prest.&nbsp;Media&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vPARCMEDIA'], 2, ',', '') ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4 d-flex align-items-center">
                                <div class="form-group">
                                    <label
                                        class="form-label ts-label">&nbsp;&nbsp;&nbsp;&nbsp;Reparcelamento&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $cliente['vrepar'] ?>" readonly>
                            </div>
                            <div class="col-2">
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="form-label ts-label">Próximo&nbsp;Mês&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo number_format($cliente['vproximo-mes'], 2, ',', '') ?>" readonly>
                            </div>
                        </div>
                        <!-- ROW4 fim -->
                        <div class="text-center mt-2 mb-2" style="background-color: red;">
                            <h4>ATRASO->&nbsp;Atual:&nbsp;<?php echo $cliente['vATRASOATUAL'] ?>&nbsp;(<?php echo date('d/m/Y', strtotime($cliente['vDTMAIORATRASO'])) ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Vencidas:&nbsp;<?php echo number_format($cliente['vVLRPARCVENC'], 2, ',', '') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chq&nbsp;Devol:&nbsp;<?php echo number_format($cliente['vcheque_devolvido'], 2, ',', '') ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="historico_cliente.php?codigoCliente=<?php echo $cliente['codigoCliente'] ?>"
                            class="btn btn-info mx-2">Histórico</a>
                    </div>
                </div>
            </div><!-- Modal 1 -->


        </div>
    </div>


    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <script>
        var myModal = new bootstrap.Modal(document.getElementById("modalClienteVisualizar"), {});
        document.onreadystatechange = function () {
            myModal.show();
        };
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>