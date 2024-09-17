<?php
// Lucas 13092024
include_once('../header.php');
include_once('../database/aoacordo.php');

$Tipo = $_GET['Tipo'];
$IDAcordo = $_GET['IDAcordo'];
$acordos = buscaAcordo($Tipo, $IDAcordo);
$acordo = $acordos[0];
$id_recid = $acordo['id_recid'];

$DtAcordo = ($acordo['DtAcordo'] != null ? date('d/m/Y', strtotime($acordo['DtAcordo'])) : "");
$DtEfetiva = ($acordo['DtEfetiva'] != null ? date('d/m/Y', strtotime($acordo['DtEfetiva'])) : "");
$DtVinculo = ($acordo['DtVinculo'] != null ? date('d/m/Y', strtotime($acordo['DtVinculo'])) : "");

?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>


<body>

    <div class="container-fluid">
        <div class="row">
            <!--<BR> MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!--<BR> MENSAGENS/ALERTAS -->
        </div>

        <div class="row mt-2"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-10 d-flex">
     
                <a href="aoacordo.php?Tipo=<?php echo $Tipo ?>" style="text-decoration: none;">
                    <h6 class="ts-tituloSecundaria">Gestão de Acordos</h6>
                </a> &nbsp; / &nbsp;
                <h2 class="ts-tituloPrincipal"><?php echo $Tipo ?></h2>

            </div>
            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>
        <hr>
        <div class="table mt-2 ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>ID Acordo</th>
                        <th>Estab</th>
                        <th>Cli/For</th>
                        <th>Situacao</th>
                        <th>Dt Acordo</th>
                        <th>Hora</th>
                        <th>Dt Efetivacao</th>
                        <th>Hr</th>
                        <th>Vlr ori</th>
                        <th>Vlr Acordo</th>
                        <th>DtVincula</th>
                        <th>Tipo</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">
                    <tr>
                        <td><?php echo $acordo['IDAcordo'] ?></td>
                        <td><?php echo $acordo['etbcod'] ?></td>
                        <td><?php echo $acordo['CliFor'] ?></td>
                        <td><?php echo $acordo['Situacao'] ?></td>
                        <td><?php echo $DtAcordo ?></td>
                        <td><?php echo $acordo['HrAcordo'] ?></td>
                        <td><?php echo $DtEfetiva ?></td>
                        <td><?php echo $acordo['HrEfetiva'] ?></td>
                        <td><?php echo $acordo['VlOriginal'] ?></td>
                        <td><?php echo $acordo['VlAcordo'] ?></td>
                        <td><?php echo $DtVinculo ?></td>
                        <td><?php echo $acordo['Tipo'] ?></td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div id="ts-tabs" class="mt-2">
            <div class="tab whiteborder" id="tab-origem">Contratos Origem</div>
            <div class="tab" id="tab-parcela" onclick="buscaParcela()">Parcelas Acordo</div>

            <div class="line"></div>

            <div class="tabContent">
                <div class="row d-flex align-items-center justify-content-center pt-1">

                    <div class="col-12">
                        <h2 class="ts-tituloPrincipal">Contratos Origem</h2>
                    </div>
                </div>

                <div class="table ts-divTabela60 mt-1">
                    <table class="table table-sm table-hover">
                        <thead class="ts-headertabelafixo">
                            <tr class="ts-headerTabelaLinhaCima">
                                <th>Contrato</th>
                                <th>Pc</th>
                                <th>vlr ori</th>
                                <th>juros</th>
                                <th>divida</th>
                                <th>Boleto</th>
                                <th>Envio</th>
                                <th>Sit</th>
                            </tr>
                        </thead>

                        <tbody id='dadosOrigem' class="fonteCorpo">

                        </tbody>
                    </table>
                </div>

                <h6 class="fixed-bottom" id="textocontadorEnvios" style="color: #13216A;"></h6>
                <!-- div de loading -->
                <div class="text-center" id="div-loadEnvios" style="margin-top: -200px; display: none;">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
            </div>

            <div class="tabContent">
                <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

                    <div class="col-12">
                        <h2 class="ts-tituloPrincipal">Parcelas Acordo</h2>
                    </div>

                </div>

                <div class="table ts-divTabela60 mt-1">

                    <table class="table table-sm table-hover">
                        <thead class="ts-headertabelafixo">
                            <tr class="ts-headerTabelaLinhaCima">
                                <th>Par</th>
                                <th>Venc</th>
                                <th>Vl Acordo</th>
                                <th>Contrato</th>
                                <th>Dt Baixa</th>
                                <th>Sit</th>
                                <th>Boleto</th>
                                <th>Envio</th>
                                <th>Sit</th>
                            </tr>
                        </thead>

                        <tbody id='dadosParcela' class="fonteCorpo">

                        </tbody>
                    </table>
                </div>

                <h6 class="fixed-bottom" id="textocontadorEnviados" style="color: #13216A;"></h6>
                <!-- div de loading -->
                <div class="text-center" id="div-loadEnviados" style="margin-top: -200px; display: none;">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <script>
        window.onload = function() {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'origem') {
                showTabsContent(0);
            }
            if (id === 'parcela') {
                showTabsContent(1);
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

        $(document).ready(function() {
            var textoEnvios = $("#textocontadorEnvios");
            textoEnvios.html('Total: ' + 0)

            var textoEnviados = $("#textocontadorEnviados");
            textoEnviados.html('Total: ' + 0);
        });

        // TABELA ORIGEM
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '../database/aoacorigem.php?operacao=buscar',
            beforeSend: function() {
                setTimeout(function() {
                    $("#div-loadEnvios").css("display", "block");
                }, 500);
            },
            data: {
                id_recid: '<?php echo $id_recid ?>'
            },
            success: function(msg) {
                $("#div-loadEnvios").css("display", "none");

                var json = JSON.parse(msg);
                var contadorItem = 0;
                var linha = "";
                for (var $i = 0; $i < json.length; $i++) {
                    var object = json[$i];
                    contadorItem += 1;

                    linha = linha + "<tr>";

                    linha = linha + "<td>" + object.contnum + "</td>";
                    linha = linha + "<td>" + object.titpar + "</td>";
                    linha = linha + "<td>" + object.vlcob + "</td>";
                    linha = linha + "<td>" + object.vljur + "</td>";
                    linha = linha + "<td>" + object.vltot + "</td>";
                    linha = linha + "<td>" + object.nossonumero + "</td>";
                    linha = linha + "<td>" + (object.dtenvio != "null" ? formatDate(object.dtenvio) : "") + "</td>";
                    linha = linha + "<td>" + object.situacao + "</td>";

                }
                $("#dadosOrigem").html(linha);
                var textoEnvios = $("#textocontadorEnvios");
                textoEnvios.html('Total: ' + contadorItem);
            }
        });

        function buscaParcela() {
            // TABELA PARCELA
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/aoacparcela.php?operacao=buscar',
                beforeSend: function() {
                    setTimeout(function() {
                        $("#div-loadEnviados").css("display", "block");
                    }, 500);
                },
                data: {
                    id_recid: '<?php echo $id_recid ?>'
                },
                success: function(msg) {
                    $("#div-loadEnviados").css("display", "none");

                    var json = JSON.parse(msg);
                    var contadorItem = 0;
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        contadorItem += 1;

                        linha = linha + "<tr>";

                        linha = linha + "<td>" + object.parcela + "</td>";
                        linha = linha + "<td>" + (object.dtvencimento != "null" ? formatDate(object.dtvencimento) : "") + "</td>";
                        linha = linha + "<td>" + object.vlcobrado + "</td>";
                        linha = linha + "<td>" + object.contnum + "</td>";
                        linha = linha + "<td>" + (object.dtbaixa != "null" ? formatDate(object.dtbaixa) : "") + "</td>";
                        linha = linha + "<td>" + object.situacao + "</td>";
                        linha = linha + "<td>" + object.nossonumero + "</td>";
                        linha = linha + "<td>" + (object.bol_situacao != "null" ? formatDate(object.bol_situacao) : "") + "</td>";
                        linha = linha + "<td>" + object.situacao + "</td>";

                        linha = linha + "</tr>";
                    }
                    $("#dadosParcela").html(linha);
                    var textoEnviados = $("#textocontadorEnviados");
                    textoEnviados.html('Total: ' + contadorItem);
                }
            });
        }

     
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
    </script>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>