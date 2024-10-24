<?php
include_once '../header.php';

$dtproc = null;
$etbcod = null;
$dtini = null;
$dtfim = null;
if (isset($_SESSION['filtro_contrassin'])) {
  $filtroEntrada = $_SESSION['filtro_contrassin'];
  $dtproc = $filtroEntrada['dtproc'];
  $etbcod = $filtroEntrada['etbcod'];
  $dtini = $filtroEntrada['dtini'];
  $dtfim = $filtroEntrada['dtfim'];
}

$contrassin = "Sim"; //usando no include de zoomEstab
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">

        <div class="row ">
            <!--<BR> MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!-- <BR>  BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-5 col-lg-5" id="filtroh6">
                <h2 class="ts-tituloPrincipal">Assinatura</h2>
                <h6 style="font-size: 10px;font-style:italic;text-align:left;"></h6>
            </div>

            <div class="col-3 col-lg-3">
                <div class="input-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#periodoModal"><i class="bi bi-calendar3"></i></button>
                    <a onClick="naoproc()" role=" button" class="ms-4 btn btn-sm btn-info">Não Processados</a>
                    <button id="exportCsvButton" class="ms-4 btn btn-success">CSV</button>
                </div>
            </div>

            <div class="col-4 col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="contnum" placeholder="Buscar Contrato">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i
                            class="bi bi-search"></i></button>
                </div>
            </div>

        </div>

        <!-- botão de modais que ficam escondidos -->
        <button type="button" class="btn btn-success d-none" data-bs-toggle="modal" data-bs-target="#zoomEstabModal" id="abreEstabModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th class="col-2">Filial</th>
                        <th>Contrato</th>
                        <th>Cliente</th>
                        <th>Nome</th>
                        <th>Cpf/Cnpj</th>
                        <th class="col-3">ID Biometria</th>
                        <th>Emissão</th>
                        <th>dtproc</th>
                        <th>Valor</th>
                        <th>idNeurotech</th>
                        <th colspan="2">Ação</th>
                    </tr>
                    <tr class="ts-headerTabelaLinhaBaixo">
                        <th>
                            <div class="input-group">
                                <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela mt-1 input-etbcod" placeholder="Digite Filial [ENTER]"
                                value="<?php echo $etbcod !== null ? $etbcod : null ?>" name="etbcod" id="etbcod" required>
                                <button class="btn ts-input btn-outline-secondary ts-acionaZoomEstab" type="button" id="button-etbcod" title="Fixo"><i class="bi bi-search"></i></button>
                            </div>
                        </th>
                        <th></th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Cliente [ENTER]"
                                name="clicod" id="clicod" required>
                        </th>
                        <th></th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Cpf/Cnpj [ENTER]"
                                name="cpfcnpj" id="cpfcnpj" required>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>
        <div class="fixed-bottom d-flex justify-content-between align-items-center" style="padding: 10px; background-color: #f8f9fa;">
            <div class="col-5">
                <h6 id="textocontador" style="color: #13216A;"></h6>
            </div>
            <div class="col-3">
                <button id="prevPage" class="btn btn-primary mr-2" style="display:none;">Anterior</button>
                <button id="nextPage" class="btn btn-primary" style="display:none;">Proximo</button>
            </div>
            <div class="col-6">
            </div>
        </div>
    </div>

    
    <!--------- FILTRO PERIODO --------->
    <?php include_once 'modal_periodo.php' ?>

    <!--------- MODAIS DE ZOOM --------->
    <?php include ROOT . '/cadastros/zoom/estab.php'; ?>

    <div class="modal" id="csvModal" tabindex="-1" aria-labelledby="csvModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CSV Assinatura</h5>
                </div>
                <div class="divmensagem">
                    <div class="modal-body">
                        <div class="col text-center">
                            <div class="alert alertMesg" role="alert" id="mensagemCSV"></div>
                            <div id="linkContainer"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onClick="fechaModal()" class="btn btn-secondary">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        var qtdParam = 10;
        var plinha = null;

        buscar($("#contnum").val(), $("#dtproc").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);

        $(document).ready(function() {
            var texto = $("#textocontador");
            texto.html('total: ' + 0);
        });

        function naoproc() {
            var dtproc = $("#dtproc");
            buscar(null, null, $("#etbcod").val(), null, null, $("#clicod").val(), $("#cpfcnpj").val(), null, null);

            $('#dtproc').val("");
            $('#dtini').val("");
            $('#dtfim').val("");
        }

        function limparPeriodo() {
            buscar($("#contnum").val(), null,$("#etbcod").val(), null, null, null, null, null, null);
            $('#dtproc').val("");
            $('#dtini').val("");
            $('#dtfim').val("");
            $('#periodoModal').modal('hide');
        };

        function buscar(contnum, dtproc, etbcod, dtini, dtfim, clicod, cpfcnpj, linhaParam, botao) {
            //alert (buscar);
            var h6Element = $("#filtroh6 h6");
            var text = "";
            if (dtproc !== null && dtproc !== '') {
                text += "Data de Processamento = " + formatarData(dtproc);
            } 
            if (dtini !== null && dtini !== '') {
                text += "Periodo de " + formatarData(dtini);
            }
            if (dtfim !== null && dtfim !== '') {
                if (text) text += " até ";
                text += formatarData(dtfim);
            }

            h6Element.html(text);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/crediariocontrato.php?operacao=filtrar',
                beforeSend: function () {
                    $("#dados").html("Carregando...");
                },
                data: {
                    contnum: contnum,
                    dtproc: dtproc,
                    etbcod: etbcod,
                    dtini: dtini,
                    dtfim: dtfim,
                    clicod: clicod,
                    cpfcnpj: cpfcnpj,
                    linha: linhaParam,
                    qtd: qtdParam,
                    botao: botao
                },
                success: function (msg) {
                    //alert("segundo alert: " + msg);
                    //console.log(msg);
                    var json = JSON.parse(msg);
                    if (json === null) {
                        $("#dadosEstab").html("Erro ao buscar");
                        return;
                    }
                    if (json.status === 400) {
                        $("#dados").html("Nenhum Contrato foi encontrado");
                        $("#nextPage").hide();
                        return;
                    }
                    var contrassin = json.contrassin; 
                    var linha = "";
                    for (var $i = 0; $i < contrassin.length; $i++) {
                        var object = contrassin[$i];

                        linha = linha + "<tr>";

                        linha = linha + "<td>" + object.etbcod + "</td>";
                        linha = linha + "<td>" + object.contnum + "</td>";
                        linha = linha + "<td>" + object.clicod + "</td>";
                        linha = linha + "<td>" + object.nomeCliente + "</td>";
                        linha = linha + "<td>" + object.cpfcnpj + "</td>";
                        linha = linha + "<td>" + object.idBiometria + "</td>";
                        linha = linha + "<td>" + (object.dtinclu ? formatarData(object.dtinclu) : "--") + "</td>";
                        linha = linha + "<td>" + (object.dtproc ? formatarData(object.dtproc) : "--") + "</td>";
                        linha = linha + "<td>" + parseFloat(object.vltotal).toFixed(2).replace('.', ',') + "</td>";
                        linha = linha + "<td>" + object.idneurotech + "</td>";
                        linha = linha + "<td>" + "<a class='btn btn-primary btn-sm' href='contratos.php?numeroContrato=" + object.contnum + "' role='button'><i class='bi bi-eye-fill'></i></a>";
                        if (!object.dtproc) {
                            linha = linha + "<button type='button' class='btn btn-warning btn-sm processar-btn' data-contnum='" + object.contnum + "' title='Processar Assinatura'><i class='bi bi-check-circle-fill'></i></button>";
                        }
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);

                    $("#prevPage, #nextPage").show();
                    
                    if (json.total[0].linha == 1) {
                        plinha = null;
                        $("#prevPage").hide();
                    }
                    if (contrassin.length < qtdParam) {
                        $("#nextPage").hide();
                    }

                    plinha = json.total[0].linha + qtdParam;

                    if (linhaParam == null) {
                        $("#prevPage").hide();

                        var totalData = json.total[0]; 
                        var texto = $("#textocontador");
                        var contadorVlTotal = parseFloat(totalData.vltotal);
                        var VlTotal = contadorVlTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                        texto.html('Total: ' + totalData.qtdRegistros + ' | Valor Cobrado: ' + VlTotal);
                    }
                }
            });
        }

        document.getElementById("buscar").addEventListener("click",function () {
            buscar($("#contnum").val(), $("#dtproc").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);

        })
        $("#etbcod").change(function() {
            buscar($("#contnum").val(), $("#dtproc").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);

        });
        $(document).ready(function() {
            $("#filtrarButton").click(function() {
                var dtproc = $("#dtproc");
                
                if (dtproc.is(":disabled")) {
                    buscar($("#contnum").val(), null,$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);
                    $('#dtproc').val("");
                } 
                else {
                    buscar($("#contnum").val(), $("#dtproc").val(),$("#etbcod").val(), null, null, $("#clicod").val(), $("#cpfcnpj").val(), null, null);
                    $('#dtini').val("");
                    $('#dtfim').val("");
                } 
                $('#periodoModal').modal('hide');
            });
        });    
        document.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                buscar($("#contnum").val(), $("#dtproc").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);

            }
        });
        
        $("#prevPage").click(function () {
            buscar($("#contnum").val(), $("#dtproc").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), plinha, "prev");
        });
        
        $("#nextPage").click(function () {
            buscar($("#contnum").val(), $("#dtproc").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), plinha, "next");
        });
        
        $(document).on('click', '.processar-btn', function () {
            $('body').css('cursor', 'progress');
            var contnum = $(this).attr("data-contnum");

            $.ajax({
                method: "POST",
                dataType: 'json',
                url: "../database/crediariocontrato.php?operacao=processarAssinatura",
                data: { contnum: contnum },
                success: function (msg) {
                    //console.log(msg);
                    $('body').css('cursor', 'default');
                    if (msg.status === 200) {
                        window.location.reload();
                    }
                    if (msg.status === 400) {
                        alert(msg.retorno);
                        window.location.reload();
                    }
                }
            });
        });

        document.getElementById("exportCsvButton").addEventListener("click", function() {
            $('#csvModal').modal('show');
            var texto = $("#mensagemCSV");
            texto.html("Gerando CSV...");

            var pcontnum = $("#contnum").val(); 
            var pdtproc = $("#dtproc").val();
            var petbcod = $("#etbcod").val();
            var pdtini = $("#dtini").val();
            var pdtfim = $("#dtfim").val();
            var pclicod = $("#clicod").val();
            var pcpfcnpj = $("#cpfcnpj").val(); 

            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: "<?php echo URLROOT ?>/crediario/database/crediariocontrato.php?operacao=csvContrassin",
                data: {
                    contnum: pcontnum,
                    dtproc: pdtproc,
                    etbcod: petbcod,
                    dtini: pdtini,
                    dtfim: pdtfim,
                    clicod: pclicod,
                    cpfcnpj: pcpfcnpj
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['status'] == 400) {
                        //alert(json['descricaoStatus'])
                        var texto = $("#mensagemCSV");
                        texto.html(json['descricaoStatus']);
                        $('.alertMesg').addClass('alert-danger');
                        $('.alertMesg').removeClass('alert-success');
                    } if (json['status'] == 200) {
                        let textocomlink = json['descricaoStatus'].split(" ");
                        let link = textocomlink[3].split("/");
                        var texto = $("#mensagemCSV");
                        texto.html(json['descricaoStatus']);
                        var a = $('<a></a>').attr('href', "/relatorios/" + link[3]).text('Clique aqui para baixar');
                        $('#linkContainer').html(a);
                        $('.alertMesg').addClass('alert-success');
                        $('.alertMesg').removeClass('alert-danger');
                    }
                }
            });
        });

        function fechaModal() {
            $('.alertMesg').removeClass('alert-danger alert-success').html("");
            $('#linkContainer').html("");
            $('#csvModal').modal('hide');
        }

        function formatarData(data) {
            var parts = data.split('-');
            var year = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10) - 1;
            var day = parseInt(parts[2], 10);

            var d = new Date(Date.UTC(year, month, day));

            var dia = d.getUTCDate().toString().padStart(2, '0');
            var mes = (d.getUTCMonth() + 1).toString().padStart(2, '0');
            var ano = d.getUTCFullYear();

            return dia + '/' + mes + '/' + ano;
        }

        // DATA\SELECT - DTI
        $("#button-dti").click(function() {
            $(".input-dtproc").toggleClass("d-none");
            $(".input-dtini").toggleClass("d-none");
            $(".input-dtfim").toggleClass("d-none");

            var elemento = document.getElementById("dtproc");
            var classe = elemento.getAttribute("class");
            //alert(classe.lastIndexOf("d-none"))
            if (classe[26] == "d") {
                $("#button-dti").prop("title", "Data Processamento");
                $(".input-dtproc").prop("disabled", true);
                $(".input-dtini").prop("disabled", false);
                $(".input-dtfim").prop("disabled", false);
                $(".input-dtproc").prop("required", false);
                $(".input-dtini").prop("required", true);
                $(".input-dtfim").prop("required", true);
            } else {
                $("#button-dti").prop("title", "Data por Periodo");
                $(".input-dtproc").prop("disabled", false);
                $(".input-dtini").prop("disabled", true);
                $(".input-dtfim").prop("disabled", true);
                $(".input-dtproc").prop("required", true);
                $(".input-dtini").prop("required", false);
                $(".input-dtfim").prop("required", false);
            }
        });

        
        $(document).on('click', '.ts-click', function () {
            var etbcod = $(this).attr("data-etbcod");
            buscar($("#contnum").val(), $("#dtproc").val(),etbcod, $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);
            $('#etbcod').val(etbcod);
            $('#zoomEstabModal').modal('hide');
        });
    </script>
    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>