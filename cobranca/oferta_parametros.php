<?php
//Lucas 23092024 criado

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
            <div class="col-md-6 card p-0">
                <div class="card-header">
                    <h3>Consultar</h3>
                </div>
                <div class="modal-body">
                    <form action="acooferta.php?parametros" method="POST">
                        <div class="form-group">
                            <label>Código Cliente</label>
                            <input type="number" class="form-control" name="codigoCliente" id="codigoCliente">
                            <label>CPF/CNPJ</label>
                            <input type="number" class="form-control" name="cpfCnpj" id="cpfCnpj">
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-6">
                                <label>Tipo Negociação</label>
                                <select class="form-control" name="tpNegociacao">
                                    <option value="ACORDO ONLINE">ACORDO ONLINE</option>
                                    <option value="SERASA">SERASA</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="bottom" class="btn btn-sm btn-success" id="btnEnviar">Consultar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        // Verifica se tem Código Cliente ou CPF/CNPJ
        const btn = document.querySelector("#btnEnviar");
        btn.addEventListener("click", function(e) {

            codigoCliente = $('#codigoCliente').val();
            cpfCnpj = $('#cpfCnpj').val();
            if ((codigoCliente == '') && (cpfCnpj == '')) {
                alert("Digitar campo Código Cliente ou CPF/CNPJ")
                e.preventDefault();
            }
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>