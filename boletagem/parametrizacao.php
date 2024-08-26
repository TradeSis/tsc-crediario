<?php
// Lucas 05082024  

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
                <h2 class="ts-tituloPrincipal">Parametrização</h2>
            </div>

            <div class="col-6 text-end">
                <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>

        </div>


        <div class="table mt-2 ts-divTabela ts-tableFiltros">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>Data Inicio</th>
                        <th>Data Final</th>
                        <th>listaModalidades</th>

                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>
        <h6 class="fixed-bottom" id="textocontador" style="color: #13216A;"></h6>

        <!--------- VISUALIZAR --------->
        <div class="modal" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Visualizar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="form-group col">
                                <label>dtIniVig</label>
                                <input type="date" class="form-control" name="dtIniVig" id="view_dtIniVig" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label>listaModalidades</label>
                                <select class="form-control ts-displayDisable" name="listaModalidades[]" id="view_listaModalidades" multiple style="height: 90px; overflow-y: hidden;">
                                    <option value="CRE">CRE</option>
                                    <option value="CP0">CP0</option>
                                    <option value="CP1">CP1</option>
                                    <option value="CPN">CPN</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>QtdParcMin</label>
                                <input type="number" class="form-control text-end" name="QtdParcMin" id="view_QtdParcMin" readonly>
                            </div>
                            <div class="form-group col">
                                <label>QtdParcMax</label>
                                <input type="number" class="form-control text-end" name="QtdParcMax" id="view_QtdParcMax" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>listaCarterias</label>
                                <input type="text" class="form-control" name="listaCarterias" id="view_listaCarterias" readonly>
                            </div>
                            <div class="form-group col">
                                <label>AssinaturaDigital</label>
                                <select class="form-control ts-displayDisable" name="AssinaturaDigital" id="view_AssinaturaDigital">
                                    <option value="NAO">Não</option>
                                    <option value="SIM">Sim</option>
                                    <option value="TODOS">TODOS</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>IdadeMin</label>
                                <input type="number" class="form-control text-end" name="IdadeMin" id="view_IdadeMin" readonly>
                            </div>
                            <div class="form-group col">
                                <label>IdadeMax</label>
                                <input type="number" class="form-control text-end" name="IdadeMax" id="view_IdadeMax" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>DiasPrimeiroVencMin</label>
                                <input type="number" class="form-control text-end" name="DiasPrimeiroVencMin" id="view_DiasPrimeiroVencMin" readonly>
                            </div>
                            <div class="form-group col">
                                <label>DiasPrimeiroVencMax</label>
                                <input type="number" class="form-control text-end" name="DiasPrimeiroVencMax" id="view_DiasPrimeiroVencMax" readonly>
                            </div>
                            <div class="form-group col">
                                <label>valorParcelMin</label>
                                <input type="number" class="form-control text-end" name="valorParcelMin" id="view_valorParcelMin" step="0.01" readonly>
                            </div>
                            <div class="form-group col">
                                <label>valorParcelaMax</label>
                                <input type="number" class="form-control text-end" name="valorParcelaMax" id="view_valorParcelaMax" step="0.01" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>listaPlanos</label>
                                <input type="text" class="form-control" name="listaPlanos" id="view_listaPlanos" readonly>
                            </div>
                        </div>
                    </div><!--body-->

                </div>
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
                                    <label>dtIniVig</label>
                                    <input type="date" class="form-control" name="dtIniVig" required>
                                </div>
                                <div class="form-group col-6">
                                    <label>listaModalidades</label>
                                    <select class="form-control" name="listaModalidades[]" multiple style="height: 90px; overflow-y: hidden;">
                                        <option value="CRE" class="cre" selected>CRE</option>
                                        <option value="CP0" class="sel-mod">CP0</option>
                                        <option value="CP1" class="sel-mod">CP1</option>
                                        <option value="CPN" class="sel-mod">CPN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>QtdParcMin</label>
                                    <input type="number" class="form-control text-end" name="QtdParcMin">
                                </div>
                                <div class="form-group col">
                                    <label>QtdParcMax</label>
                                    <input type="number" class="form-control text-end" name="QtdParcMax">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>listaCarterias</label>
                                    <input type="text" class="form-control" name="listaCarterias">
                                </div>
                                <div class="form-group col">
                                    <label>AssinaturaDigital</label>
                                    <select class="form-control" name="AssinaturaDigital">
                                        <option value="NAO">Não</option>
                                        <option value="SIM">Sim</option>
                                        <option value="TODOS">TODOS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>IdadeMin</label>
                                    <input type="number" class="form-control text-end" name="IdadeMin">
                                </div>
                                <div class="form-group col">
                                    <label>IdadeMax</label>
                                    <input type="number" class="form-control text-end" name="IdadeMax">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>DiasPrimeiroVencMin</label>
                                    <input type="number" class="form-control text-end" name="DiasPrimeiroVencMin">
                                </div>
                                <div class="form-group col">
                                    <label>DiasPrimeiroVencMax</label>
                                    <input type="number" class="form-control text-end" name="DiasPrimeiroVencMax">
                                </div>
                                <div class="form-group col">
                                    <label>valorParcelMin</label>
                                    <input type="number" class="form-control text-end" name="valorParcelMin" step="0.01">
                                </div>
                                <div class="form-group col">
                                    <label>valorParcelaMax</label>
                                    <input type="number" class="form-control text-end" name="valorParcelaMax" step="0.01">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>listaPlanos</label>
                                    <input type="text" class="form-control" name="listaPlanos">
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
                                    <label>dtIniVig</label>
                                    <input type="date" class="form-control" name="dtIniVig" id="dtIniVig" readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label>listaModalidades</label>
                                    <select class="form-control ts-displayDisable" name="listaModalidades[]" id="listaModalidades" multiple style="height: 90px; overflow-y: hidden;">
                                        <option value="CRE">CRE</option>
                                        <option value="CP0">CP0</option>
                                        <option value="CP1">CP1</option>
                                        <option value="CPN">CPN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>QtdParcMin</label>
                                    <input type="number" class="form-control text-end" name="QtdParcMin" id="QtdParcMin">
                                </div>
                                <div class="form-group col">
                                    <label>QtdParcMax</label>
                                    <input type="number" class="form-control text-end" name="QtdParcMax" id="QtdParcMax">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>listaCarterias</label>
                                    <input type="text" class="form-control" name="listaCarterias" id="listaCarterias">
                                </div>
                                <div class="form-group col">
                                    <label>AssinaturaDigital</label>
                                    <select class="form-control" name="AssinaturaDigital" id="AssinaturaDigital">
                                        <option value="NAO">Não</option>
                                        <option value="SIM">Sim</option>
                                        <option value="TODOS">TODOS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>IdadeMin</label>
                                    <input type="number" class="form-control text-end" name="IdadeMin" id="IdadeMin">
                                </div>
                                <div class="form-group col">
                                    <label>IdadeMax</label>
                                    <input type="number" class="form-control text-end" name="IdadeMax" id="IdadeMax">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>DiasPrimeiroVencMin</label>
                                    <input type="number" class="form-control text-end" name="DiasPrimeiroVencMin" id="DiasPrimeiroVencMin">
                                </div>
                                <div class="form-group col">
                                    <label>DiasPrimeiroVencMax</label>
                                    <input type="number" class="form-control text-end" name="DiasPrimeiroVencMax" id="DiasPrimeiroVencMax">
                                </div>
                                <div class="form-group col">
                                    <label>valorParcelMin</label>
                                    <input type="number" class="form-control text-end" name="valorParcelMin" id="valorParcelMin" step="0.01">
                                </div>
                                <div class="form-group col">
                                    <label>valorParcelaMax</label>
                                    <input type="number" class="form-control text-end" name="valorParcelaMax" id="valorParcelaMax" step="0.01">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>listaPlanos</label>
                                    <input type="text" class="form-control" name="listaPlanos" id="listaPlanos">
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
                url: '<?php echo URLROOT ?>/crediario/database/parametrizacao.php?operacao=buscar',
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

                        linha += "<td>" + formatDate(object.dtIniVig) + "</td>";
                        linha += "<td>" + formatDate(object.dtFimVig) + "</td>";
                        linha += "<td>" + object.listaModalidades + "</td>";

                        if (object.dtFimVig != null) {
                            linha = linha + "<td><button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#visualizar' data-dtIniVig='" + object.dtIniVig + "' data-listaModalidades='" + object.listaModalidades + "'><i class='bi bi-eye-fill'></i></button></td>";
                        } else {
                            linha = linha + "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterar' data-dtIniVig='" + object.dtIniVig + "' data-listaModalidades='" + object.listaModalidades + "'><i class='bi bi-pencil-square'></i></button>"
                        }

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



        // modifica efeito de seleção do select modalidade
        window.onmousedown = function(e) {
            var el = e.target;
            if (el.tagName.toLowerCase() == 'option' && el.parentNode.hasAttribute('multiple')) {
                e.preventDefault();

                if (el.hasAttribute('selected')) el.removeAttribute('selected');
                else el.setAttribute('selected', '');

                var select = el.parentNode.cloneNode(true);
                el.parentNode.parentNode.replaceChild(select, el.parentNode);
            }
        }

        $(document).on('click', 'button[data-bs-target="#visualizar"]', function() {
            var dtIniVig = $(this).attr("data-dtIniVig");
            var listaModalidades = $(this).attr("data-listaModalidades");

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/parametrizacao.php?operacao=buscar',
                data: {
                    dtIniVig: dtIniVig,
                    listaModalidades: listaModalidades
                },
                success: function(data) {
                    $('#view_dtIniVig').val(data.dtIniVig);
                    $('#view_listaModalidades').val(data.listaModalidades);
                    $('#view_QtdParcMin').val(data.QtdParcMin);
                    $('#view_QtdParcMax').val(data.QtdParcMax);
                    $('#view_listaCarterias').val(data.listaCarterias);
                    $('#view_AssinaturaDigital').val(data.AssinaturaDigital);
                    $('#view_IdadeMin').val(data.IdadeMin);
                    $('#view_IdadeMax').val(data.IdadeMax);
                    $('#view_DiasPrimeiroVencMin').val(data.DiasPrimeiroVencMin);
                    $('#view_DiasPrimeiroVencMax').val(data.DiasPrimeiroVencMax);
                    $('#view_valorParcelMin').val(data.valorParcelMin);
                    $('#view_valorParcelaMax').val(data.valorParcelaMax);
                    $('#view_listaPlanos').val(data.listaPlanos);

                    modalidades = data.listaModalidades;
                    const arrayModalidade = modalidades.split(",");
                    if (arrayModalidade.includes("CRE") === true) {
                        $('#view_listaModalidades option:eq(0)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(0)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CP0") === true) {
                        $('#view_listaModalidades option:eq(1)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(1)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CP1") === true) {
                        $('#view_listaModalidades option:eq(2)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(2)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CPN") === true) {

                        $('#view_listaModalidades option:eq(3)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(3)').prop('selected', false);
                    }


                    $('#visualizarModal').modal('show');
                }
            });
        });

        $(document).on('click', 'button[data-bs-target="#alterar"]', function() {
            var dtIniVig = $(this).attr("data-dtIniVig");
            var listaModalidades = $(this).attr("data-listaModalidades");
            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/parametrizacao.php?operacao=buscar',
                data: {
                    dtIniVig: dtIniVig,
                    listaModalidades: listaModalidades
                },
                success: function(data) {
                    $('#dtIniVig').val(data.dtIniVig);
                    $('#listaModalidades').val(data.listaModalidades);
                    $('#QtdParcMin').val(data.QtdParcMin);
                    $('#QtdParcMax').val(data.QtdParcMax);
                    $('#listaCarterias').val(data.listaCarterias);
                    $('#AssinaturaDigital').val(data.AssinaturaDigital);
                    $('#IdadeMin').val(data.IdadeMin);
                    $('#IdadeMax').val(data.IdadeMax);
                    $('#DiasPrimeiroVencMin').val(data.DiasPrimeiroVencMin);
                    $('#DiasPrimeiroVencMax').val(data.DiasPrimeiroVencMax);
                    $('#valorParcelMin').val(data.valorParcelMin);
                    $('#valorParcelaMax').val(data.valorParcelaMax);
                    $('#listaPlanos').val(data.listaPlanos);

                    modalidades = data.listaModalidades;
                    const arrayModalidade = modalidades.split(",");
                    if (arrayModalidade.includes("CRE") === true) {
                        $('#listaModalidades option:eq(0)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(0)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CP0") === true) {
                        $('#listaModalidades option:eq(1)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(1)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CP1") === true) {
                        $('#listaModalidades option:eq(2)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(2)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CPN") === true) {

                        $('#listaModalidades option:eq(3)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(3)').prop('selected', false);
                    }


                    $('#alterarModal').modal('show');
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
                    url: "../database/parametrizacao.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    //success: refreshPage,
                    success: function(data) {
                        //console.log(JSON.stringify(data, null, 2));
                        var json = JSON.parse(data);
                        //alert(json.status)
                        if (json.status == 200) {
                            refreshPage();
                        }
                        if (json.status == 400) {
                            alert("Data já cadastrada")
                        }

                    }
                });
            });

            $("#alterarForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/parametrizacao.php?operacao=alterar",
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


        // Formatar input de valor decimal
        $(document).ready(function() {
            $('.formatValorDecimal').mask("#.##0,00", {
                reverse: true
            });
            $('.formatValorDecimal').addClass("text-end")
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>