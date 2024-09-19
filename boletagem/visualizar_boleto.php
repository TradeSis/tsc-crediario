<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 23022023 09:50

include_once '../header.php';
include_once '../database/boletos.php';

if (isset($_GET['bolcod'])) {
    $bolcod = $_GET['bolcod'];
}


$boleto = buscaBoleto($bolcod);
if (isset($boleto["boletagparcela"])) {
    $parcelas = $boleto["boletagparcela"];
}

?>

<!doctype html>
<html lang="pt-BR">

<head>

    <style>
        .modal-fullscreen {
            max-width: 100vw !important;
        }
        input[readonly] {
            background-color: transparent !important; 
        }  
    </style>
    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>


<body class="ts-noScroll">

    <div class="container-fluid">

        <!-- Modal -->
        <div class="modal" id="modalBoletoVisualizar" tabindex="-1" aria-hidden="true" style="margin: 5px;">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"> <!-- Modal 1 -->
                <div class="modal-content" style="background-color: #F1F2F4;">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-5">
                            </div>
                            <div class="col-6">
                                <span class="ts-tituloPrincipalModal">Consulta Boleto</span>
                            </div>
                            <div class="col-1 border-start d-flex">
                                <a href="#" onclick="history.back()" role="button" class="btn-close"></a>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Boleto&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['bolcod'] ?>" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Banco&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['bancod'] ?>" readonly>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <div class="form-group">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nosso&nbsp;Numero&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['NossoNumero'] ?>" readonly>
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <div class="form-group">
                                    <label>Documento&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['Documento'] ?>" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label>Origem&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['origem'] ?>" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label>Situação&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['situacaoDescricao'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cliente&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['CliFor'] ?> - <?php echo $boleto['nomeCliente'] ?>"
                                    readonly>
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <div class="form-group">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CPF/CNPJ&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['cpfcnpj'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 d-flex align-items-center">
                                <div class="form-group">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estab&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['etbcod'] ?>" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label>Linha&nbsp;Digitavel&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['LinhaDigitavel'] ?>" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="form-group">
                                    <label>Codigo&nbsp;Barras&nbsp;:&nbsp;</label>
                                </div>
                                <input type="text" class="form-control ts-inputSemBorda"
                                    value="<?php echo $boleto['CodigoBarras'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-3">
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dt.&nbsp;Emissão&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['DtEmissao'] !== null ? date('d/m/Y', strtotime($boleto['DtEmissao'])) : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>&nbsp;&nbsp;&nbsp;Dt.&nbsp;Vencimento&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['DtVencimento'] !== null ? date('d/m/Y', strtotime($boleto['DtVencimento'])) : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vlr.&nbsp;Cobrado&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['VlCobrado'] !== null ? number_format($boleto['VlCobrado'], 2, ',', '') : ''  ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dt.&nbsp;Baixa&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['DtBaixa'] !== null ? date('d/m/Y', strtotime($boleto['DtBaixa'])) : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;Dt.&nbsp;Pagamento&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['DtPagamento'] !== null ? date('d/m/Y', strtotime($boleto['DtPagamento'])) : '' ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tp&nbsp;Baixa&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['cmocod'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Etb.&nbsp;Pag&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['etbpag'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;nsu&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['nsu'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>Nosso&nbsp;Pg&nbsp;Banco&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['numero_pgto_banco'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col d-flex align-items-center">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs.&nbsp;&nbsp;:&nbsp;</label>
                                    <input type="text" class="form-control ts-inputSemBorda"
                                        value="<?php echo $boleto['obs_pgto_banco'] ?>"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-9 border-start">
                            <div id="ts-tabs">
                                <div class="tab whiteborder" id="tab-parcela">Parcelas</div>
                                <div class="line"></div>

                                <div class="tabContent">
                                    <!-- *****************Parcelas Contrato***************** -->
                                    <div class="table table-responsive">
                                        <table class="table table-sm table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Contrato</th>
                                                    <th class="text-center">Parc</th>
                                                    <th class="text-center">Vlr Cobrado</th>
                                                    <th class="text-center">Boleto</th>
                                                </tr>
                                            </thead>
                                            <?php 
                                            if (isset($boleto["boletagparcela"])) {
                                            foreach ($parcelas as $parcela) { ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php echo $parcela['contnum'] ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $parcela['titpar'] ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo number_format($parcela['VlCobrado'], 2, ',', '') ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo $parcela['bolcod'] ?>
                                                    </td>
                                                </tr>
                                            <?php } } else { ?>
                                                <tr>
                                                    <td class="text-center">
                                                    Boleto não possui parcelas
                                                    </td>
                                                </tr>
                                            <?php   } ?>

                                        </table> 
                                    </div>
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



    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        var myModal = new bootstrap.Modal(document.getElementById("modalBoletoVisualizar"), {});
        document.onreadystatechange = function () {
            myModal.show();
        };

        var tab;
        var tabContent;

        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'parcela') {
                showTabsContent(0);
            }
            if (id === 'assinatura') {
                showTabsContent(1);
            }
        }

        document.getElementById('ts-tabs').onclick = function (event) {
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

    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>