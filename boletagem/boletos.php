<?php
// Lucas 07082024  

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

            <div class="col-7">
                <h2 class="ts-tituloPrincipal">Boletos</h2>
            </div>

            <div class="col-5 text-end">
                <div class="row">
                    <div class="col">
                        <input type="date" class="form-control ts-input" id="DtEmissaoInicial" autocomplete="off" required>
                    </div>
                    <div class="col-1 pt-1">
                        até
                    </div>
                    <div class="col">
                        <input type="date" class="form-control ts-input" id="DtEmissaoFinal" autocomplete="off" required>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-sm btn-primary" type="button" id="filtrardata">Filtrar</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>CPF</th>
                        <th>Documento</th>
                        <th>Banco</th>
                        <th>Nosso Numero</th>
                        <th>Data Emissão</th>
                        <th>Data Vencimento</th>
                        <th>Valor Cobrado</th>
                        <th>Data Pagamento</th>
                        <th>Data Baixa</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>
        <h6 class="fixed-bottom" id="textocontador" style="color: #13216A;"></h6>

        <!--------- VISUALIZAR --------->
        <div class="modal" id="alterarModal" tabindex="-1" aria-labelledby="alterarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloVisualizar"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="form-group col">
                                <label>Numero do Contrato</label>
                                <input type="text" class="form-control" name="contnum" id="contnum" readonly>
                            </div>
                            <div class="form-group col">
                                <label>Numero da Parcela</label>
                                <input type="text" class="form-control" name="titpar" id="titpar" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>nosso Numero Atual</label>
                                <input type="text" class="form-control" name="NossoNumero" id="NossoNumero" readonly>
                            </div>
                            <div class="form-group col">
                                <label>Codigo do Banco</label>
                                <input type="text" class="form-control" name="bancod" id="bancod" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Documento</label>
                                <input type="text" class="form-control" name="Documento" id="Documento" readonly>
                            </div>
                            <div class="form-group col">
                                <label>Data Vencimento</label>
                                <input type="text" class="form-control" name="DtVencimento" id="DtVencimento" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Valor Cobrado</label>
                                <input type="text" class="form-control" name="VlCobrado" id="VlCobrado" readonly>
                            </div>
                            <div class="form-group col">
                                <label>Data Emissao</label>
                                <input type="text" class="form-control" name="DtEmissao" id="DtEmissao" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Linha Digitavel</label>
                                <input type="text" class="form-control" name="LinhaDigitavel" id="LinhaDigitavel" readonly>
                            </div>
                            <div class="form-group col">
                                <label>Codigo de Barras</label>
                                <input type="text" class="form-control" name="CodigoBarras" id="CodigoBarras" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Data Pagamento</label>
                                <input type="text" class="form-control" name="DtPagamento" id="DtPagamento" readonly>
                            </div>
                            <div class="form-group col">
                                <label>Codigo do Cliente/Fornecedor</label>
                                <input type="text" class="form-control" name="CliFor" id="CliFor" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Data Envio</label>
                                <input type="text" class="form-control" name="DtEnvio" id="DtEnvio" readonly>
                            </div>
                            <div class="form-group col">
                                <label>Hora Envio</label>
                                <input type="text" class="form-control" name="hrEnvio" id="hrEnvio" readonly>
                            </div>
                            <div class="form-group col">
                                <label>Data Baixa</label>
                                <input type="text" class="form-control" name="DtBaixa" id="DtBaixa" readonly>
                            </div>
                            <div class="form-group col">
                                <label>Hora Baixa</label>
                                <input type="text" class="form-control" name="hrBaixa" id="hrBaixa" readonly>
                            </div>
                        </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

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

        function buscar(DtEmissaoInicial, DtEmissaoFinal) {

            if (DtEmissaoInicial == '' || DtEmissaoFinal == '') {
                alert("Informe um período")
            } else {

                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: '<?php echo URLROOT ?>/crediario/database/boletos.php?operacao=buscar',
                    beforeSend: function() {
                        $("#dados").html("Carregando...");
                    },
                    data: {
                        DtEmissaoInicial: DtEmissaoInicial,
                        DtEmissaoFinal: DtEmissaoFinal
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

                            var VlCobradoFormatado = object.VlCobrado.toLocaleString('pt-BR', { minimumFractionDigits: 2 });

                            linha += "<td>" + object.CliFor + "</td>";
                            linha += "<td>" + object.Documento + "</td>";
                            linha += "<td>" + object.bancod + "</td>";
                            linha += "<td>" + object.NossoNumero + "</td>";
                            linha += "<td>" + formatDate(object.DtEmissao) + "</td>";
                            linha += "<td>" + formatDate(object.DtVencimento) + "</td>";
                            linha += "<td>" + VlCobradoFormatado + "</td>"; 
                            linha += "<td>" + formatDate(object.DtPagamento) + "</td>";
                            linha += "<td>" + formatDate(object.DtBaixa) + "</td>";

                            linha = linha + "<td>" + "<button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#alterar' ";
                            linha = linha + " data-contnum='" + object.contnum + "' ";
                            linha = linha + " data-titpar='" + object.titpar + "' ";
                            linha = linha + " data-NossoNumero='" + object.NossoNumero + "' ";
                            linha = linha + " data-bancod='" + object.bancod + "' ";
                            linha = linha + " data-Documento='" + object.Documento + "' ";
                            linha = linha + " data-DtVencimento='" + object.DtVencimento + "' ";
                            linha = linha + " data-VlCobrado='" + object.VlCobrado + "' ";
                            linha = linha + " data-DtEmissao='" + object.DtEmissao + "' ";
                            linha = linha + " data-LinhaDigitavel='" + object.LinhaDigitavel + "' ";
                            linha = linha + " data-CodigoBarras='" + object.CodigoBarras + "' ";
                            linha = linha + " data-DtPagamento='" + object.DtPagamento + "' ";
                            linha = linha + " data-CliFor='" + object.CliFor + "' ";
                            linha = linha + " data-DtEnvio='" + object.DtEnvio + "' ";
                            linha = linha + " data-hrEnvio='" + object.hrEnvio + "' ";
                            linha = linha + " data-DtBaixa='" + object.DtBaixa + "' ";
                            linha = linha + " data-hrBaixa='" + object.hrBaixa + "' ";
                            linha = linha + " ><i class='bi bi-eye-fill'></i></button>";

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
        }


        $("#filtrardata").click(function() {
            buscar($("#DtEmissaoInicial").val(), $("#DtEmissaoFinal").val());
        });


        $(document).on('click', 'button[data-bs-target="#alterar"]', function() {
            var contnum = $(this).attr("data-contnum");
            var titpar = $(this).attr("data-titpar");
            var NossoNumero = $(this).attr("data-NossoNumero");
            var bancod = $(this).attr("data-bancod");

            var Documento = $(this).attr("data-Documento");
            var texto = $("#tituloVisualizar");
            texto.html('Visualizar Documento: ' + Documento);

            var DtVencimento = $(this).attr("data-DtVencimento");
            var VlCobrado = $(this).attr("data-VlCobrado");
            var DtEmissao = $(this).attr("data-DtEmissao");
            var LinhaDigitavel = $(this).attr("data-LinhaDigitavel");
            var CodigoBarras = $(this).attr("data-CodigoBarras");
            var DtPagamento = $(this).attr("data-DtPagamento");
            var CliFor = $(this).attr("data-CliFor");
            var DtEnvio = $(this).attr("data-DtEnvio");
            var hrEnvio = $(this).attr("data-hrEnvio");
            var DtBaixa = $(this).attr("data-DtBaixa");
            var hrBaixa = $(this).attr("data-hrBaixa");

            $('#contnum').val(contnum);
            $('#titpar').val(titpar);
            $('#NossoNumero').val(NossoNumero);
            $('#bancod').val(bancod);
            $('#Documento').val(Documento);
            $('#DtVencimento').val(formatDate(DtVencimento));
            $('#VlCobrado').val(VlCobrado);
            $('#DtEmissao').val(formatDate(DtEmissao));
            $('#LinhaDigitavel').val(LinhaDigitavel);
            $('#CodigoBarras').val(CodigoBarras);
            $('#DtPagamento').val(formatDate(DtPagamento));
            $('#CliFor').val(CliFor);
            $('#DtEnvio').val(formatDate(DtEnvio));
            $('#hrEnvio').val(hrEnvio);
            $('#DtBaixa').val(formatDate(DtBaixa));
            $('#hrBaixa').val(hrBaixa);

            $('#alterarModal').modal('show');

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
    </script>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>