<?php
include_once '../header.php';

$boletavel = true;
$dtbol = null;
$contnum = null;
$etbcod = null;
$dtini = null;
$dtfim = null;
if (isset($_SESSION['filtro_boletagem'])) {
  $filtroEntrada = $_SESSION['filtro_boletagem'];
  $boletavel = filter_var($filtroEntrada['boletavel'], FILTER_VALIDATE_BOOLEAN);
  $dtbol = $filtroEntrada['dtbol'];
  $contnum = $filtroEntrada['contnum'];
  $etbcod = $filtroEntrada['etbcod'];
  $dtini = $filtroEntrada['dtini'];
  $dtfim = $filtroEntrada['dtfim'];
}
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

            <div class="col-4 col-lg-4" id="filtroh6">
                <h2 class="ts-tituloPrincipal">Consulta Boletagem</h2>
                <h6 style="font-size: 10px;font-style:italic;text-align:left;"></h6>
            </div>

            <div class="col-4 col-lg-4">
                <div class="input-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#periodoModal"><i class="bi bi-calendar3"></i></button>
                    <a onClick="naobolet()" role=" button" class="ms-4 btn btn-sm btn-info">Não Boletados</a>
                    <div class="ms-4 mt-1 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="boletavel" id="boletavel" <?php echo $boletavel === true ? 'checked' : ''; ?>>
                        <label class="form-check-label">Boletavel</label>
                    </div>
                    <button id="exportCsvButton" class="ms-4 btn btn-success">CSV</button>
                </div>
            </div>

            <div class="col-4 col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="contnum" placeholder="Buscar Contrato">
                    <button class="btn btn-primary rounded" type="button" id="buscarContrato"><i
                            class="bi bi-search"></i></button>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th class="col-2">Filial</th>
                        <th>Contrato</th>
                        <th>Cliente</th>
                        <th>Cpf/Cnpj</th>
                        <th class="col-2">ID Biometria</th>
                        <th>Emissão</th>
                        <th>Boletavel</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>idNeurotech</th>
                        <th colspan="2">Ação</th>
                    </tr>
                    <tr class="ts-headerTabelaLinhaBaixo">
                        <th>
                            <div class="input-group">
                                <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela mt-1 input-etbcod" placeholder="Filial [ENTER]"
                                value="<?php echo $etbcod !== null ? $etbcod : null ?>" name="etbcod" id="etbcod" required>
                                <button class="btn ts-input btn-outline-secondary ts-acionaZoomEstab" type="button" id="button-etbcod" title="Fixo"><i class="bi bi-search"></i></button>
                            </div>
                        </th>
                        <th></th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Cliente [ENTER]"
                                name="clicod" id="clicod" required>
                        </th>
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
                        <th></th>
                        <th></th>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>
        <div class="fixed-bottom d-flex justify-content-between align-items-center" style="padding: 10px; background-color: #f8f9fa;">
            <h6 id="textocontador" style="color: #13216A; margin-right: auto;"></h6>
            <div class="d-flex justify-content-center w-100">
                <button id="prevPage" class="btn btn-primary mr-2" style="display:none;">Anterior</button>
                <button id="nextPage" class="btn btn-primary" style="display:none;">Proximo</button>
            </div>
        </div>

    </div>

    <!--------- FILTRO PERIODO --------->
    <div class="modal" id="periodoModal" tabindex="-1"
        aria-labelledby="periodoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Filtro Periodo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="post">
                <div class="row">
                <div class="form-group col">
                    <div class="row">
                    <div class="col-1">
                    </div>
                    <div class="col input-dtbol">
                        <label>Dt de Boletagem</label>
                    </div>
                    <div class="col d-none input-dtini">
                        <label>Emissão De</label>
                    </div>
                    <div class="col d-none input-dtfim">
                        <label>Até</label>
                    </div>
                    </div>
                    <div class="input-group mb-2">
                        <button class="btn btn-outline-secondary" type="button" id="button-dti" title="Fixo"><i class="bi bi-arrow-repeat"></i></button>
                        <input type="date" class="form-control input-dtbol" value="<?php echo $dtbol != null ? $dtbol : null?>" name="dtbol" id="dtbol" required>
                        <input type="date" class="form-control d-none input-dtini" value="<?php echo $dtini != null ? $dtini : null?>" name="dtini" id="dtini" disabled>
                        <input type="date" class="form-control d-none input-dtfim" value="<?php echo $dtfim != null ? $dtfim : null?>" name="dtfim" id="dtfim" disabled>
                    </div>
                </div>
                </div>
                </div>
                <div class="modal-footer border-0">
                <div class="col-sm text-start">
                    <button type="button" class="btn btn-primary" onClick="limparPeriodo()">Limpar</button>
                </div>
                <div class="col-sm text-end">
                    <button type="button" class="btn btn-success" id="filtrarButton" data-dismiss="modal">Filtrar</button>
                </div>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="modal" id="csvModal" tabindex="-1" aria-labelledby="csvModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CSV Boletagem</h5>
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

    
    <?php include_once ROOT . "/cadastros/zoom/estab.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        var qtdParam = 10;
        var prilinha = null;
        var ultlinha = null;

        buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);

        $(document).ready(function() {
            var texto = $("#textocontador");
            texto.html('total: ' + 0);
        });

        function naobolet() {
            var dtbol = $("#dtbol");
                
            if (dtbol.is(":disabled")) {
                buscar(null, null, $("#etbcod").val(), null, null, $("#clicod").val(), $("#cpfcnpj").val(), null, null);
            } else {
                buscar(null, null, $("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);
            }
            $('#dtbol').val("");
        }

        function limparPeriodo() {
            buscar($("#contnum").val(), null,$("#etbcod").val(), null, null, null, null);
            $('#dtbol').val("");
            $('#dtini').val("");
            $('#dtfim').val("");
            $('#periodoModal').modal('hide');
        };

        function buscar(contnum, dtbol, etbcod, dtini, dtfim, clicod, cpfcnpj, linhaParam, botao) {
            var boletavel = $("#boletavel").is(':checked');
            //alert (buscar);
            var h6Element = $("#filtroh6 h6");
            var text = "";
            if (dtbol !== null && dtbol !== '') {
                text += "Data de Boletagem = " + formatarData(dtbol);
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
                url: '../database/boletos.php?operacao=buscarBoletagem',
                beforeSend: function () {
                    $("#dados").html("Carregando...");
                },
                data: {
                    boletavel: boletavel,
                    dtbol: dtbol,
                    contnum: contnum,
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
                    var contrassin = json.contrassin; 
                    var linha = "";
                    for (var $i = 0; $i < contrassin.length; $i++) {
                        var object = contrassin[$i];

                        linha = linha + "<tr>";
                        
                        linha = linha + "<td>" + object.etbcod + "</td>";
                        linha = linha + "<td>" + object.contnum + "</td>";
                        linha = linha + "<td>" + object.clicod + "</td>";
                        linha = linha + "<td>" + object.cpfcnpj + "</td>";
                        linha = linha + "<td>" + object.idBiometria + "</td>";
                        linha = linha + "<td>" + (object.dtinclu ? formatarData(object.dtinclu) : "--") + "</td>";
                        linha = linha + "<td>" + (object.boletavel ? "Sim" : "Não") + "</td>";
                        linha = linha + "<td>" + (object.dtboletagem ? formatarData(object.dtboletagem) : "--") + "</td>";
                        linha = linha + "<td>" + parseFloat(object.vltotal).toFixed(2).replace('.', ',') + "</td>";
                        linha = linha + "<td>" + object.idneurotech + "</td>";
                        linha = linha + "<td>" + "<a class='btn btn-primary btn-sm' href='../clientes/contratos.php?numeroContrato=" + object.contnum + "' role='button'><i class='bi bi-eye-fill'></i></a>";
                        if (!object.dtboletagem) {
                            linha = linha + "<button type='button' class='btn btn-warning btn-sm boletar-btn' data-contnum='" + object.contnum + "' title='Emitir Boleto'><i class='bi bi-check-circle-fill'></i></button>";
                        }
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);

                    $("#prevPage, #nextPage").show();
                    if (contrassin.length < qtdParam) {
                        $("#nextPage").hide();
                    }
                    
                    if (contrassin.length > 0) {
                        prilinha = contrassin[0].linha;
                        ultlinha = contrassin[contrassin.length - 1].linha;
                    }
                    if (prilinha == 1) {
                        prilinha = null;
                        $("#prevPage").hide();
                    }

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

        document.getElementById("buscarContrato").addEventListener("click",function () {
            buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);

        })
        $("#etbcod").change(function() {
            buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);

        });
        $("#boletavel").change(function() {
            buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);

        });
        $(document).ready(function() {
            $("#filtrarButton").click(function() {
                var dtbol = $("#dtbol");
                
                if (dtbol.is(":disabled")) {
                    buscar($("#contnum").val(), null, $("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);
                    $('#dtbol').val("");
                } 
                else {
                    buscar($("#contnum").val(), $("#dtbol").val(), $("#etbcod").val(), null, null, $("#clicod").val(), $("#cpfcnpj").val(), null, null);
                    $('#dtini').val("");
                    $('#dtfim').val("");
                } 
                $('#periodoModal').modal('hide');
            });
        });    
        document.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);

            }
        });

        $("#prevPage").click(function () {
            buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), prilinha, "prev");
        });
        
        $("#nextPage").click(function () {
            buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), ultlinha, "next");
        });
        
        $(document).on('click', '.boletar-btn', function () {
            $('body').css('cursor', 'progress');
            var contnum = $(this).attr("data-contnum");

            $.ajax({
                method: "POST",
                dataType: 'json',
                url: "../database/boletos.php?operacao=emitirboleto",
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
            var boletavel = $("#boletavel").is(':checked');
            var texto = $("#mensagemCSV");
            texto.html("Gerando CSV...");
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: "<?php echo URLROOT ?>/crediario/database/boletos.php?operacao=csvBoletagem",
                data: {
                    boletavel: boletavel,
                    dtbol: $("#dtbol").val(),
                    contnum: $("#contnum").val(),
                    etbcod: $("#etbcod").val(),
                    dtini: $("#dtini").val(),
                    dtfim: $("#dtfim").val(),
                    clicod: $("#clicod").val(),
                    cpfcnpj: $("#cpfcnpj").val()
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
            $(".input-dtbol").toggleClass("d-none");
            $(".input-dtini").toggleClass("d-none");
            $(".input-dtfim").toggleClass("d-none");

            var elemento = document.getElementById("dtbol");
            var classe = elemento.getAttribute("class");
            //alert(classe.lastIndexOf("d-none"))
            if (classe[25] == "d") {
                $("#button-dti").prop("title", "Data Processamento");
                $(".input-dtbol").prop("disabled", true);
                $(".input-dtini").prop("disabled", false);
                $(".input-dtfim").prop("disabled", false);
                $(".input-dtbol").prop("required", false);
                $(".input-dtini").prop("required", true);
                $(".input-dtfim").prop("required", true);
            } else {
                $("#button-dti").prop("title", "Data por Periodo");
                $(".input-dtbol").prop("disabled", false);
                $(".input-dtini").prop("disabled", true);
                $(".input-dtfim").prop("disabled", true);
                $(".input-dtbol").prop("required", true);
                $(".input-dtini").prop("required", false);
                $(".input-dtfim").prop("required", false);
            }
        });

        

        $(document).on('click', '.ts-click', function () {
            var etbcod = $(this).attr("data-etbcod");
            buscar($("#contnum").val(), $("#dtbol").val(),etbcod, $("#dtini").val(), $("#dtfim").val(), $("#clicod").val(), $("#cpfcnpj").val(), null, null);
            $('#etbcod').val(etbcod);
            $('#zoomEstabModal').modal('hide');
        });
    </script>
    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>