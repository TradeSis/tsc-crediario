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
                        <h4>Conta do Cliente</h4>
                    </div>
                    <div class="col-sm-2" style="text-align:right">
                        <a href="cliente_parametros.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>


            <div class="container-fluid">
                <!-- ROW1 CONTA CLIENTE -->
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
                <!-- ROW1 fim -->
                <div class="text-center mt-2 mb-2" style="background-color: lightblue;">
                    <h2>CRÉDITO&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;VENCIMENTO LIMITE&nbsp;:&nbsp;<?php echo date('d/m/Y', strtotime($cliente['vvctoLimite'])) ?></h2>
                </div>
                 <!-- ROW2 CREDITO -->
                <div class="row mt-2">
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>CR&nbsp;Crédito&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vvlrLimite'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Aberto&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vcomprometido'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Principal&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vcomprometido-principal'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Disponível&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vsaldoLimite'] ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>EP&nbsp;Crédito&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vvlrLimiteEP'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Aberto&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vcomprometidoEP'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Principal&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vcomprometido-principalEP'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Disponível&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vsaldoLimiteEP'] ?>" readonly>
                    </div>
                </div>
                <!-- ROW2 fim -->
                <div class="text-center mt-2 mb-2" style="background-color: lightblue;">
                    <h2>COMPRAS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRESTAÇÕES</h2>
                </div>
                 <!-- ROW3 COMPRAS -->
                <div class="row mt-2">
                    <div class="col-4 d-flex align-items-center">
                        <div class="form-group">
                            <label>Ultima&nbsp;Compra&nbsp;&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vDTULTCPA'] ?>" readonly>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <div class="form-group">
                            <label>Contratos&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vQTDECONT'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <div class="form-group">
                            <label>Pagas&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vPARCPAG'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <div class="form-group">
                            <label>Abertas&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vPARCABERT'] ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4 d-flex align-items-center">
                        <div class="form-group">
                            <label>Ultima&nbsp;Novção&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vDTULTNOV'] ?>" readonly>
                    </div>
                </div>
                <!-- ROW3 fim -->
                <div class="text-center mt-2 mb-2" style="background-color: lightblue;">
                    <h2>ATRASO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PARCELAS</h2>
                </div>
                 <!-- ROW4 ATRASO PARCELAS -->
                <div class="row mt-2">
                    <div class="col-4 d-flex align-items-center">
                        <div class="form-group">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(até&nbsp;15&nbsp;dias)&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['qtd-15'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['perc-15'] ?>%" readonly>
                    </div>
                    <div class="col-3 d-flex align-items-center">
                        <div class="form-group">
                            <label>Media&nbsp;Por&nbsp;Contrato&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vMEDIACONT'] ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4 d-flex align-items-center">
                        <div class="form-group">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(16&nbsp;até&nbsp;45&nbsp;dias)&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['qtd-45'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['perc-45'] ?>%" readonly>
                    </div>
                    <div class="col-3 d-flex align-items-center">
                        <div class="form-group">
                            <label>Maior&nbsp;Acum.&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vMAIORACUM'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Mês/Ano&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vDTMAIORACUM'] ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4 d-flex align-items-center">
                        <div class="form-group">
                            <label>(acima&nbsp;de&nbsp;45&nbsp;dias)&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['qtd-46'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['perc-46'] ?>%" readonly>
                    </div>
                    <div class="col-3 d-flex align-items-center">
                        <div class="form-group">
                            <label>Prest.&nbsp;Media&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vPARCMEDIA'] ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4 d-flex align-items-center">
                        <div class="form-group">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;Reparcelamento&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vrepar'] ?>" readonly>
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-3 d-flex align-items-center">
                        <div class="form-group">
                            <label>Próximo&nbsp;Mês&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $cliente['vproximo-mes'] ?>" readonly>
                    </div>
                </div>
                <!-- ROW4 fim -->
                <div class="text-center mt-2 mb-2" style="background-color: red;">
                    <h4>ATRASO->&nbsp;Atual:&nbsp;<?php echo $cliente['vATRASOATUAL'] ?>&nbsp;(<?php echo date('d/m/Y', strtotime($cliente['vDTMAIORATRASO'])) ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Vencidas:&nbsp;<?php echo $cliente['vVLRPARCVENC'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chq&nbsp;Devol:&nbsp;<?php echo $cliente['vcheque_devolvido'] ?></h4>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="historico_cliente.php?codigoCliente=<?php echo $cliente['codigoCliente'] ?>" class="btn btn-info mx-2">Histórico</a>
                <a href="historico_cliente.php" class="btn btn-info mx-2">Posição</a>
                <a href="historico_cliente.php" class="btn btn-info mx-2">Comportamento</a>
                <a href="historico_cliente.php" class="btn btn-info mx-2">Novações</a>
            </div>
        </div>
    </div>


<!-- LOCAL PARA COLOCAR OS JS -->

<?php include_once ROOT . "/vendor/footer_js.php"; ?>

<!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>