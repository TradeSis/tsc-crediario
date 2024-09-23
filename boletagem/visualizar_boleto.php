<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 23022023 09:50

include_once '../header.php';

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
        <div class="modal" id="modalBoletoVisualizar" tabindex="-1" aria-hidden="true" style="margin: 5px;">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content" style="background-color: #F1F2F4;">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-11 text-center">
                                <span class="ts-tituloPrincipalModal">Consulta Boleto</span>
                            </div>
                            <div class="col-1 border-start d-flex">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row mt-2">
                            <div class="col-1">
                                <span id="view_bolcod"></span>
                            </div>
                            <div class="col-1">
                                <span id="view_bancod"></span>
                            </div>
                            <div class="col-2 mx-0 px-0">
                                <span id="view_NossoNumero"></span>
                            </div>
                            <div class="col">
                                <span id="view_Documento"></span>
                            </div>
                            <div class="col">
                                <span id="view_origem"></span>
                            </div>
                            <div class="col">
                                <span id="view_situacaoDescricao"></span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <span id="view_cliente"></span>
                            </div>
                            <div class="col">
                                <span id="view_cpfcnpj"></span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-1">
                                <span id="view_etbcod"></span>
                            </div>
                            <div class="col mx-0 px-0">
                                <span id="view_LinhaDigitavel"></span>
                            </div>
                            <div class="col mx-0 px-0">
                                <span id="view_CodigoBarras"></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-3">

                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Dt. Emissão:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_DtEmissao"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Dt. Vencimento:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_DtVencimento"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Vlr. Cobrado:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_VlCobrado"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Dt. Baixa:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_DtBaixa"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Dt. Pagamento:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_DtPagamento"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Tp. Baixa:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_ctmcod"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Etb. Pag:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_etbpag"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    nsu:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_nsu"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Numero Pg Banco:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_numero_pgto_banco"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-5 text-end">
                                    Obs.:
                                </div>
                                <div class="col-7 ms-0 ps-0 text-start">
                                    <span id="view_obs_pgto_banco"></span>
                                </div>
                            </div>

                        </div>

                        <div class="col-9 border-start">
                            <div id="ts-tabs">
                                <div class="tab whiteborder" id="tab-parcelaBoleto">Parcelas</div>
                                <div class="line"></div>

                                <div class="tabContentParcela">
                                    <!-- *****************Parcelas Contrato***************** -->
                                    <div class="table table-responsive pe-3">
                                        <table class="table table-sm table-hover table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>Contrato</th>
                                                    <th>Parc</th>
                                                    <th>Vlr Cobrado</th>
                                                    <th>Boleto</th>
                                                </tr>
                                            </thead>
                                            <tbody id='dadosParcelasBoleto' class="fonteCorpo">

                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
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



    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        var tab;
        var tabContentParcela;

        window.onload = function() {
            tabContentParcela = document.getElementsByClassName('tabContentParcela');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'parcelaBoleto') {
                showTabsContent(0);
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
            for (var i = a; i < tabContentParcela.length; i++) {
                tabContentParcela[i].classList.remove('show');
                tabContentParcela[i].classList.add("hide");
                tab[i].classList.remove('whiteborder');
            }
        }

        function showTabsContent(b) {
            if (tabContentParcela[b].classList.contains('hide')) {
                hideTabsContent(0);
                tab[b].classList.add('whiteborder');
                tabContentParcela[b].classList.remove('hide');
                tabContentParcela[b].classList.add('show');
            }
        }

    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>