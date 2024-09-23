<?php

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

            <div class="col-5 col-lg-5" id="filtroh6">
                <h2 class="ts-tituloPrincipal">Boletos</h2>
                <h6 style="font-size: 10px;font-style:italic;text-align:left;"></h6>
            </div>

            <div class="col-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filtroentradaModal"><i class="bi bi-calendar3"></i></button>
            </div>

            <div class="col-1 mx-0 px-0">
                <button id="exportCsvButton" class="ms-4 btn btn-success"><i class="bi bi-file-earmark-arrow-down-fill" style="color:#fff"></i>&#32;CSV</button>
            </div>

            <div class="col-4 col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="bolcod" placeholder="Buscar Numero do Boleto">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i
                            class="bi bi-search"></i></button>
                </div>
            </div>

        </div>

        <!--------- FILTRO BOLETOS --------->
        <div class="modal" id="filtroentradaModal" tabindex="-1"
            aria-labelledby="filtroentradaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filtrar Boletos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Situacao</label>
                                    <select class="form-control" id="situacao">
                                        <option value="A">Aberto</option>
                                        <option value="P">Pago</option>
                                        <option value="B">Baixado</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tipo de Data</label>
                                    <select class="form-control" id="tipodedata">
                                        <option value="Emissao">Emissao</option>
                                        <option value="Pagamento">Pagamento</option>
                                        <option value="Baixa">Baixa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row" id="conteudoReal">
                                <div class="col">
                                    <label class="labelForm">Data Inicial</label>
                                    <input type="date" class="data select form-control" id="dtInicial">
                                </div>
                                <div class="col">
                                    <label class="labelForm">Data Final</label>
                                    <input type="date" class="data select form-control" id="dtFinal">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer border-0">
                        <div class="col-sm text-start">
                            <button type="button" class="btn btn-primary" onClick="limparPeriodo()">Limpar</button>
                        </div>
                        <div class="col-sm text-end">
                            <button type="button" class="btn btn-success" id="filtroentrada" data-dismiss="modal">Filtrar</button>
                        </div>
                    </div>
                    </form>

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
                        <th>Situação</th>
                        <th></th>
                    </tr>
                    <tr class="ts-headerTabelaLinhaBaixo">
                        <th></th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Cliente [ENTER]"
                                name="CliFor" id="CliFor" required>
                        </th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Cpf/Cnpj [ENTER]"
                                name="cpfcnpj" id="cpfcnpj" required>
                        </th>
                        <th></th>
                        <th class="col-1">
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Banco [ENTER]"
                                name="bancod" id="bancod" required>
                        </th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela" placeholder="Nosso Numero [ENTER]"
                                name="NossoNumero" id="NossoNumero" required>
                        </th>
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

    <!-- MODAL VISUALIZAR BOLETO -->
    <?php include_once "visualizar_boleto.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -->
    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- script para menu de filtros -->
    <script src="<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>

    <script>
        $(document).ready(function() {
            var texto = $("#textocontador");
            texto.html('total: ' + 0);
        });

        function buscar(situacao, tipodedata, dtInicial, dtFinal, CliFor, cpfcnpj, bolcod, bancod, NossoNumero) {
            if (dtInicial == '' || dtFinal == '') {
                alert("Informe um período")
            } else {
                //alert (buscar);
                var h6Element = $("#filtroh6 h6");
                var text = "";

                var select = document.getElementById('situacao');
                var option = select.children[select.selectedIndex];
                var textoSelect = option.textContent;

                text += "Situação: " + textoSelect;

                if (tipodedata !== null && tipodedata !== '') {
                    if (text) text += " | Tipo de Data: ";
                    text += tipodedata;
                }
                if (dtInicial !== null && dtInicial !== '') {
                    text += " | Periodo de " + formatDate(dtInicial);
                }
                if (dtFinal !== null && dtFinal !== '') {
                    if (text) text += " até ";
                    text += formatDate(dtFinal);
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
                        situacao: situacao,
                        tipodedata: tipodedata,
                        dtInicial: dtInicial,
                        dtFinal: dtFinal,
                        CliFor: CliFor,
                        cpfcnpj: cpfcnpj,
                        bolcod: bolcod,
                        bancod: bancod,
                        NossoNumero: NossoNumero

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
                            linha += "<td>" + object.situacaoDescricao + "</td>";

                            linha = linha + "<td>" + "<button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#modalBoletoVisualizar' data-bolcod='" + object.bolcod + "'><i class='bi bi-eye-fill'></i></button></td>";

                            linha += "</tr>";
                        }

                        $("#dados").html(linha);

                        var texto = $("#textocontador");
                        var VlCobrado = contadorVlCobrado.toLocaleString('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        });
                        texto.html('Total: ' + contadorItem + ' ' + ' | ' + ' ' + 'Valor Cobrado: ' + VlCobrado);
                    }
                });
            }
        }

        $("#buscar").click(function() {
            buscar($("#situacao").val(), $("#tipodedata").val(), $("#dtInicial").val(), $("#dtFinal").val(), $("#CliFor").val(), $("#cpfcnpj").val(), $("#bolcod").val(), $("#bancod").val(), $("#NossoNumero").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                if (($("#NossoNumero").val() != '') && ($("#bancod").val() == '')) {
                    alert("Digitar Codigo do Banco");
                } else {
                    buscar($("#situacao").val(), $("#tipodedata").val(), $("#dtInicial").val(), $("#dtFinal").val(), $("#CliFor").val(), $("#cpfcnpj").val(), $("#bolcod").val(), $("#bancod").val(), $("#NossoNumero").val());
                }
            }
        });

        $("#filtroentrada").click(function() {
            buscar($("#situacao").val(), $("#tipodedata").val(), $("#dtInicial").val(), $("#dtFinal").val(), $("#CliFor").val(), $("#cpfcnpj").val(), $("#bolcod").val(), $("#bancod").val(), $("#NossoNumero").val());
            $('#filtroentradaModal').modal('hide');

        });

        // MODAL VISUALIZAR BOLETO
        $(document).on('click', 'button[data-bs-target="#modalBoletoVisualizar"]', function() {
            var bolcod = $(this).attr("data-bolcod");

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/boletos.php?operacao=buscarboleto',
                data: {
                    bolcod: bolcod
                },
                success: function(msg) {
                    var linha = "";
                    for (var $i = 0; $i < msg.length; $i++) {
                        var object = msg[$i];
                   
                        //DADOS BOLETOS (parte de cima)
                        $("#view_bolcod").html('Boleto: ' + object.bolcod);
                        $("#view_bancod").html('Banco: ' + object.bancod);
                        $("#view_NossoNumero").html('Nosso Numero: ' + object.NossoNumero);
                        $("#view_Documento").html('Documento: ' + object.Documento);
                        $("#view_origem").html('Origem: ' + object.origem);
                        $("#view_situacaoDescricao").html('Situação: ' + object.situacaoDescricao);
                        $("#view_cliente").html('Cliente: ' + object.CliFor + '-' + object.nomeCliente);
                        $("#view_cpfcnpj").html('CPF/CNPJ: ' + object.cpfcnpj);
                        $("#view_etbcod").html('Estab: ' + object.etbcod);
                        $("#view_LinhaDigitavel").html('Linha Digitavel: ' + object.LinhaDigitavel);
                        $("#view_CodigoBarras").html('Codigo Barras: ' + object.CodigoBarras);
                        //DADOS BOLETOS (parte de lateral)
                        $("#view_DtEmissao").html((object.DtEmissao ? formatDate(object.DtEmissao) : ""));
                        $("#view_DtVencimento").html((object.DtVencimento ? formatDate(object.DtVencimento) : ""));
                        $("#view_VlCobrado").html(parseFloat(object.VlCobrado).toFixed(2).replace('.', ','));
                        $("#view_DtBaixa").html((object.DtBaixa ? formatDate(object.DtBaixa) : ""));
                        $("#view_DtPagamento").html((object.DtPagamento ? formatDate(object.DtPagamento) : ""));
                        $("#view_ctmcod").html(object.ctmcod);
                        $("#view_etbpag").html(object.etbpag);
                        $("#view_nsu").html(object.nsu);
                        $("#view_numero_pgto_banco").html(object.numero_pgto_banco);
                        $("#view_obs_pgto_banco").html(object.obs_pgto_banco);

                        //TABELA PARCELAS
                        parcelas = object.boletagparcela
                        if (parcelas != null) {
                            var linha_parcelas = "";
                            for (var $i = 0; $i < parcelas.length; $i++) {
                                var object_parcela = parcelas[$i];

                                linha_parcelas += "<tr>";

                                linha_parcelas += "<td>" + object_parcela.contnum + "</td>";
                                linha_parcelas += "<td>" + object_parcela.titpar + "</td>";
                                linha_parcelas += "<td>" + parseFloat(object_parcela.VlCobrado).toFixed(2).replace('.', ',') + "</td>";
                                linha_parcelas += "<td>" + object_parcela.bolcod + "</td>";

                                linha_parcelas += "</tr>";
                            }
                        } else {
                            $("#dadosParcelas").html("Boleto não possui parcelas");
                        }
                        $("#dadosParcelas").html(linha_parcelas);

                    }
                    $('#modalBoletoVisualizar').modal('show');
                }
            });
        });

        function limparPeriodo() {
            $('#filtroentradaModal').modal('hide');
            $("#CliFor").val('');
            $("#cpfcnpj").val('');
            $("#bolcod").val('');
            $("#bancod").val('');
            $("#NossoNumero").val('');
            buscar($("#situacao").val(), $("#tipodedata").val(), $("#dtInicial").val(), $("#dtFinal").val(), null, null, null, null, null, function() {
                window.location.reload();
            });
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

        document.getElementById("exportCsvButton").addEventListener("click", function() {
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
            var csvFile = new Blob([csv.join("\n")], {
                type: "text/csv"
            });
            var downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

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

            const dtInicial = document.getElementById("dtInicial");
            dtInicial.value = dataAtual;

            const dtFinal = document.getElementById("dtFinal");
            dtFinal.value = dataAtual;


        });
    </script>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>