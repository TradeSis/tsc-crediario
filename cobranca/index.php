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
        <div class="row">
            <!-- Coluna 1 -->
            <div class="col">
                <div class="list-group">
                    <a href="aconegoc.php" class="list-group-item mb-2">
                        <div class="row g-0">
                            <div class="col-1 text-center " style="width: 50px;">
                                <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                            </div>
                            <div class="col ms-2 me-auto">
                                <div class="fw-bold">Parametrizações de Acordos</div>
                            </div>
                        </div>
                    </a>          
                </div>

                <div class="list-group">
                    <a href="serasacli.php" class="list-group-item mb-2">
                        <div class="row g-0">
                            <div class="col-1 text-center " style="width: 50px;">
                                <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                            </div>
                            <div class="col ms-2 me-auto">
                                <div class="fw-bold">Serasa Remessas</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="list-group">
                    <a href="aoacordo.php" class="list-group-item mb-2">
                        <div class="row g-0">
                            <div class="col-1 text-center " style="width: 50px;">
                                <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                            </div>
                            <div class="col ms-2 me-auto">
                                <div class="fw-bold">Gestão de Acordos </div>
                            </div>
                        </div>
                    </a>          
                </div>
            </div>
            <!-- Coluna 2 -->
            <div class="col">
                <div class="list-group">
                    <a href="oferta_parametros.php" class="list-group-item mb-2">
                        <div class="row g-0">
                            <div class="col-1 text-center " style="width: 50px;">
                                <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                            </div>
                            <div class="col ms-2 me-auto">
                                <div class="fw-bold">Serasa - Consulta Ofertas</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="list-group">
                    <a href="oferta_parametros.php" class="list-group-item mb-2">
                        <div class="row g-0">
                            <div class="col-1 text-center " style="width: 50px;">
                                <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                            </div>
                            <div class="col ms-2 me-auto">
                                <div class="fw-bold">Acordo Online - Consulta Ofertas</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>



    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>