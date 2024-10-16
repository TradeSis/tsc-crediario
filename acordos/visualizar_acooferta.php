<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 27022023 13:51 - ajustado direcionamento para consulta de contrato
// gabriel 23022023 09:50

include_once '../header.php';
include_once '../database/acooferta.php';

$tpNegociacao = $_GET['tpNegociacao'];
$ofertaAcordo = buscaOfertaAcordoOnline($tpNegociacao, $_GET['clicod'], $_GET['negcod']);
//echo json_encode($ofertaAcordo);
$cliente = $ofertaAcordo["cliente"][0];
$oferta = $ofertaAcordo["acooferta"][0];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <style>
        input[readonly] {
            background-color: transparent !important;
        }
    </style>
    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body class="ts-noScroll">

    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10">
                        <h4><?php echo $tpNegociacao ?> - <?php echo $oferta['negnom'] ?> - Cliente <?php echo $_GET['clicod'] ?></h4>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="acooferta.php?tpNegociacao=<?php echo $tpNegociacao ?>&codigoCliente=<?php echo $_GET['clicod'] ?>" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>


            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col">
                        Cod. Cliente: <?php echo $cliente['clicod'] ?>
                    </div>
                    <div class="col mx-0 px-0">
                        CPF/CNPJ: <?php echo $cliente['cpfCNPJ'] ?>
                    </div>
                    <div class="col mx-0 px-0">
                        Nome: <?php echo $cliente['clinom'] ?>
                    </div>
                    <div class="col">
                        Fil Cad.: <?php echo $cliente['etbcad'] ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col me-0 pe-0">
                        Campanha: <?php echo $oferta['negnom'] ?>
                    </div>
                    <div class="col-1">
                        Qtd: <?php echo $oferta['qtd'] ?>
                    </div>
                    <div class="col mx-0 px-0">
                        Aberto: <?php echo $oferta['vlr_aberto'] ?>
                    </div>
                    <div class="col mx-0 px-0">
                        Divida: <?php echo $oferta['vlr_divida'] ?>
                    </div>
                    <div class="col">
                        Selecionado: <?php echo $oferta['qtd_selecionado'] ?>
                    </div>
                    <div class="col mx-0 px-0">
                        Sel. aberto: <?php echo $oferta['vlr_selaberto'] ?>
                    </div>
                    <div class="col mx-0 px-0">
                        Sel. total: <?php echo $oferta['vlr_selecionado'] ?>
                    </div>
                </div>
 
                <hr>
                <div class="container-fluid mt-3">
                    <div id="ts-tabs">
                        <div class="tab whiteborder" id="tab-condicoes">Condições</div>
                        <div class="tab" id="tab-contrato">Contratos</div>

                        <div class="line"></div>

                        <div class="tabContent">
                            <h4>Condições</h4>
                            <div class="table mt-2 ts-divTabela60 ts-tableFiltros text-center">
                                <table class="table table-sm table-hover">
                                    <thead class="ts-headertabelafixo">
                                        <tr class="ts-headerTabelaLinhaCima">
                                            <th>ID</th>
                                            <th>Plano</th>
                                            <th></th>
                                            <th>J</th>
                                            <th class="text-end">acordo</th>
                                            <th class="text-end">ent %</th>
                                            <th class="text-end">entrada</th>
                                            <th>parc</th>
                                            <th>venc</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody id='dadosCondicoes' class="fonteCorpo">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tabContent">
                            <h4>Contratos</h4>
                            <div class="table mt-2 ts-divTabela60 ts-tableFiltros text-center">
                                <table class="table table-sm table-hover">
                                    <thead class="ts-headertabelafixo">
                                        <tr class="ts-headerTabelaLinhaCima">
                                            <!-- <th style="width: 40px;">*</th> -->
                                            <th style="width: 40px;">fil</th>
                                            <th class="text-end">contrato</th>
                                            <th style="width: 60px;">mod</th>
                                            <th style="width: 40px;">t</th>
                                            <th class="text-end">aberto</th>
                                            <th class="text-end">divida</th>
                                            <th class="text-end">parc</th>
                                            <th>venc</th>
                                            <th class="text-end">dias</th>
                                            <th class="text-end" style="width: 40px;">par</th>
                                            <th class="text-end" style="width: 40px;">ppg</th>
                                            <th class="text-end" style="width: 40px;">%pg</th>
                                            <th style="width: 60px;"></th>
                                        </tr>
                                    </thead>

                                    <tbody id='dadosContrato' class="fonteCorpo">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal fade bd-example-modal-lg" id="parcelasModal" tabindex="-1"
            aria-labelledby="parcelasModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloparcelas"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table mt-2 ts-divTabela60 ts-tableFiltros text-center">
                            <table class="table table-sm table-hover">
                                <thead class="ts-headertabelafixo">
                                    <tr class="ts-headerTabelaLinhaCima">
                                        <th>parc</th>
                                        <th>Vlr parcela</th>
                                        <th>Vlr Seg. Prestamista</th>
                                        <th>Vlr Total</th>
                                        <th>perc</th>
                                    </tr>
                                </thead>

                                <tbody id='dadosParcelas' class="fonteCorpo">

                                </tbody>
                            </table>
                        </div>
                    </div><!--body-->

                </div>
            </div>
        </div>

    </div>


    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        buscar();

        function buscar() {
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/acooferta.php?operacao=buscarCondicoes',
                data: {
                    ptpnegociacao: '<?php echo $tpNegociacao ?>',
                    clicod: <?php echo $_GET['clicod'] ?>,
                    negcod: <?php echo $_GET['negcod'] ?>
                },
                success: function(msg) {
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        linha = linha + "<tr>";
                       
                        linha = linha + "<td>" + object.placod + "</td>";
                        linha = linha + "<td>" + object.planom + "</td>";
                        linha = linha + "<td>" + (object.perc_desc != "0" ? object.perc_desc + "%Desc " : "") + (object.perc_desc != "0" ? object.perc_acres + "%ac" : "") + "</td>";
                        linha = linha + "<td>" + (object.calc_juro == true ? "S" : "N") + "</td>";
                        linha = linha + "<td class='text-end'>" + object.vlr_acordo + "</td>";
                        linha = linha + "<td class='text-end'>" + formatPorcentage(object.vlr_entrada) + "</td>";
                        linha = linha + "<td class='text-end'>" + parseFloat(object.min_entrada).toFixed(2).replace('.', ',') + "</td>";
                        linha = linha + "<td>" + object.qtd_vezes + "x " + object.vlr_parcela + "</td>";
                        linha = linha + "<td>" + (object.dtvenc1 != "null" ? formatDate(object.dtvenc1) : "") + "</td>";
                        linha = linha + "<td>" + object.dias_max_primeira + "</td>";
                        linha = linha + "<td>" + "<button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#parcelasModal' data-placod='" + object.placod + "' data-planom='" + object.planom + "'><i class='bi bi-eye-fill'></i></button> " + "</td>";


                        linha = linha + "</tr>";
                    }
                    $("#dadosCondicoes").html(linha);
                }
            });
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/acooferta.php?operacao=buscarContratos',
                data: {
                    ptpnegociacao: '<?php echo $tpNegociacao ?>',
                    clicod: <?php echo $_GET['clicod'] ?>,
                    negcod: <?php echo $_GET['negcod'] ?>
                },
                success: function(msg) {
                    //alert(msg)
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.etbcod + "</td>";
                        linha = linha + "<td class='text-end'>" + object.contnum + "</td>";
                        linha = linha + "<td>" + object.modcod + "</td>";
                        linha = linha + "<td>" + object.tpcontrato + "</td>";
                        linha = linha + "<td class='text-end'>" + parseFloat(object.vlr_aberto).toFixed(2).replace(',', '.') + "</td>";
                        linha = linha + "<td class='text-end'>" + parseFloat(object.vlr_divida).toFixed(2).replace(',', '.') + "</td>";
                        linha = linha + "<td class='text-end'>" + parseFloat(object.vlr_parcela).toFixed(2).replace(',', '.') + "</td>";
                        linha = linha + "<td>" + (object.dt_venc != "null" ? formatDate(object.dt_venc) : "") + "</td>";
                        linha = linha + "<td class='text-end'>" + object.dias_atraso + "</td>";
                        linha = linha + "<td class='text-end'>" + object.qtd_parcelas + "</td>";
                        linha = linha + "<td class='text-end'>" + object.qtd_pagas + "</td>";
                        linha = linha + "<td class='text-end'>" + object.perc_pagas + "</td>";


                        linha = linha + "</tr>";
                    }
                    $("#dadosContrato").html(linha);
                }
            });
        }


        $(document).on('click', 'button[data-bs-target="#parcelasModal"]', function() {
            var placod = $(this).attr("data-placod");
            var planom = $(this).attr("data-planom");

            var texto = $("#tituloparcelas");
            texto.html('Parcelas plano: ' + planom);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/acooferta.php?operacao=buscarParcelas',
                data: {
                    ptpnegociacao: '<?php echo $tpNegociacao ?>',
                    clicod: <?php echo $_GET['clicod'] ?>,
                    negcod: <?php echo $_GET['negcod'] ?>,
                    placod: placod
                },
                success: function(msg) {
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.titpar + "</td>";
                        linha = linha + "<td>" + object.vlr_parcela + "</td>";
                        linha = linha + "<td>" + object.segprestamista.toFixed(2) + "</td>";
                        linha = linha + "<td>" + object.totalsegprestamista.toFixed(2) + "</td>";
                        linha = linha + "<td>" + formatPorcentage(object.perc_parcela) + "</td>";

                        linha = linha + "</tr>";
                    }
                    $("#dadosParcelas").html(linha);
                    $('#parcelasModal').modal('show');
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

        function formatPorcentage(number) {
            const formatter = new Intl.NumberFormat('pt-BR', {
                style: 'percent',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
            const formattedNumber = formatter.format(number);
            return formattedNumber;
        }

        window.onload = function() {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'condicoes') {
                showTabsContent(0);
            }
            if (id === 'contrato') {
                showTabsContent(1);
            } else {
                showTabsContent(0);
            }
        }

        document.getElementById('ts-tabs').onclick = function(event) {
            var target = event.target;
            if (target.className.includes('tab')) {
                for (var i = 0; i < tab.length; i++) {
                    if (target == tab[i]) {
                        showTabsContent(i);
                        break;
                    }
                }
            }
        }

        function hideTabsContent(startIndex) {
            for (var i = startIndex; i < tabContent.length; i++) {
                tabContent[i].classList.remove('show');
                tabContent[i].classList.add("hide");
                tab[i].classList.remove('whiteborder');
            }
        }

        function showTabsContent(index) {
            if (tabContent[index].classList.contains('hide')) {
                hideTabsContent(0);
                tab[index].classList.add('whiteborder');
                tabContent[index].classList.remove('hide');
                tabContent[index].classList.add('show');
            }
        }
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>