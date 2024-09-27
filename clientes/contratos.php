<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 23022023 09:50

include_once '../header.php';
include_once '../database/crediariocontrato.php';

if (isset($_GET['parametros'])) {
    $numeroContrato = $_POST['numeroContrato'];
}
if (isset($_GET['numeroContrato'])) {
    $numeroContrato = $_GET['numeroContrato'];
}


$contrato = buscaContratos($numeroContrato);
$contrato = $contrato[0];
$parcelas = $contrato["parcelas"];
$produtos = $contrato["produtos"];

$assinatura = buscaAssinatura($numeroContrato);

if (URL !== "localhost") {
    $barramento = chamaAPI(
        IPBARRAMENTO,
        "/gateway/lebes-repo-img-biometria/1.0/registration-face/" .
            $assinatura["etbcod"] . "/" .
            $assinatura["dtinclu"] . "/" .
            $assinatura["cxacod"] . "/" .
            $assinatura["cpfCNPJ"] . "/" .
            $assinatura["idBiometria"],
        null,
        "GET"
    );
} else {
    // Define $barramento with a default value or whatever logic you need
    $barramento = null; // Example default value
}

$foto = $barramento ? $barramento["registrationFace"]["imgBase64"] : null;

//$foto = base64_decode($imgBase64);                

//echo '<img src="data:image/gif;base64,' . $foto . '" />';
?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>
<style>
    .modal-fullscreen {
        max-width: 100vw !important;
    }
</style>

