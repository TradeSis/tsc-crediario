<?php

include_once(__DIR__ . '/../header.php');

$CliFor = null;
$cpfcnpj = null;
$bolcod = null;
$bancod = null;
$NossoNumero = null;
$dtini = null;
$dtfim = null;
if (isset($_SESSION['filtro_boletos'])) {
  $filtroEntrada = $_SESSION['filtro_boletos'];
  $CliFor = $filtroEntrada['CliFor'];
  $cpfcnpj = $filtroEntrada['cpfcnpj'];
  $bolcod = $filtroEntrada['bolcod'];
  $bancod = $filtroEntrada['bancod'];
  $NossoNumero = $filtroEntrada['NossoNumero'];
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

        <div class="row">
            <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-5 col-lg-5" id="filtroh6">
                <h2 class="ts-tituloPrincipal">Boletos</h2>
                <h6 style="font-size: 10px;font-style:italic;text-align:left;"></h6>
            </div>

            <div class="col-3 col-lg-3">
                <div class="input-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#periodoModal"><i class="bi bi-calendar3"></i></button>
                    <button id="exportCsvButton" class="ms-4 btn btn-success">CSV</button>
                </div>
            </div>

            <div class="col-4 col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="bolcod" placeholder="Buscar Numero do Boleto">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i
                            class="bi bi-search"></i></button>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>Numero</th>
                        <th>Cliente</th>
                        <th>Cpf/Cnpj</th>
                        <th>Documento</th>
                        <th>Banco</th>
                        <th>Nosso Numero</th>
                        <th>Dt Emissão</th>
                        <th>Dt Vencimento</th>
                        <th>Valor Cobrado</th>
                        <th>Dt Pagamento</th>
                        <th>Dt Baixa</th>
                        <th></th>
                    </tr>
                    <tr class="ts-headerTabelaLinhaBaixo">
                        <th></th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Cliente [ENTER]"
                            value="<?php echo $CliFor !== null ? $CliFor : null ?>" name="CliFor" id="CliFor" required>
                        </th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Cpf/Cnpj [ENTER]"
                            value="<?php echo $cpfcnpj !== null ? $cpfcnpj : null ?>" name="cpfcnpj" id="cpfcnpj" required>
                        </th>
                        <th></th>
                        <th class="col-1">
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Banco [ENTER]"
                            value="<?php echo $bancod !== null ? $bancod : null ?>" name="bancod" id="bancod" required>
                        </th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Nosso Numero [ENTER]"
                            value="<?php echo $NossoNumero !== null ? $NossoNumero : null ?>" name="NossoNumero" id="NossoNumero" required>
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
                    <div class="col">
                        <label>Emissão De</label>
                    </div>
                    <div class="col">
                        <label>Até</label>
                    </div>
                    </div>
                    <div class="input-group mb-2">
                        <input type="date" class="form-control" value="<?php echo $dtini != null ? $dtini : null?>" name="dtini" id="dtini">
                        <input type="date" class="form-control" value="<?php echo $dtfim != null ? $dtfim : null?>" name="dtfim" id="dtfim">
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

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- script para menu de filtros -->
    <script src="<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>

    <script>
        buscar($("#CliFor").val(),$("#cpfcnpj").val(),$("#bolcod").val(),$("#bancod").val(), $("#NossoNumero").val(),$("#dtini").val(), $("#dtfim").val());

        $(document).ready(function() {
            var texto = $("#textocontador");
            texto.html('total: ' + 0);
        });
        
        function limparPeriodo() {
            buscar($("#CliFor").val(),$("#cpfcnpj").val(),$("#bolcod").val(),$("#bancod").val(),$("#NossoNumero").val(), null, null);
            $('#dtini').val("");
            $('#dtfim').val("");
            $('#periodoModal').modal('hide');
        };

        function buscar(CliFor,cpfcnpj,bolcod,bancod,NossoNumero,dtini, dtfim) {
            //alert (buscar);
            var h6Element = $("#filtroh6 h6");
            var text = "";
            if (dtini !== null && dtini !== '') {
                text += "Periodo de " + formatDate(dtini);
            }
            if (dtfim !== null && dtfim !== '') {
                if (text) text += " até ";
                text += formatDate(dtfim);
            }

            h6Element.html(text);
            $.ajax({
                 type: 'POST',
                 dataType: 'html',
                 url: '<?php echo URLROOT ?>/crediario/database/boletos.php?operacao=buscar',
                 beforeSend: function() {
                     $("#dados").html("Carregando...");
                 },
                 data: {
                    CliFor: CliFor,
                    cpfcnpj: cpfcnpj,
                    bolcod: bolcod,
                    bancod: bancod,
                    NossoNumero: NossoNumero,
                    dtini: dtini,
                    dtfim: dtfim
                 },
                 success: function(msg) {
                     var contadorItem = 0;
                     var contadorVlCobrado = 0;
                     var json = JSON.parse(msg);
                     var linha = "";
                     for (var $i = 0; $i < json.length; $i++) {
                         var object = json[$i];
                        
                         contadorItem += 1;
                         contadorVlCobrado += object.VlCobrado;
                         linha += "<tr>";

                         linha += "<td>" + object.bolcod + "</td>";
                         linha += "<td>" + object.CliFor + "</td>";
                         linha += "<td>" + object.cpfcnpj + "</td>";
                         linha += "<td>" + object.Documento + "</td>";
                         linha += "<td>" + object.bancod + "</td>";
                         linha += "<td>" + object.NossoNumero + "</td>";
                         linha += "<td>" + (object.DtEmissao ? formatDate(object.DtEmissao) : "--") + "</td>";
                         linha += "<td>" + (object.DtVencimento ? formatDate(object.DtVencimento) : "--") + "</td>";
                         linha += "<td>" + parseFloat(object.VlCobrado).toFixed(2).replace('.', ',') + "</td>"; 
                         linha += "<td>" + (object.DtPagamento ? formatDate(object.DtPagamento) : "--") + "</td>";
                         linha += "<td>" + (object.DtBaixa ? formatDate(object.DtBaixa) : "--") + "</td>";

                         linha = linha + "<td>" + "<a class='btn btn-primary btn-sm' href='visualizar_boleto.php?bolcod=" + object.bolcod + "' role='button'><i class='bi bi-eye-fill'></i></a>";

                         linha += "</td>";

                         linha += "</tr>";
                     }

                     $("#dados").html(linha);

                     var texto = $("#textocontador");
                     var VlCobrado = contadorVlCobrado.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                     texto.html('Total: ' + contadorItem + ' ' + ' | ' + ' ' + 'Valor Cobrado: ' + VlCobrado);
                 }
             });
         }

        $("#buscar").click(function () {
            buscar($("#CliFor").val(),$("#cpfcnpj").val(),$("#bolcod").val(),$("#bancod").val(), $("#NossoNumero").val(),$("#dtini").val(), $("#dtfim").val());
        })
        $(document).ready(function() {
            $("#filtrarButton").click(function() {

                buscar($("#CliFor").val(),$("#cpfcnpj").val(),$("#bolcod").val(),$("#bancod").val(), $("#NossoNumero").val(),$("#dtini").val(), $("#dtfim").val());
                $('#periodoModal').modal('hide');
                
            });
        });  
        document.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                buscar($("#CliFor").val(),$("#cpfcnpj").val(),$("#bolcod").val(),$("#bancod").val(), $("#NossoNumero").val(),$("#dtini").val(), $("#dtfim").val());
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

        document.getElementById("exportCsvButton").addEventListener("click", function () {
            exportTableToCSV('boletos.csv');
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
                for (var j = 0; j < cols.length - 1; j++) { 
                    let cellText = cols[j].innerText.trim();
                    if (j === 9) {
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
    </script>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>