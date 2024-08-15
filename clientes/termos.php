<?php
include_once '../header.php';
include_once '../database/termos.php';

$termos = buscaTermos();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link href="termos.css" rel="stylesheet" type="text/css">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10 card p-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-5">
                            <h3>Termos</h3>
                        </div>
    
                        <div class="col-5">
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#inserirTermosModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mb-2">
                    <div class="table mt-2 ts-tableFiltros text-center">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="ts-headertabelafixo">
                                <tr>
                                    <th>IDtermo</th>
                                    <th>Nome</th>
                                    <th>Copias</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <?php foreach ($termos as $termo) { ?>
                                <tr>
                                    <td><?php echo $termo['IDtermo'] ?></td>
                                    <td><?php echo $termo['termoNome'] ?></td>
                                    <td><?php echo $termo['termoCopias'] ?></td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="termos_visualizar.php?IDtermo=<?php echo $termo['IDtermo'] ?>" role="button"><i class='bi bi-eye-fill'></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirTermosModal" tabindex="-1"
            aria-labelledby="inserirTermosModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Termo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-inserirTermos">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>ID</label>
                                    <input type="text" class="form-control" name="IDtermo">
                                </div>
                                <div class="col-md-5">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="termoNome">
                                </div>
                                <div class="col-md-2">
                                    <label>Copias</label>
                                    <input type="text" class="form-control" name="termoCopias">
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btn-formInserir">Cadastrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

    <script>
        $(document).ready(function () {
            $("#form-inserirTermos").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/termos.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            function refreshPage() {
                window.location.reload();
            }

        });
    </script>
</body>

</html>