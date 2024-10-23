<?php
// Lucas 20092024  

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
                <h2 class="ts-tituloPrincipal">Parametrização REFIN</h2>
            </div>

            <div class="col-6 text-end">
                <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>

        </div>

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
                                <label>Data Início</label>
                                <input type="date" class="form-control" name="dtIniVig" id="view_dtIniVig" disabled>
                            </div>
                            <div class="form-group col-6">
                                <label>Lista de Modalidades</label>
                                <select class="form-control ts-displayDisable" name="listaModalidades[]" id="view_listaModalidades" multiple style="height: 125px; overflow-y: hidden;">
                                    <option value="CRE" class="cre" selected>CRE</option>
                                    <option value="CRN" class="sel-mod">CRN</option>
                                    <option value="CP0" class="sel-mod">CP0</option>
                                    <option value="CP1" class="sel-mod">CP1</option>
                                    <option value="CPN" class="sel-mod">CPN</option>
                                    <option value="RFN" class="sel-mod">RFN</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="form-group col">
                                <label>Dias de atraso Máximo</label>
                                <input type="number" class="form-control text-end" name="diasAtrasoMax" id="view_diasAtrasoMax" disabled>
                            </div>
                            <div class="form-group col">
                                <label>Carteiras Permitidas</label>
                                <input type="text" class="form-control" name="carteirasPermitidas" id="view_carteirasPermitidas" disabled>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="form-group col">
                                <label>Permite Novação</label>
                                <select class="form-control" name="permiteNovacao" id="view_permiteNovacao" disabled>
                                    <option value="false">Não</option>
                                    <option value="true">Sim</option>
                                </select>
                            </div>
                            <div class="form-group col">
                                <label>Percentual do contrato que está Pago</label>
                                <input type="number" class="form-control text-end" name="contratoPago" id="view_contratoPago" disabled>
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
                                    <label>Data Início</label>
                                    <input type="date" class="form-control" name="dtIniVig" id="inserir_dtIniVig" required>
                                </div>
                                <div class="form-group col-6">
                                    <label>Lista de Modalidades</label>
                                    <select class="form-control" name="listaModalidades[]" multiple style="height: 125px; overflow-y: hidden;">
                                        <option value="CRE" class="cre" selected>CRE</option>
                                        <option value="CRN" class="sel-mod">CRN</option>
                                        <option value="CP0" class="sel-mod">CP0</option>
                                        <option value="CP1" class="sel-mod">CP1</option>
                                        <option value="CPN" class="sel-mod">CPN</option>
                                        <option value="RFN" class="sel-mod">RFN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="form-group col">
                                    <label>Dias de atraso Máximo</label>
                                    <input type="number" class="form-control text-end" name="diasAtrasoMax">
                                </div>
                                <div class="form-group col">
                                    <label>Carteiras Permitidas</label>
                                    <input type="text" class="form-control" name="carteirasPermitidas">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="form-group col">
                                    <label>Permite Novação</label>
                                    <select class="form-control" name="permiteNovacao">
                                        <option value="false">Não</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Percentual do contrato que está Pago</label>
                                    <input type="number" class="form-control text-end" name="contratoPago">
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
                                    <label>Data Início</label>
                                    <input type="date" class="form-control" name="dtIniVig" id="dtIniVig" readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label>Lista de Modalidades</label>
                                    <select class="form-control" name="listaModalidades[]" id="listaModalidades" multiple style="height: 125px; overflow-y: hidden;">
                                        <option value="CRE" class="cre" selected>CRE</option>
                                        <option value="CRN" class="sel-mod">CRN</option>
                                        <option value="CP0" class="sel-mod">CP0</option>
                                        <option value="CP1" class="sel-mod">CP1</option>
                                        <option value="CPN" class="sel-mod">CPN</option>
                                        <option value="RFN" class="sel-mod">RFN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="form-group col">
                                    <label>Dias de atraso Máximo</label>
                                    <input type="number" class="form-control text-end" name="diasAtrasoMax" id="diasAtrasoMax">
                                </div>
                                <div class="form-group col">
                                    <label>Carteiras Permitidas</label>
                                    <input type="text" class="form-control" name="carteirasPermitidas" id="carteirasPermitidas">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="form-group col">
                                    <label>Permite Novação</label>
                                    <select class="form-control" name="permiteNovacao" id="permiteNovacao">
                                        <option value="false">Não</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Percentual do contrato que está Pago</label>
                                    <input type="number" class="form-control text-end" name="contratoPago" id="contratoPago">
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
                        <th>Data Inicio</th>
                        <th>listaModalidades</th>

                        <th colspan="2"></th>
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
                url: '<?php echo URLROOT ?>/crediario/database/financeira/rfnparam.php?operacao=buscar',
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
                        linha += "<td>" + object.listaModalidades + "</td>";

                        linha = linha + "<td class='text-end'><button type='button' class='btn btn-info btn-sm me-1' data-bs-toggle='modal' data-bs-target='#visualizar' data-dtIniVig='" + object.dtIniVig + "'><i class='bi bi-eye-fill'></i></button>";
                        linha = linha + "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterar' data-dtIniVig='" + object.dtIniVig + "'><i class='bi bi-pencil-square'></i></button></td>"

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

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/financeira/rfnparam.php?operacao=buscar',
                data: {
                    dtIniVig: dtIniVig
                },
                success: function(data) {
                    $('#view_dtIniVig').val(data.dtIniVig);
                    $('#view_listaModalidades').val(data.listaModalidades);
                    $('#view_diasAtrasoMax').val(data.diasAtrasoMax);
                    $('#view_carteirasPermitidas').val(data.carteirasPermitidas);
                    permiteNovacao = data.permiteNovacao == true ? "true" : "false";
                    $('#view_permiteNovacao').val(permiteNovacao);
                    $('#view_contratoPago').val(data.contratoPago);

                    modalidades = data.listaModalidades;
                    const arrayModalidade = modalidades.split(",");
                    if (arrayModalidade.includes("CRE") === true) {
                        $('#view_listaModalidades option:eq(0)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(0)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CRN") === true) {
                        $('#view_listaModalidades option:eq(1)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(1)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CP0") === true) {
                        $('#view_listaModalidades option:eq(2)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(2)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CP1") === true) {
                        $('#view_listaModalidades option:eq(3)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(3)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CPN") === true) {

                        $('#view_listaModalidades option:eq(4)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(4)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("RFN") === true) {

                        $('#view_listaModalidades option:eq(5)').prop('selected', true);
                    } else {
                        $('#view_listaModalidades option:eq(5)').prop('selected', false);
                    }


                    $('#visualizarModal').modal('show');
                }
            });
        });

        $(document).on('click', 'button[data-bs-target="#alterar"]', function() {
            var dtIniVig = $(this).attr("data-dtIniVig");

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/financeira/rfnparam.php?operacao=buscar',
                data: {
                    dtIniVig: dtIniVig
                },
                success: function(data) {
                    $('#dtIniVig').val(data.dtIniVig);
                    $('#listaModalidades').val(data.listaModalidades);
                    $('#diasAtrasoMax').val(data.diasAtrasoMax);
                    $('#carteirasPermitidas').val(data.carteirasPermitidas);
                    permiteNovacao = data.permiteNovacao == true ? "true" : "false";
                    $('#permiteNovacao').val(permiteNovacao);
                    $('#contratoPago').val(data.contratoPago);

                    modalidades = data.listaModalidades;
                    const arrayModalidade = modalidades.split(",");
                    if (arrayModalidade.includes("CRE") === true) {
                        $('#listaModalidades option:eq(0)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(0)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CRN") === true) {
                        $('#listaModalidades option:eq(1)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(1)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CP0") === true) {
                        $('#listaModalidades option:eq(2)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(2)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CP1") === true) {
                        $('#listaModalidades option:eq(3)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(3)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("CPN") === true) {

                        $('#listaModalidades option:eq(4)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(4)').prop('selected', false);
                    }
                    if (arrayModalidade.includes("RFN") === true) {

                        $('#listaModalidades option:eq(5)').prop('selected', true);
                    } else {
                        $('#listaModalidades option:eq(5)').prop('selected', false);
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
                    url: "../database/financeira/rfnparam.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                    /* success: function(data) {
                        //console.log(JSON.stringify(data, null, 2));
                        var json = JSON.parse(data);
                        //alert(json.status)
                        if (json.status == 200) {
                            refreshPage();
                        }
                        if (json.status == 400) {
                            alert("Data já cadastrada")
                        }

                    } */
                });
            });

            $("#alterarForm").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/financeira/rfnparam.php?operacao=alterar",
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

        // Ao iniciar o programa, inseri os valores de data nos inputs. 
        $(document).ready(function() {
            var data = new Date(),
                dia = data.getDate().toString(),
                diaF = (dia.length == 1) ? '0' + dia : dia,
                mes = (data.getMonth() + 1).toString(), //+1 pois no getMonth Janeiro come�a com zero.
                mesF = (mes.length == 1) ? '0' + mes : mes,
                anoF = data.getFullYear();
            dataAtual = anoF + "-" + mesF + "-" + diaF;
            primeirodiadomes = anoF + "-" + mesF + "-" + "01";

            const inserir_dtIniVig = document.getElementById("inserir_dtIniVig");
            inserir_dtIniVig.value = dataAtual;

        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>