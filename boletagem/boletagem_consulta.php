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
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i
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
                                <button class="btn ts-input btn-outline-secondary" type="button" id="button-etbcod" title="Fixo"><i class="bi bi-search"></i></button>
                            </div>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
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
        <h6 class="fixed-bottom" id="textocontador" style="color: #13216A;"></h6>

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

    <?php include_once '../clientes/zoomEstab.php'; ?>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val());

        $(document).ready(function() {
            var texto = $("#textocontador");
            texto.html('total: ' + 0);
        });

        function naobolet() {
            var dtbol = $("#dtbol");
                
            if (dtbol.is(":disabled")) {
                buscar(null, null, $("#etbcod").val(), null, null);
            } else {
                buscar(null, null, $("#etbcod").val(), $("#dtini").val(), $("#dtfim").val());
            }
            $('#dtbol').val("");
        }

        function limparPeriodo() {
            buscar($("#contnum").val(), null,$("#etbcod").val(), null, null);
            $('#dtbol').val("");
            $('#dtini').val("");
            $('#dtfim').val("");
            $('#periodoModal').modal('hide');
        };

        function buscar(contnum, dtbol, etbcod, dtini, dtfim) {
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
                    dtfim: dtfim
                },
                success: function (msg) {
                    alert("segundo alert: " + msg);
                    //console.log(msg);
                    var contadorItem = 0;
                    var contadorVlTotal = 0;
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        contadorItem += 1;
                        contadorVlTotal += parseFloat(object.vltotal);

                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.etbcod + "</td>";
                        linha = linha + "<td>" + object.contnum + "</td>";
                        linha = linha + "<td>" + object.clicod + "</td>";
                        linha = linha + "<td>" + object.cpfCNPJ + "</td>";
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

                    var texto = $("#textocontador");
                    var VlTotal = contadorVlTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    texto.html('Total: ' + contadorItem + ' ' + ' | ' + ' ' + 'Valor Cobrado: ' + VlTotal);
                }
            });
        }

        document.getElementById("buscar").addEventListener("click",function () {
            buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val());
        })
        $("#etbcod").change(function() {
            buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val());
        });
        $("#boletavel").change(function() {
            buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val());
        });
        $(document).ready(function() {
            $("#filtrarButton").click(function() {
                var dtbol = $("#dtbol");
                
                if (dtbol.is(":disabled")) {
                    buscar($("#contnum").val(), null, $("#etbcod").val(), $("#dtini").val(), $("#dtfim").val());
                    $('#dtbol').val("");
                } 
                else {
                    buscar($("#contnum").val(), $("#dtbol").val(), $("#etbcod").val(), null, null);
                    $('#dtini').val("");
                    $('#dtfim').val("");
                } 
                $('#periodoModal').modal('hide');
            });
        });    
        document.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                buscar($("#contnum").val(), $("#dtbol").val(),$("#etbcod").val(), $("#dtini").val(), $("#dtfim").val());
            }
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

        document.getElementById("exportCsvButton").addEventListener("click", function () {
            exportTableToCSV('boletagem.csv');
        });

        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");

            for (var i = 0; i < rows.length; i++) {
                if (rows[i].classList.contains("ts-headerTabelaLinhaBaixo")) {
                    continue;
                }
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");
                for (var j = 0; j < cols.length - 2; j++) { 
                    let cellText = cols[j].innerText.trim();
                    if (j === 8) {
                        cellText = cellText.replace('.', '').replace(',', '.');
                    }
                    row.push(cellText);
                }
                csv.push(row.join(";"));
            }
            var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
            var downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
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

        
        $("#button-etbcod").click(function(event) {
            event.preventDefault(); 
            $("#zoomEstabModal").modal('show');
        });

        $(document).on('click', '.ts-click', function () {
            var etbcod = $(this).attr("data-etbcod");
            buscar($("#contnum").val(), $("#dtbol").val(),etbcod, $("#dtini").val(), $("#dtfim").val());
            $('#etbcod').val(etbcod);
            $('#zoomEstabModal').modal('hide');
        });
    </script>
    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>