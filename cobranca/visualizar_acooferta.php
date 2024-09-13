<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 27022023 13:51 - ajustado direcionamento para consulta de contrato
// gabriel 23022023 09:50

include_once '../header.php';
include_once '../database/acooferta.php';

$ofertaAcordo = buscaOfertaAcordoOnline("ACORDO ONLINE", $_GET['clicod'], $_GET['negcod']);
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
                        <h4>ACORDO ONLINE - <?php echo $oferta['negnom'] ?> - Cliente <?php echo $_GET['clicod'] ?></h4>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="acooferta.php?codigoCliente=<?php echo $_GET['clicod'] ?>" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>


            <div class="container-fluid">
            <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $oferta['negcod'] ?>" hidden>
                <div class="row mt-2">
                    <div class="col-2 d-flex align-items-center">
                        <div class="form-group">
                            <label>Cod.&nbsp;Cliente&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $cliente['clicod'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>CPF/CNPJ&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $cliente['cpfCNPJ'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Nome&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $cliente['clinom'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <div class="form-group">
                            <label>Fil&nbsp;Cad.&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $cliente['etbcad'] ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3 d-flex align-items-center">
                        <div class="form-group">
                            <label>Campanha&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $oferta['negnom'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Qtd&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $oferta['qtd'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Aberto&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $oferta['vlr_aberto'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Divida&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $oferta['vlr_divida'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Selecionado&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $oferta['qtd_selecionado'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Sel.&nbsp;aberto&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $oferta['vlr_selaberto'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Sel.&nbsp;total&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-inputSemBorda" value="<?php echo $oferta['vlr_selecionado'] ?>" readonly>
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
                            <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
                                <table class="table table-sm table-hover">
                                    <thead class="ts-headertabelafixo">
                                        <tr class="ts-headerTabelaLinhaCima">
                                            <th style="width: 40px;">ID</th>
                                            <th class="text-start">Plano</th>
                                            <th style="width: 60px;">J</th>
                                            <th>acordo</th>
                                            <th>ent %</th>
                                            <th>entrada</th>
                                            <th>parc</th>
                                            <th>venc</th>
                                            <th style="width: 60px;"></th>
                                        </tr>
                                    </thead>

                                    <tbody id='dadosCondicoes' class="fonteCorpo">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tabContent">
                            <h4>Condições</h4>
                            <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
                                <table class="table table-sm table-hover">
                                    <thead class="ts-headertabelafixo">
                                        <tr class="ts-headerTabelaLinhaCima">
                                            <th style="width: 40px;">*</th>
                                            <th style="width: 40px;">fil</th>
                                            <th class="text-start">contrato</th>
                                            <th style="width: 60px;">mod</th>
                                            <th style="width: 40px;">t</th>
                                            <th>aberto</th>
                                            <th>divida</th>
                                            <th>parc</th>
                                            <th>venc</th>
                                            <th>dias</th>
                                            <th style="width: 40px;">par</th>
                                            <th style="width: 40px;">ppg</th>
                                            <th style="width: 40px;">%pg</th>
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
                    ptpnegociacao : "ACORDO ONLINE",
                    clicod : <?php echo $_GET['clicod'] ?>
                },
                success: function(msg) {
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        linha = linha + "<tr>"; /*
                        linha = linha + "<td>" + object.negcod + "</td>";
                        linha = linha + "<td class='text-start'>" + object.negnom + "</td>";
                        linha = linha + "<td class='text-start'>" + object.qtd + "</td>";
                        linha = linha + "<td class='text-start'>" + object.vlr_aberto + "</td>";
                        linha = linha + "<td class='text-start'>" + object.vlr_divida + "</td>";
                        linha = linha + "<td class='text-start'>" + object.qtd_selecionado + "</td>";
                        linha = linha + "<td class='text-start'>" + object.vlr_selaberto + "</td>";
                        linha = linha + "<td class='text-start'>" + object.vlr_selecionado + "</td>";
                        linha = linha + "<td><a class='btn btn-info btn-sm ms-1' href='visualizar_acooferta.php?clicod=" + <?php echo $_POST['codigoCliente'] ?> + "' role='button'><i class='bi bi-eye'></i></a>";
                        linha = linha + "</td>"; */

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
                    negcod : <?php echo $_GET['negcod'] ?>
                },
                success: function(msg) {
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        linha = linha + "<tr>"; /*
                        linha = linha + "<td>" + object.negcod + "</td>";
                        linha = linha + "<td class='text-start'>" + object.negnom + "</td>";
                        linha = linha + "<td class='text-start'>" + object.qtd + "</td>";
                        linha = linha + "<td class='text-start'>" + object.vlr_aberto + "</td>";
                        linha = linha + "<td class='text-start'>" + object.vlr_divida + "</td>";
                        linha = linha + "<td class='text-start'>" + object.qtd_selecionado + "</td>";
                        linha = linha + "<td class='text-start'>" + object.vlr_selaberto + "</td>";
                        linha = linha + "<td class='text-start'>" + object.vlr_selecionado + "</td>";
                        linha = linha + "<td><a class='btn btn-info btn-sm ms-1' href='visualizar_acooferta.php?clicod=" + <?php echo $_POST['codigoCliente'] ?> + "' role='button'><i class='bi bi-eye'></i></a>";
                        linha = linha + "</td>"; */

                        linha = linha + "</tr>";
                    }
                    $("#dadosContrato").html(linha);
                }
            });
        } 








        window.onload = function () {
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

        document.getElementById('ts-tabs').onclick = function (event) {
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