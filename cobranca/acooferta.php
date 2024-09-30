<?php
//Lucas 05092024 criado
include_once(__DIR__ . '/../header.php');
include_once '../database/acooferta.php';

$tpNegociacao = isset($_POST['tpNegociacao']) ? $_POST['tpNegociacao'] : $_GET['tpNegociacao'];


$cpfCnpj = null;

$codigoCliente = isset($_POST['codigoCliente']) ? $_POST['codigoCliente'] : $_GET['codigoCliente'];
if($codigoCliente == ''){
    $codigoCliente = null; 
}
if (isset($_POST['cpfCnpj'])) {
    $cpfCnpj = $_POST['cpfCnpj'];
}


$ofertaAcordo = buscaOfertasAcordoOnline($tpNegociacao, $codigoCliente, $cpfCnpj);
$cliente = $ofertaAcordo["cliente"][0];
$clicod = $cliente['clicod'];

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <style>
        input[readonly] {
            background-color: transparent !important;
        }
    </style>
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
                    <div class="col-sm-10">
                        <h4>Ofertas <?php echo $tpNegociacao ?></h4>
                    </div>
                    <div class="col-sm" style="text-align:right">
                        <a href="index.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                    </div>
                </div>
            </div>


            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col">
                        Cod. Cliente: <?php echo $cliente['clicod'] ?>
                    </div>
                    <div class="col">
                        CPF/CNPJ: <?php echo $cliente['cpfCNPJ'] ?>
                    </div>
                    <div class="col">
                        Nome: <?php echo $cliente['clinom'] ?>
                    </div>
                    <div class="col">
                        Fil Cad.: <?php echo $cliente['etbcad'] ?>
                    </div>
                </div>

                <hr>
                <div class="container-fluid mt-2">
                    <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
                        <table class="table table-sm table-hover">
                            <thead class="ts-headertabelafixo">
                                <tr class="ts-headerTabelaLinhaCima">
                                    <th style="width: 40px;">ID</th>
                                    <th class="text-start">campanha</th>
                                    <th style="width: 60px;">qtd</th>
                                    <th>aberto</th>
                                    <th>divida</th>
                                    <th style="width: 60px;">sel</th>
                                    <th>sel aberto</th>
                                    <th>sel total</th>
                                    <th style="width: 60px;"></th>
                                </tr>
                            </thead>

                            <tbody id='dados' class="fonteCorpo">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        $(document).ready(function() {
            var texto = $("#textocontador");
            texto.html('total: ' + 0);
        });
        buscar()

        function buscar() {
            //alert(FiltroPortador)
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/acooferta.php?operacao=buscar',
                data: {
                    ptpnegociacao: '<?php echo $tpNegociacao ?>',
                    clicod: <?php echo $clicod ?>
                },
                success: function(msg) {
                    console.log(msg);
                    var tpNegociacao = '<?php echo $tpNegociacao ?>';
                    var json = JSON.parse(msg);
                    var linha = "";

                    var ofertas = json.acooferta;
                    for (var i = 0; i < ofertas.length; i++) {
                        var object = ofertas[i];
                        linha += "<tr>";
                        linha += "<td>" + object.negcod + "</td>";
                        linha += "<td class='text-start'>" + object.negnom + "</td>";
                        linha += "<td>" + object.qtd + "</td>";
                        linha += "<td>" + object.vlr_aberto + "</td>";
                        linha += "<td>" + object.vlr_divida + "</td>";
                        linha += "<td>" + object.qtd_selecionado + "</td>";
                        linha += "<td>" + object.vlr_selaberto + "</td>";
                        linha += "<td>" + object.vlr_selecionado + "</td>";
                        linha += "<td><a class='btn btn-info btn-sm ms-1' href='visualizar_acooferta.php?tpNegociacao=" + tpNegociacao + "&clicod=" + <?php echo $clicod ?> + "&negcod=" + object.negcod + "' role='button'><i class='bi bi-eye'></i></a></td>";
                        linha += "</tr>";
                    }

                    $("#dados").html(linha);
                }
            });
        }
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>