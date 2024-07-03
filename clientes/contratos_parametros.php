<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 22022023 16:00


include_once '../header.php';

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
            <div class="col-md-6 card  p-0">
                <div class="card-header">
                    <h3>Busca Contrato</h3>
                </div>
                <div class="container">
                    <form action="contratos.php?parametros" method="POST">
                        <div class="form-group">
                            <label>Número Contrato</label>
                            <input type="number" class="form-control" name="numeroContrato">
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" class="btn btn-sm btn-success">Consultar Contrato</button>
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