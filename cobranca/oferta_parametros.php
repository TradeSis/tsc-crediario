<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 27022023 13:51 ajustado action ?parametros
// gabriel 22022023 16:00

include_once '../header.php';
$tpNegociacao = $_GET['tpNegociacao'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6 card p-0">
                <div class="card-header">
                    <h3>Ofertas <?php echo $tpNegociacao ?></h3>
                </div>
                <div class="container">
                    <form action="acooferta.php?parametros&tpNegociacao=<?php echo $tpNegociacao ?>" method="POST">
                        <div class="form-group">
                            <label>Código Cliente</label>
                            <input type="number" class="form-control" name="codigoCliente">
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" class="btn btn-sm btn-success">Consultar Ofertas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- LOCAL PARA COLOCAR OS JS -->

<?php include_once ROOT . "/vendor/footer_js.php"; ?>

<!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>