<body class="ts-noScroll">

    <div class="container-fluid">

        <!-- Modal -->
        <div class="modal" id="modalContratoVisualizar" tabindex="-1" aria-hidden="true" style="margin: 5px;">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"> <!-- Modal 1 -->
                <div class="modal-content" style="background-color: #F1F2F4;">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-5">
                            </div>
                            <div class="col-6">
                                <span class="ts-tituloPrincipalModal">Consulta Contrato</span>
                            </div>
                            <div class="col-1 border-start d-flex">
                                <?php if (isset($_GET['origem']) && $_GET['origem'] === 'cliente') { ?>
                                    <a href="historico_cliente.php?codigoCliente=<?php echo $contrato['codigoCliente'] ?>"
                                        role="button" class="btn-close"></a>
                                <?php } else { ?>
                                    <a href="contratos_parametros.php" role="button" class="btn-close"></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row mt-2">
                            <div class="col">
                                Contrato: <?php echo $contrato['numeroContrato'] ?>
                            </div>
                            <div class="col">
                                Situação: <?php echo $contrato['situacao'] ?>
                            </div>
                            <div class="col">
                                idAdesaoHubSeg: <?php echo $contrato['idAdesaoHubSeg'] ?>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                Cliente: <?php echo $contrato['codigoCliente'] ?> - <?php echo $contrato['nomeCliente'] ?>
                            </div>
                            <div class="col">
                                CPF/CNPJ: <?php echo $contrato['cpfCNPJ'] ?>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                Data de Emissão: <?php echo date('d/m/Y', strtotime($contrato['dtemissao'])) ?>
                            </div>
                            <div class="col">
                                Loja: <?php echo $contrato['etbnom'] ?>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                Banco: <?php echo $contrato['banco'] ?>
                            </div>
                            <div class="col">
                                Cod. Modalidade: <?php echo $contrato['modalidade'] ?>
                            </div>
                            <div class="col">
                                Qtd. Parcelas: <?php echo $contrato['nro_parcelas'] ?>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-3">
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Vlr Total:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['valorTotal'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Vlr Entrada:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['valorEntrada'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Vlr Liquido:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['valorLiquido'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Principal:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['valorPrincipal'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Acrescimo:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['valorAcrescimo'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Seguro:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['valorSeguro'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    IOF:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['IOF'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    CET:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['CET'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Tx. Juros:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['taxaJuros'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Vlr Vencido:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['valorVencido'], 2, '.', '') ?>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Em Aberto:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <?php echo number_format($contrato['valorAberto'], 2, '.', '') ?>
                                </div>
                            </div>

                        </div>

                        <div class="col-9 border-start">
                            <div id="ts-tabs">
                                <div class="tab whiteborder" id="tab-parcela">Parcelas</div>
                                <!--  *****Produtos comentados at� possuir dados reais
                                <div class="tab" id="tab-produ">Produtos</div> -->
                                <div class="tab" id="tab-assinatura">Assinatura</div>

                                <div class="line"></div>

                                <div class="tabContent">
                                    <!-- *****************Parcelas Contrato***************** -->
                                    <div class="table mt-2 ts-divTabela60 ts-tableFiltros">
                                        <table class="table table-sm table-hover table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>Contrato</th>
                                                    <th>Parc</th>
                                                    <th>Dt Venc</th>
                                                    <th>Parc</th>
                                                    <th>Sit</th>
                                                    <th>Dt Pag</th>
                                                    <th>Pag</th>
                                                    <th>N.Boleto</th>
                                                </tr>
                                            </thead>
                                            <?php foreach ($parcelas as $parcela) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $parcela['numeroContrato'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $parcela['parcela'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo date('d/m/Y', strtotime($parcela['dtVencimento'])) ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($parcela['vlrParcela'], 2, '.', '') ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $parcela['situacao'] ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($parcela['dtPagamento'] !== null) {
                                                            echo date('d/m/Y', strtotime($parcela['dtPagamento']));
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($parcela['vlrPago'], 2, '.', '') ?>
                                                    </td>
                                                    <td class="ts-click">
                                                        <a class="link-opacity-100" data-bs-target='#modalBoletoVisualizar' data-bolcod='<?php echo $parcela['bolcod'] ?>'>
                                                            <?php echo $parcela['bolcod'] ?>
                                                        </a>
                                                    </td>

                                                </tr>
                                            <?php } ?>

                                        </table>
                                    </div>
                                </div>

                                <!--  *****Produtos comentados at� possuir dados reais
                                <div class="tabContent">
                                <h5>Produtos</h5>
                                <div class="table table-responsive">
                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Nome</th>
                                            <th class="text-center">Preço</th>
                                            <th class="text-center">Quantidade</th>
                                            <th class="text-center">Valor Total</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($produtos as $produto) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $produto['codigoProduto'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo $produto['nomeProduto'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo number_format($produto['precoVenda'], 2, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo $produto['quantidade'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo number_format($produto['valorTotal'], 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </table>
                                </div>
                                </div> -->


                                <div class="tabContent">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="col-md">
                                                        <label>etbcod</label>
                                                        <input type="text" class="form-control"
                                                            value="<?php echo isset($assinatura['etbcod']) ? $assinatura['etbcod'] : '' ?>"
                                                            readonly>
                                                    </div>
                                                    <label>Data de Inclusão</label>
                                                    <input type="text" class="form-control"
                                                        value="<?php echo isset($assinatura['dtinclu']) ? date('d/m/Y', strtotime($assinatura['dtinclu'])) : '' ?>"
                                                        readonly>

                                                </div>
                                                <div class="col-6">
                                                    <label>Boletavel</label>
                                                    <input type="text" class="form-control"
                                                        value="<?php echo isset($assinatura['boletavel']) ? ($assinatura['boletavel'] ? 'sim' : 'não') : ''; ?>"
                                                        readonly>
                                                    <label>Data de Boletagem</label>
                                                    <input type="text" class="form-control"
                                                        value="<?php echo isset($assinatura['dtboletagem']) ? date('d/m/Y', strtotime($assinatura['dtboletagem'])) : '' ?>"
                                                        readonly>
                                                </div>
                                                <div class="col">
                                                    <label>idBiometria</label>
                                                    <input type="text" class="form-control"
                                                        value="<?php echo isset($assinatura['idBiometria']) ? $assinatura['idBiometria'] : '' ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 text-center">
                                            <img src="<?php echo 'data:image/png;base64,' . $foto ?>" class="img-fluid"
                                                alt="Image Preview" style="max-width: 150px; max-height: 150px;">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md">
                                            <label>clicod</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo isset($assinatura['clicod']) ? $assinatura['clicod'] : '' ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md">
                                            <label>Cpf/Cnpj</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo isset($assinatura['cpfCNPJ']) ? $assinatura['cpfCNPJ'] : '' ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md">
                                            <label>Data de Processamento</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo isset($assinatura['dtproc']) && $assinatura['dtproc'] !== null ? date('d/m/Y', strtotime($assinatura['dtproc'])) : '' ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md">
                                            <label>hrproc</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo isset($assinatura['hrproc']) ? $assinatura['hrproc'] : '' ?>"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md">
                                            <label>etbcod</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo isset($assinatura['etbcod']) ? $assinatura['etbcod'] : '' ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md">
                                            <label>cxacod</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo isset($assinatura['cxacod']) ? $assinatura['cxacod'] : '' ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md">
                                            <label>ctmcod</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo isset($assinatura['ctmcod']) ? $assinatura['ctmcod'] : '' ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md">
                                            <label>nsu</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo isset($assinatura['nsu']) ? $assinatura['nsu'] : '' ?>"
                                                readonly>
                                        </div>
                                    </div>
                                    <?php if (isset($assinatura['urlPdf'])) { ?>
                                        <div class="mt-2" style="text-align:right">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalPDF"
                                                data-pdf="<?php echo $assinatura['urlPdf'] ?>">Contrato
                                                PDF</button>
                                        </div>
                                        <div class="mt-2" style="text-align:right">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalPDF"
                                                data-pdf="<?php echo $assinatura['urlPdfAss'] ?>">Contrato
                                                Assinado</button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- Modal 1 -->


    </div>


    </div><!--container-fluid-->

    <div class="modal" id="modalPDF" tabindex="-1" role="dialog" aria-labelledby="modalPDFLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contrato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ExternalFiles full-width">
                        <iframe class="container-fluid full-width" id="myIframe" src="" frameborder="0" scrolling="yes"
                            height="550"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL VISUALIZAR BOLETO -->
    <?php include_once "../boletagem/visualizar_boleto.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        var myModal = new bootstrap.Modal(document.getElementById("modalContratoVisualizar"), {});
        document.onreadystatechange = function() {
            myModal.show();
        };

        var tab;
        var tabContent;

        window.onload = function() {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'parcela') {
                showTabsContent(0);
            }
            /* if (id === 'produ') {
                showTabsContent(2);
            } */
            if (id === 'assinatura') {
                showTabsContent(1);
            }
        }

        document.getElementById('ts-tabs').onclick = function(event) {
            var target = event.target;
            if (target.className == 'tab') {
                for (var i = 0; i < tab.length; i++) {
                    if (target == tab[i]) {
                        showTabsContent(i);
                        break;
                    }
                }
            }
        }

        function hideTabsContent(a) {
            for (var i = a; i < tabContent.length; i++) {
                tabContent[i].classList.remove('show');
                tabContent[i].classList.add("hide");
                tab[i].classList.remove('whiteborder');
            }
        }

        function showTabsContent(b) {
            if (tabContent[b].classList.contains('hide')) {
                hideTabsContent(0);
                tab[b].classList.add('whiteborder');
                tabContent[b].classList.remove('hide');
                tabContent[b].classList.add('show');
            }
        }

        var modalPDF = document.getElementById('modalPDF');
        modalPDF.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var pdfUrl = button.getAttribute('data-pdf'); // Extract info from data-* attributes
            var iframe = modalPDF.querySelector('iframe');
            iframe.src = pdfUrl; // Set iframe src to the PDF URL
        });


        // MODAL VISUALIZAR BOLETO
        $(document).on('click', 'a[data-bs-target="#modalBoletoVisualizar"]', function() {
            var bolcod = $(this).attr("data-bolcod");
            //alert(bolcod)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/crediario/database/boletos.php?operacao=buscarboleto',
                data: {
                    bolcod: bolcod
                },
                success: function(msg) {
                    //alert(JSON.stringify(msg));
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
                        $("#view_VlCobrado").html(parseFloat(object.VlCobrado).toFixed(2).replace(',', '.'));
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
                                linha_parcelas += "<td>" + parseFloat(object_parcela.VlCobrado).toFixed(2).replace(',', '.') + "</td>";
                                linha_parcelas += "<td>" + object_parcela.bolcod + "</td>";

                                linha_parcelas += "</tr>";
                            }
                        } else {
                            $("#dadosParcelasBoleto").html("Boleto não possui parcelas");
                        }
                        $("#dadosParcelasBoleto").html(linha_parcelas);

                    }
                    $('#modalBoletoVisualizar').modal('show');
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
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>