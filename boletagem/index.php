<?php
include_once(__DIR__ . '/../header.php');

?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>


<body>
    <div class="container-fluid pt-4">

        <div class="list-group">
            <a href="parametrizacao.php" class="list-group-item">
                <div class="row g-0">
                    <div class="col-1 text-center " style="width: 50px;">
                        <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                    </div>
                    <div class="col ms-2 me-auto">
                        <div class="fw-bold">Parametrização</div>
                    </div>
                </div>
            </a>
            <a href="boletos.php" class="list-group-item">
                <div class="row g-0">
                    <div class="col-1 text-center " style="width: 50px;">
                        <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                    </div>
                    <div class="col ms-2 me-auto">
                        <div class="fw-bold">Boletos</div>
                    </div>
                </div>
            </a>

        </div>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>