<?php
// Lucas 12092024
include_once('../header.php');

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

        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-12">
                <h2 class="ts-tituloPrincipal">Serasa Remessas</h2>
            </div>

        </div>

        <div id="ts-tabs">
            <div class="tab whiteborder" id="tab-envios">Envios</div>
            <div class="tab" id="tab-enviados">Enviados</div>

            <div class="line"></div>

            <div class="tabContent">
                <div class="row d-flex align-items-center justify-content-center pt-1">

                    <div class="col-7">
                        <h2 class="ts-tituloPrincipal">Envios</h2>
                    </div>

                    <form class="col-3 d-flex gap-2" id="inserirSerasaCli" method="post">
                        <input type="text" class="form-control ts-input" name="diasdeatraso" placeholder="Dias em Atraso" required>

                        <button type="submit" class="btn btn-primary ">Gerar</button>
                    </form>

                    <div class="col-2 text-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gerarArquivoModal">
                            <i class="bi bi-file-earmark-arrow-up-fill"></i>&#32; Arquivo</button>
                    </div>

                </div>

                <div class="table ts-divTabela70 mt-1">
                    <table class="table table-sm table-hover">
                        <thead class="ts-headertabelafixo">
                            <tr class="ts-headerTabelaLinhaCima">
                                <th>CPF</th>
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>dtenvio</th>
                                <th class="text-end">vlrdivida</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id='dadosEnvios' class="fonteCorpo">

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

                    <div class="col-2">
                        <h2 class="ts-tituloPrincipal">Enviados</h2>
                    </div>

                    <div class="col-10 d-flex gap-2 align-items-end justify-content-end">

                        <div class="col-4 d-flex">
                            <input type="date" class="form-control ts-input" name="dtenvioini" id="dtenvioini" required>
                            <p class="mx-2" style="margin-bottom: -5px;">até</p>
                            <input type="date" class="form-control ts-input" name="dtenviofim" id="dtenviofim" required>
                        </div>

                        <div class="col-1 text-end">
                            <button type="submit" class="btn btn-primary" id="filtrardata">Filtrar</button>
                        </div>
                    </div>

                </div>

                <div class="table ts-divTabela70 mt-1">

                    <table class="table table-sm table-hover">
                        <thead class="ts-headertabelafixo">
                            <tr class="ts-headerTabelaLinhaCima">
                                <th>CPF</th>
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>dtenvio</th>
                                <th class="text-end">vlrdivida</th>
                            </tr>
                        </thead>

                        <tbody id='dadosEnviados' class="fonteCorpo">

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

    <!---- MODAL GERAR ARQUIVO --->
    <div class="modal" id="gerarArquivoModal" tabindex="-1" aria-labelledby="gerarArquivoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerar Arquivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="refreshPage()"></button>
                </div>
                <div class="divform">
                    <div class="modal-body">
                        <form method="post" id="gerarArquivoForm">
                            <div class="row d-none">
                                <div class="col">
                                    <input type="text" class="form-control ts-input" name="gerararquivo">
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col">
                                    <button type="submit" class="btn btn-success">Gerar</button>
                                </div>
                            </div>

                    </div><!--body-->

                    </form>
                </div>
                <div class="divmensagem d-none">
                    <div class="modal-body">
                        <div class="col text-center">
                            <div class="alert alertMesg" role="alert" id="mensagemRelatorio"></div>
                            <div id="linkContainer"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="refreshPage()">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------- EXCLUIR --------->
    <div class="modal" id="excluirSerasaCli" tabindex="-1" aria-labelledby="excluirSerasaCliLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form method="post" id="excluirSerasaCliForm">
                        <div class="row mt-2">
                            <div class="col">
                                <label class="form-label ts-label">Cliente</label>
                                <input type="text" class="form-control ts-input" name="clinom" id="exc_clinom" readonly>
                                <input type="hidden" class="form-control ts-input" name="clicod" id="exc_clicod">
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

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <script>
        window.onload = function() {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'envios') {
                showTabsContent(0);
            }
            if (id === 'enviados') {
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
            textoEnvios.html('Total: ' + 0 + ' | Total Divida: ' + "0,00")

            var textoEnviados = $("#textocontadorEnviados");
            textoEnviados.html('Total: ' + 0 + ' | Total Divida: ' + "0,00");
        });

        // TABELA ENVIOS
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '../database/serasacli.php?operacao=buscar',
            beforeSend: function() {
                        setTimeout(function() {
                            $("#div-loadEnvios").css("display", "block");
                        }, 500);
                    },
            data: {},
            success: function(msg) {
                $("#div-loadEnvios").css("display", "none");
        
                var json = JSON.parse(msg);
                var contadorItem = 0;
                var vlrTotalDivida = 0;
                var linha = "";
                for (var $i = 0; $i < json.length; $i++) {
                    var object = json[$i];
                    contadorItem += 1;
                    vlrTotalDivida += object.vlrdivida;

                    linha = linha + "<tr>";

                    linha = linha + "<td>" + object.ciccgc + "</td>";
                    linha = linha + "<td>" + object.clicod + "</td>";
                    linha = linha + "<td>" + object.clinom + "</td>";
                    linha = linha + "<td>" + formatDate(object.dtenvio) + "</td>";
                    linha = linha + "<td class='text-end'>" + object.vlrdivida.toLocaleString('pt-br', {
                        minimumFractionDigits: 2
                    }) + "</td>";

                    linha = linha + "<td class='text-end pe-2'>";
                    linha = linha + "<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#excluirSerasaCli'";
                    linha = linha + " data-clicod='" + object.clicod + "' ";
                    linha = linha + " data-clinom='" + object.clinom + "' ";
                    linha = linha + "><i class='bi bi-trash'></i></button></td>";

                    linha = linha + "</tr>";
                }
                $("#dadosEnvios").html(linha);
                var textoEnvios = $("#textocontadorEnvios");
                vlrTotalDividaFormatado = vlrTotalDivida.toLocaleString('pt-br', {
                    minimumFractionDigits: 2
                });
                textoEnvios.html('Total: ' + contadorItem + ' | Total Divida: ' + vlrTotalDividaFormatado);
            }
        });

        function buscaEnviados(dtenvioini, dtenviofim) {
            if (dtenvioini == '' || dtenviofim == '') {
                alert("Informar Periodo")
            } else {
                // TABELA ENVIADOS
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: '../database/serasacli.php?operacao=buscar',
                    beforeSend: function() {
                        setTimeout(function() {
                            $("#div-loadEnviados").css("display", "block");
                        }, 500);
                    },
                    data: {
                        dtenvioini: dtenvioini,
                        dtenviofim: dtenviofim
                    },
                    success: function(msg) {
                        $("#div-loadEnviados").css("display", "none");
                    
                        var json = JSON.parse(msg);
                        var contadorItem = 0;
                        var vlrTotalDivida = 0;
                        var linha = "";
                        for (var $i = 0; $i < json.length; $i++) {
                            var object = json[$i];
                            contadorItem += 1;
                            vlrTotalDivida += object.vlrdivida;

                            linha = linha + "<tr>";

                            linha = linha + "<td>" + object.ciccgc + "</td>";
                            linha = linha + "<td>" + object.clicod + "</td>";
                            linha = linha + "<td>" + object.clinom + "</td>";
                            linha = linha + "<td>" + formatDate(object.dtenvio) + "</td>";
                            linha = linha + "<td class='text-end'>" + object.vlrdivida.toLocaleString('pt-br', {
                                minimumFractionDigits: 2
                            }) + "</td>";

                            linha = linha + "</tr>";
                        }
                        $("#dadosEnviados").html(linha);
                        var textoEnviados = $("#textocontadorEnviados");
                        vlrTotalDividaFormatado = vlrTotalDivida.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        });
                        textoEnviados.html('Total: ' + contadorItem + ' | Total Divida: ' + vlrTotalDividaFormatado);
                    }
                });
            }
        }

        $("#filtrardata").click(function() {
            buscaEnviados($("#dtenvioini").val(), $("#dtenviofim").val());
        });


        $("#gerarArquivoForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/serasacli.php?operacao=arquivo",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['status'] == 400) {
                        //alert(json['descricaoStatus'])
                        $('.divform').toggleClass('d-none');
                        $('.divmensagem').toggleClass('d-none');
                        var texto = $("#mensagemRelatorio");
                        texto.html(json['descricaoStatus']);

                        $('.alertMesg').addClass('alert-danger');
                        $('.alertMesg').removeClass('alert-success');
                    } else {
                        let textocomlink = json['descricaoStatus'].split(" ");
                        let link = textocomlink[3].split("/");

                        $('.divform').toggleClass('d-none');
                        $('.divmensagem').toggleClass('d-none');
                        var texto = $("#mensagemRelatorio");
                        texto.html(json['descricaoStatus']);

                        var a = $('<a></a>').attr('href', "/relatorios/" + link[3]).text('Clique aqui para baixar');
                        $('#linkContainer').html(a);

                        $('.alertMesg').addClass('alert-success');
                        $('.alertMesg').removeClass('alert-danger');

                    }


                }
            });
        });

        // MODAL EXCLUIR
        $(document).on('click', 'button[data-bs-target="#excluirSerasaCli"]', function() {
            var clicod = $(this).attr("data-clicod");
            var clinom = $(this).attr("data-clinom");

            $('#exc_clicod').val(clicod);
            $('#exc_clinom').val(clinom);

            $('#excluirSerasaCli').modal('show');

        });

        $("#inserirSerasaCli").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/serasacli.php?operacao=inserir",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: refreshPage
            });
        });

        $("#excluirSerasaCliForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/serasacli.php?operacao=excluir",
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