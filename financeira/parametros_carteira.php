<?php
// Lucas 21102024  

include_once(__DIR__ . '/../header.php');

?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">

        <div class="row">
            <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-6">
                <h2 class="ts-tituloPrincipal">Parâmetros Define Carteira</h2>
            </div>

            <div class="col-6 text-end">
                <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>

        </div>

        <!--------- INSERIR --------->
        <div class="modal" id="inserirModal" tabindex="-1" aria-labelledby="inserirModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inserir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="inserirForm">
                            <div class="row">
                                <div class="form-group col">
                                    <label>Tipo Operação</label>
                                    <input type="text" class="form-control text-end" name="tipoOperacao">
                                </div>
                                <div class="form-group col">
                                    <label>Carteira</label>
                                    <input type="number" class="form-control text-end" name="cobcod" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Vlr Parc</label>
                                    <input type="number" class="form-control text-end" name="valMinParc" step="0.01">
                                </div>
                                <div class="form-group col">
                                    <label>Qtd Parc</label>
                                    <input type="number" class="form-control text-end" name="qtdMinParc">
                                </div>
                                <div class="form-group col">
                                    <label>Valor Acrescismo</label>
                                    <input type="number" class="form-control text-end" name="valorMinimoAcrescimoTotal" step="0.01">
                                </div>
                            </div>

                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal" id="alterarModal" tabindex="-1" aria-labelledby="alterarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="alterarForm">
                            <div class="row">
                                <div class="form-group col">
                                    <label>Tipo Operação</label>
                                    <input type="text" class="form-control text-end" name="tipoOperacao" id="tipoOperacao" readonly>
                                </div>
                                <div class="form-group col">
                                    <label>Carteira</label>
                                    <input type="number" class="form-control text-end" name="cobcod" id="cobcod" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Vlr Parc</label>
                                    <input type="number" class="form-control text-end" name="valMinParc" id="valMinParc" step="0.01">
                                </div>
                                <div class="form-group col">
                                    <label>Qtd Parc</label>
                                    <input type="number" class="form-control text-end" name="qtdMinParc" id="qtdMinParc">
                                </div>
                                <div class="form-group col">
                                    <label>Valor Acrescismo</label>
                                    <input type="number" class="form-control text-end" name="valorMinimoAcrescimoTotal" id="valorMinimoAcrescimoTotal" step="0.01">
                                </div>
                            </div>

                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- EXCLUIR --------->
        <div class="modal" id="excluirModal" tabindex="-1" aria-labelledby="excluirModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="excluirForm">
                            <div class="row">
                                <div class="form-group col">
                                    <label>Tipo Operação</label>
                                    <input type="text" class="form-control text-end" name="tipoOperacao" id="exc_tipoOperacao" readonly>
                                </div>
                                <div class="form-group col">
                                    <label>Carteira</label>
                                    <input type="number" class="form-control text-end" name="cobcod" id="exc_cobcod" readonly>
                                </div>
                            </div>

                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>Tipo Operação</th>
                        <th style="width: 10px;" class="text-end">Car</th>
                        <th></th>
                        <th class="text-end">Vlr Parc</th>
                        <th class="text-end">Qtd Parc</th>
                        <th class="text-end">Vlr acres</th>

                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>
        <h6 class="fixed-bottom" id="textocontador" style="color: #13216A;"></h6>

    </div>
    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- script para menu de filtros -->
    <script src="<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>

    <script>
        $(document).ready(function() {
            var texto = $("#textocontador");
            texto.html('total: ' + 0);
        });

        buscar();

        function buscar() {

            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/crediario/database/financeira/parametroscarteira.php?operacao=buscar',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {

                },
                success: function(msg) {
                    var contadorItem = 0;
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        contadorItem += 1;
                        linha += "<tr>";

                        linha += "<td>" + object.tipoOperacao + "</td>";
                        linha += "<td class='text-end'>" + object.cobcod + "</td>";
                        linha += "<td>" + object.cobnom + "</td>";
                        linha += "<td class='text-end'>" + (object.valMinParc !== null ? object.valMinParc.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }) : "-") + "</td>";
                        linha += "<td class='text-end'>" + object.qtdMinParc + "</td>";
                        linha += "<td class='text-end'>" + (object.valorMinimoAcrescimoTotal !== null ? object.valorMinimoAcrescimoTotal.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }) : "-") + "</td>";

                        linha += "<td class='text-end'>" + "<button type='button' class='btn btn-warning btn-sm me-1' data-bs-toggle='modal' data-bs-target='#alterar' data-cobcod='" + object.cobcod + "' data-tipoOperacao='" + object.tipoOperacao + "'><i class='bi bi-pencil-square'></i></button>";
                        linha += "<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#excluir' data-cobcod='" + object.cobcod + "' data-tipoOperacao='" + object.tipoOperacao + "'><i class='bi bi-trash'></i></button></td>";


                        linha += "</tr>";
                    }

                    $("#dados").html(linha);
                    var texto = $("#textocontador");
                    texto.html('total: ' + contadorItem);

                }
            });
        }

        $("#buscar").click(function() {
            buscar($("#").val());
        });


        $(document).on('click', 'button[data-bs-target="#alterar"]', function() {
            var cobcod = $(this).attr("data-cobcod");
            var tipoOperacao = $(this).attr("data-tipoOperacao");

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/financeira/parametroscarteira.php?operacao=buscar',
                data: {
                    cobcod: cobcod,
                    tipoOperacao: tipoOperacao
                },
                success: function(data) {
                    $('#cobcod').val(data.cobcod);
                    $('#tipoOperacao').val(data.tipoOperacao);
                    $('#valMinParc').val(data.valMinParc);
                    $('#qtdMinParc').val(data.qtdMinParc);
                    $('#valorMinimoAcrescimoTotal').val(data.valorMinimoAcrescimoTotal);

                    $('#alterarModal').modal('show');
                }
            });
        });

        $(document).on('click', 'button[data-bs-target="#excluir"]', function() {
            var cobcod = $(this).attr("data-cobcod");
            var tipoOperacao = $(this).attr("data-tipoOperacao");

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/financeira/parametroscarteira.php?operacao=buscar',
                data: {
                    cobcod: cobcod,
                    tipoOperacao: tipoOperacao
                },
                success: function(data) {
                    $('#exc_cobcod').val(data.cobcod);
                    $('#exc_tipoOperacao').val(data.tipoOperacao);

                    $('#excluirModal').modal('show');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#inserirForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/financeira/parametroscarteira.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage
                });
            });

            $("#alterarForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/financeira/parametroscarteira.php?operacao=alterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage
                });
            });

            $("#excluirForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/financeira/parametroscarteira.php?operacao=excluir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage
                });
            });

            function refreshPage() {
                window.location.reload();
            }
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>