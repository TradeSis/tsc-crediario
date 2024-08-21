<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 23022023 09:50

include_once '../header.php';
include_once '../database/crediariocontrato.php';

if (isset ($_GET['parametros'])) {
    $numeroContrato = $_POST['numeroContrato'];
}
if (isset ($_GET['numeroContrato'])) {
    $numeroContrato = $_GET['numeroContrato'];
}


$contrato = buscaContratos($numeroContrato);
$contrato = $contrato[0];
$parcelas = $contrato["parcelas"];
$produtos = $contrato["produtos"];

$assinatura = buscaAssinatura($numeroContrato);

if (URL !== "localhost") {
    $barramento = chamaAPI( IPBARRAMENTO,
                    "/gateway/lebes-repo-img-biometria/1.0/registration-face/".
                            $assinatura["etbcod"]."/".
                            $assinatura["dtinclu"]."/".
                            $assinatura["cxacod"]."/".
                            $assinatura["cpfCNPJ"]."/".
                            $assinatura["idBiometria"],
                    null,
                    "GET");
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


<body class="ts-noScroll">
    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-8 text-center">
                        <!-- TITULO -->
                        <h4>Contrato <?php echo $contrato['numeroContrato'] ?></h4>
                    </div>
                    <div class="col-sm-2" style="text-align:right">
                        <?php if (isset($_GET['origem']) && $_GET['origem'] === 'cliente') { ?>
                            <a href="historico_cliente.php?codigoCliente=<?php echo $contrato['codigoCliente'] ?>" role="button"
                                class="btn btn-primary btn-sm">Voltar</a>
                        <?php } else { ?>
                            <a href="#" onclick="history.back()" role="button" class="btn btn-primary btn-sm">Voltar</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-3">
                <!-- ROW1 DADOS CONTRATO -->
                <div class="row mt-2">
                    <div class="col-2 d-flex align-items-center">
                        <div class="form-group">
                            <label>Contrato&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $contrato['numeroContrato'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Cliente&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $contrato['codigoCliente'] ?> - <?php echo $contrato['nomeCliente'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <div class="form-group">
                            <label>CPF/CNPJ&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $contrato['cpfCNPJ'] ?>" readonly>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <div class="form-group">
                            <label>idAdesaoHubSeg&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $contrato['idAdesaoHubSeg'] ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Data&nbsp;Inicial&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo date('d/m/Y', strtotime($contrato['dtemissao'])) ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Loja&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $contrato['etbnom'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Banco&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $contrato['banco'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Cod.&nbsp;Modalidade&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $contrato['modalidade'] ?>" readonly>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-group">
                            <label>Qtd.&nbsp;Parcelas&nbsp;:&nbsp;</label>
                        </div>
                        <input type="text" class="form-control ts-input" value="<?php echo $contrato['nro_parcelas'] ?>" readonly>
                    </div>
                </div>
                <!-- ROW1 fim -->
                <hr>
                <div id="ts-tabs">
                    <div class="tab whiteborder" id="tab-nfe">Dados Contrato</div>
                    <div class="tab" id="tab-parcela">Parcelas</div>
                <!--  *****Produtos comentados at� possuir dados reais
                    <div class="tab" id="tab-produ">Produtos</div> -->
                    <div class="tab" id="tab-assinatura">Assinatura</div>

                    <div class="line"></div>

                    <div class="tabContent">
                        <!-- *****************NOTAFISCAL***************** -->
                        <div class="row">
                            <div class="col">
                                <label>Contrato</label>
                                <input type="text" class="form-control" value="<?php echo $contrato['numeroContrato'] ?>"
                                    readonly>
                                <label>Cliente</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $contrato['codigoCliente'] ?> - <?php echo $contrato['nomeCliente'] ?>"
                                    readonly>
                                <label>Estabelecimento</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $contrato['etbnom'] ?>" readonly>
                            </div>
                            <div class="col">
                                <label>Data Inicial</label>
                                <input type="text" class="form-control"
                                    value="<?php echo date('d/m/Y', strtotime($contrato['dtemissao'])) ?>" readonly>
                                <label>Situação</label>
                                <input type="text" class="form-control" value="<?php echo $contrato['situacao'] ?>"
                                    readonly>
                                <label>Modalidade</label>
                                <input type="text" class="form-control" value="<?php echo $contrato['modalidade'] ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="row">
                            <h6>Valores</h6>
                            <div class="col-md">
                                <label>Total</label>
                                <input type="text" class="form-control" value="<?php echo $contrato['valorTotal'] ?>"
                                    readonly>
                            </div>
                            <div class="col-md">
                                <label>Aberto</label>
                                <input type="text" class="form-control" value="<?php echo $contrato['valorAberto'] ?>"
                                    readonly>
                            </div>
                            <div class="col-md">
                                <label>Vencido</label>
                                <input type="text" class="form-control" value="<?php echo $contrato['valorVencido'] ?>"
                                    readonly>
                            </div>
                            <div class="col-md">
                                <label>Entrada</label>
                                <input type="text" class="form-control" value="<?php echo $contrato['valorEntrada'] ?>"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="tabContent">
                        <!-- *****************Parcelas Contrato***************** -->
                        <div class="table table-responsive">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Contrato</th>
                                        <th class="text-center">Parc</th>
                                        <th class="text-center">Dt Venc</th>
                                        <th class="text-center">Parc</th>
                                        <th class="text-center">Sit</th>
                                        <th class="text-center">Dt Pag</th>
                                        <th class="text-center">Pag</th>
                                    </tr>
                                </thead>
                                <?php foreach ($parcelas as $parcela) { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php echo $parcela['numeroContrato'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $parcela['parcela'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo date('d/m/Y', strtotime($parcela['dtVencimento'])) ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $parcela['vlrParcela'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $parcela['situacao'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($parcela['dtPagamento'] !== null) {
                                                echo date('d/m/Y', strtotime($parcela['dtPagamento']));
                                            } ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $parcela['vlrPago'] ?>
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
                                <div class="col-md">
                                    <label>etbcod</label>
                                    <input type="text" class="form-control" value="<?php echo isset($assinatura['etbcod']) ? $assinatura['etbcod'] : '' ?>"
                                        readonly>
                                </div>
                                <label>Data de Inclusão</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($assinatura['dtinclu']) ? date('d/m/Y', strtotime($assinatura['dtinclu'])) : '' ?>" readonly>
                                <label>idBiometria</label>
                                <input type="text" class="form-control" value="<?php echo isset($assinatura['idBiometria']) ? $assinatura['idBiometria'] : ''?>"
                                    readonly>
                            </div>
                            <div class="col text-center">
                                <img src="<?php echo 'data:image/png;base64,' . $foto ?>" class="img-fluid" alt="Image Preview"
                                    style="max-width: 150px; max-height: 150px;">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label>clicod</label>
                                <input type="text" class="form-control" value="<?php echo isset($assinatura['clicod']) ? $assinatura['clicod'] : '' ?>"
                                    readonly>
                            </div>
                            <div class="col-md">
                                <label>Cpf/Cnpj</label>
                                <input type="text" class="form-control" value="<?php echo isset($assinatura['cpfCNPJ']) ? $assinatura['cpfCNPJ'] : '' ?>" readonly>
                            </div>
                            <div class="col-md">
                                <label>Data de Processamento</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($assinatura['dtproc']) && $assinatura['dtproc'] !== null ? date('d/m/Y', strtotime($assinatura['dtproc'])) : '' ?>"
                                    readonly>
                            </div>
                            <div class="col-md">
                                <label>hrproc</label>
                                <input type="text" class="form-control" value="<?php echo isset($assinatura['hrproc']) ? $assinatura['hrproc'] : '' ?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label>etbcod</label>
                                <input type="text" class="form-control" value="<?php echo isset($assinatura['etbcod']) ? $assinatura['etbcod'] : '' ?>"
                                    readonly>
                            </div>
                            <div class="col-md">
                                <label>cxacod</label>
                                <input type="text" class="form-control" value="<?php echo isset($assinatura['cxacod']) ? $assinatura['cxacod'] : '' ?>"
                                    readonly>
                            </div>
                            <div class="col-md">
                                <label>ctmcod</label>
                                <input type="text" class="form-control" value="<?php echo isset($assinatura['ctmcod']) ? $assinatura['ctmcod'] : '' ?>"
                                    readonly>
                            </div>
                            <div class="col-md">
                                <label>nsu</label>
                                <input type="text" class="form-control" value="<?php echo isset($assinatura['nsu']) ? $assinatura['nsu'] : '' ?>" readonly>
                            </div>
                        </div>
                        <?php if(isset($assinatura['urlPdf'])) { ?>
                            <div class="mt-2" style="text-align:right">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPDF" data-pdf="<?php echo $assinatura['urlPdf'] ?>">Contrato PDF</button>
                            </div>
                            <div class="mt-2" style="text-align:right">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPDF" data-pdf="<?php echo $assinatura['urlPdfAss'] ?>">Contrato Assinado</button>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!--------- MODAL PDF --------->
<div class="modal" id="modalPDF" tabindex="-1" role="dialog" aria-labelledby="modalPDFLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ExternalFiles full-width">
                    <iframe class="container-fluid full-width" id="myIframe" src="" frameborder="0" scrolling="yes" height="550"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        var tab;
        var tabContent;

        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'parcela') {
                showTabsContent(1);
            }
            /* if (id === 'produ') {
                showTabsContent(2);
            } */
            if (id === 'assinatura') {
                showTabsContent(2);
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

        var modalPDF = document.getElementById('modalPDF');
        modalPDF.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var pdfUrl = button.getAttribute('data-pdf'); // Extract info from data-* attributes
            var iframe = modalPDF.querySelector('iframe');
            iframe.src = pdfUrl; // Set iframe src to the PDF URL
        });

    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>