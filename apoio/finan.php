<?php
//Lucas 23102024 criado
include_once(__DIR__ . '/../header.php');

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">

        <div class="row ">
            <!--<BR >MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!--<BR> BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-6 col-lg-6">
                <h2 class="ts-tituloPrincipal">Planos</h2>
            </div>

            <div class="col-6 col-lg-6">
                <div class="input-group">
                    <input type="text" placeholder="Buscar código do plano" class="form-control ts-input"
                        id="buscaPlano" name="buscaPlano">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i
                            class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-tableFiltros text-center">
            <table class="table table-hover table-sm align-middle">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>Cod.</th>
                        <th>Descrição</th>
                        <th>Entrada</th>
                        <th>N. Prest.</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>


        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirModal" tabindex="-1"
            aria-labelledby="inserirModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Plano</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="inserirForm">
                            <div class="row">
                                <div class="col-2">
                                    <label class="form-label ts-label">Código</label>
                                    <input type="number" class="form-control ts-input" name="fincod">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Descrição</label>
                                    <input type="text" class="form-control ts-input" name="finnom">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Entrada</label>
                                    <select class="form-select ts-input" name="finent">
                                        <option value="Nao">Não</option>
                                        <option value="Sim">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">N.Prest.</label>
                                    <input type="text" class="form-control ts-input" name="finnpc">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Fator</label>
                                    <input type="text" class="form-control ts-input" name="finfat">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Data Export</label>
                                    <input type="date" class="form-control ts-input" name="datexp">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Juros ao Mes</label>
                                    <input type="text" class="form-control ts-input" name="txjurosmes">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Juros ao Ano</label>
                                    <input type="text" class="form-control ts-input" name="txjurosano">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">N.Dias Primeiro Pagto</label>
                                    <input type="text" class="form-control ts-input" name="DPriPag">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Recorrencia</label>
                                    <select class="form-select ts-input" name="recorrencia">
                                        <option value="Nao">Não</option>
                                        <option value="Sim">Sim</option>
                                    </select>
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

        <!--------- ALTERAR --------->
        <div class="modal fade bd-example-modal-lg" id="alterarModal" tabindex="-1"
            aria-labelledby="alterarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Plano</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="alterarForm">
                            <div class="row">
                                <div class="col-2">
                                    <label class="form-label ts-label">Código</label>
                                    <input type="number" class="form-control ts-input" name="fincod" id="fincod" readonly>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Descrição</label>
                                    <input type="text" class="form-control ts-input" name="finnom" id="finnom">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Entrada</label>
                                    <select class="form-select ts-input" name="finent" id="finent">
                                        <option value="Nao">Não</option>
                                        <option value="Sim">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">N.Prest.</label>
                                    <input type="text" class="form-control ts-input" name="finnpc" id="finnpc">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Fator</label>
                                    <input type="text" class="form-control ts-input" name="finfat" id="finfat">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Data Export</label>
                                    <input type="date" class="form-control ts-input" name="datexp" id="datexp">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Juros ao Mes</label>
                                    <input type="text" class="form-control ts-input" name="txjurosmes" id="txjurosmes">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Juros ao Ano</label>
                                    <input type="text" class="form-control ts-input" name="txjurosano" id="txjurosano">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">N.Dias Primeiro Pagto</label>
                                    <input type="text" class="form-control ts-input" name="DPriPag" id="DPriPag">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Recorrencia</label>
                                    <select class="form-select ts-input" name="recorrencia" id="recorrencia">
                                        <option value="Nao">Não</option>
                                        <option value="Sim">Sim</option>
                                    </select>
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
        <div class="modal fade bd-example-modal-lg" id="excluirModal" tabindex="-1"
            aria-labelledby="excluirModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Excluir Plano</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="excluirForm">
                            <div class="row">
                                <div class="col-2">
                                    <label class="form-label ts-label">Código</label>
                                    <input type="number" class="form-control ts-input" name="fincod" id="exc_fincod" readonly>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Descrição</label>
                                    <input type="text" class="form-control ts-input" name="finnom" id="exc_finnom" readonly>
                                </div>
                            </div>
                            
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div><!--container-fluid-->
    <div class="container text-center my-1">
        <button id="prevPage" class="btn btn-primary mr-2" style="display:none;">Anterior</button>
        <button id="nextPage" class="btn btn-primary" style="display:none;">Proximo</button>
    </div>


    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        var pagina = 0;

        buscar();

        function limpar() {
            buscar(null);
            window.location.reload();
        }

        function buscar(buscaPlano, pagina) {
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: "<?php echo URLROOT ?>/crediario/database/finan.php?operacao=buscar",
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    fincod: buscaPlano,
                    pagina: pagina,
                },
                async: false,
                success: function(msg) {
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.fincod + "</td>";
                        linha = linha + "<td>" + object.finnom + "</td>";
                        linha = linha + "<td>" + (object.finent == true ? "Com" : "Sem") + "</td>";
                        linha = linha + "<td>" + object.finnpc + "</td>";
                        linha = linha + "<td class='text-end'>" + "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarModal' data-fincod='" + object.fincod + "'><i class='bi bi-pencil-square'></i></button> ";
                        linha = linha + "<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#excluirModal' data-fincod='" + object.fincod + "'><i class='bi bi-trash'></i></button> " + "</td>";
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);

                    $("#prevPage, #nextPage").show();
                    if (pagina == 0) {
                        $("#prevPage").hide();
                    }
                    if (json.length < 10) {
                        $("#nextPage").hide();
                    }
                }
            });
        }
        $("#buscar").click(function() {
            pagina = 0;
            buscar($("#buscaPlano").val(), pagina);
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                pagina = 0;
                buscar($("#buscaPlano").val(), pagina);
            }
        });

        $("#prevPage").click(function() {
            if (pagina > 0) {
                pagina -= 10;
                buscar($("#buscaPlano").val(), pagina);
            }
        });

        $("#nextPage").click(function() {
            pagina += 10;
            buscar($("#buscaPlano").val(), pagina);
        });

        $(document).on('click', 'button[data-bs-target="#alterarModal"]', function() {
            var fincod = $(this).attr("data-fincod");
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/finan.php?operacao=buscar',
                data: {
                    fincod: fincod
                },
                success: function(data) {
                    var finan = data[0];
                   
                    $('#fincod').val(finan.fincod);
                    $('#finnom').val(finan.finnom);
                    $('#finent').val(finan.finent == true ? "Sim" : "Nao");
                    $('#finnpc').val(finan.finnpc);
                    $('#finfat').val(finan.finfat);
                    $('#datexp').val(finan.datexp);
                    $('#txjurosmes').val(finan.txjurosmes);
                    $('#txjurosano').val(finan.txjurosano);
                    $('#DPriPag').val(finan.DPriPag);
                    $('#recorrencia').val(finan.recorrencia == true ? "Sim" : "Nao");

                    $('#alterarModal').modal('show');
                }
            });
        });

        $(document).on('click', 'button[data-bs-target="#excluirModal"]', function() {
            var fincod = $(this).attr("data-fincod");
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/finan.php?operacao=buscar',
                data: {
                    fincod: fincod
                },
                success: function(data) {
                    var finan = data[0];
                   
                    $('#exc_fincod').val(finan.fincod);
                    $('#exc_finnom').val(finan.finnom);

                    $('#excluirModal').modal('show');
                }
            });
        });

        // FORMATAR DATAS
        function formatDate(dateString) {
            if (dateString !== null && !isNaN(new Date(dateString))) {
                var date = new Date(dateString);
                var day = date.getUTCDate().toString().padStart(2, '0');
                var month = (date.getUTCMonth() + 1).toString().padStart(2, '0');
                var year = date.getUTCFullYear().toString().padStart(4, '0');
                return day + "/" + month + "/" + year;
            }
            return "";
        }

        $(document).ready(function() {
            $("#inserirForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/finan.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#alterarForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/finan.php?operacao=alterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['status'] == 400) {
                            alert(json['descricaoStatus'])
                        } else {
                            refreshPage()
                        }
                    }
                });
            });

            $("#excluirForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/finan.php?operacao=excluir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['status'] == 400) {
                            alert(json['descricaoStatus'])
                        } else {
                            refreshPage()
                        }
                    }
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