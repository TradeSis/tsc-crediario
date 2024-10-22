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
                <h2 class="ts-tituloPrincipal">Parâmetros Define Produto</h2>
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
                                    <select class="form-control" name="tipoOperacao" required>
                                        <option value="">Selecione</option>
                                        <option value="CDC">CDC</option>
                                        <option value="NOVACAO">NOVACAO</option>
                                        <option value="NOVACAO EP">NOVACAO EP</option>
                                        <option value="EP SAQUE">EP SAQUE</option>
                                        <option value="EP DEPOSITO">EP DEPOSITO</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Código Produto</label>
                                    <input type="number" class="form-control text-end" name="codpro" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Assinado Eletronico</label>
                                    <select class="form-control" name="assEletronico">
                                        <option value="SIM">Sim</option>
                                        <option value="NAO">Não</option>
                                        <option value="TODOS">TODOS</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Boletado</label>
                                    <select class="form-control" name="boletado">
                                        <option value="SIM">Sim</option>
                                        <option value="NAO">Não</option>
                                        <option value="TODOS">TODOS</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Acrescimo</label>
                                    <input type="number" class="form-control text-end" name="vlrMinAcrescimo" step="0.01">
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
                                    <select class="form-control ts-displayDisable" name="tipoOperacao" id="tipoOperacao">
                                        <option value="">Selecione</option>
                                        <option value="CDC">CDC</option>
                                        <option value="NOVACAO">NOVACAO</option>
                                        <option value="NOVACAO EP">NOVACAO EP</option>
                                        <option value="EP SAQUE">EP SAQUE</option>
                                        <option value="EP DEPOSITO">EP DEPOSITO</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Código Produto</label>
                                    <input type="number" class="form-control text-end" name="codpro" id="codpro" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Assinado Eletronico</label>
                                    <select class="form-control" name="assEletronico" id="assEletronico">
                                        <option value="SIM">Sim</option>
                                        <option value="NAO">Não</option>
                                        <option value="TODOS">TODOS</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Boletado</label>
                                    <select class="form-control" name="boletado" id="boletado">
                                        <option value="SIM">Sim</option>
                                        <option value="NAO">Não</option>
                                        <option value="TODOS">TODOS</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Acrescimo</label>
                                    <input type="number" class="form-control text-end" name="vlrMinAcrescimo" id="vlrMinAcrescimo" step="0.01">
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
                                    <label>Código Produto</label>
                                    <input type="number" class="form-control text-end" name="codpro" id="exc_codpro" readonly>
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
                        <th>Produto</th>
                        <th>Ass. Eletronico</th>
                        <th>Boletado</th>
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
                url: '<?php echo URLROOT ?>/crediario/database/financeira/parametrosproduto.php?operacao=buscar',
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
                        linha += "<td>" + object.codpro + "</td>";
                        linha += "<td>" + object.assEletronico + "</td>";
                        linha += "<td>" + object.boletado + "</td>";
                        linha += "<td class='text-end'>" + (object.vlrMinAcrescimo !== null ? object.vlrMinAcrescimo.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }) : "-") + "</td>";

                        linha += "<td class='text-end'>" + "<button type='button' class='btn btn-warning btn-sm me-1' data-bs-toggle='modal' data-bs-target='#alterar' data-codpro='" + object.codpro + "' data-tipoOperacao='" + object.tipoOperacao + "'><i class='bi bi-pencil-square'></i></button>";
                        linha += "<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#excluir' data-codpro='" + object.codpro + "' data-tipoOperacao='" + object.tipoOperacao + "'><i class='bi bi-trash'></i></button></td>";


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
            var codpro = $(this).attr("data-codpro");
            var tipoOperacao = $(this).attr("data-tipoOperacao");

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/financeira/parametrosproduto.php?operacao=buscar',
                data: {
                    codpro: codpro,
                    tipoOperacao: tipoOperacao
                },
                success: function(data) {
                    $('#codpro').val(data.codpro);
                    $('#tipoOperacao').val(data.tipoOperacao);
                    $('#assEletronico').val(data.assEletronico);
                    $('#boletado').val(data.boletado);
                    $('#vlrMinAcrescimo').val(data.vlrMinAcrescimo);

                    $('#alterarModal').modal('show');
                }
            });
        });

        $(document).on('click', 'button[data-bs-target="#excluir"]', function() {
            var codpro = $(this).attr("data-codpro");
            var tipoOperacao = $(this).attr("data-tipoOperacao");

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/financeira/parametrosproduto.php?operacao=buscar',
                data: {
                    codpro: codpro,
                    tipoOperacao: tipoOperacao
                },
                success: function(data) {
                    $('#exc_codpro').val(data.codpro);
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
                    url: "../database/financeira/parametrosproduto.php?operacao=inserir",
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
                    url: "../database/financeira/parametrosproduto.php?operacao=alterar",
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
                    url: "../database/financeira/parametrosproduto.php?operacao=excluir",
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