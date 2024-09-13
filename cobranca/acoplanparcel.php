<?php
// Lucas 10092024
include_once('../header.php');
include_once('../database/aconegoc.php');
include_once('../database/acoplanos.php');
include_once('../database/acoplanparcel.php');

$tpNegociacao = $_GET['tpNegociacao'];
$negcod = $_GET['negcod'];
$placod = $_GET['placod'];

$acordo = buscaAcordoOnline($tpNegociacao, $negcod);
$plano = buscaPlano($negcod, $placod);
$parcela = buscaParcelaAcordo($negcod, $placod);

$calc_juro_titulo = ($plano['calc_juro_titulo'] == true ? "Sim" : "Não");
$com_entrada = ($plano['com_entrada'] == true ? "Sim" : "Não");
?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>


<body>

    <div class="container-fluid">

        <div class="row">
            <!--<BR> MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!--<BR> MENSAGENS/ALERTAS -->
        </div>
        <div class="row mt-2"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-7 d-flex">
                <!-- TITULO -->
                <a href="aconegoc.php?tpNegociacao=<?php echo $tpNegociacao ?>" style="text-decoration: none;">
                    <h6 class="ts-tituloSecundaria">Parametrização Acordo Online</h6>
                </a> &nbsp; / &nbsp;
                <a href="acoplanos.php?tpNegociacao=<?php echo $tpNegociacao ?>&negcod=<?php echo $acordo['negcod'] ?>&negnom=<?php echo $acordo['negnom'] ?>" style="text-decoration: none;">
                    <h6 class="ts-tituloSecundaria"><?php echo $acordo['negnom'] ?></h6>
                </a> / &nbsp;
                <h2 class="ts-tituloPrincipal"><?php echo $plano['planom'] ?></h2>

            </div>
            <div class="col-3">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>
        <hr>
        <div class="row d-flex gap-2">

            <div class="col-2">
                <label class="form-label ts-label">Plan</label>
                <input type="text" class="form-control ts-input" value="<?php echo $plano['placod'] ?>" disabled>
            </div>
            <div class="col">
                <label class="form-label ts-label">Plano</label>
                <input type="text" class="form-control ts-input" value="<?php echo $plano['planom'] ?>" disabled>
            </div>
            <div class="col-1">
                <label class="form-label ts-label">J</label>
                <input type="text" class="form-control ts-input" value="<?php echo $calc_juro_titulo ?>" disabled>
            </div>
            <div class="col-1">
                <label class="form-label ts-label">Ent</label>
                <input type="text" class="form-control ts-input" value="<?php echo $com_entrada ?>" disabled>
            </div>
            <div class="col-1">
                <label class="form-label ts-label">Min</label>
                <input type="text" class="form-control ts-input" value="<?php echo $plano['perc_min_entrada'] ?>" disabled>
            </div>
            <div class="col-1">
                <label class="form-label ts-label">Max</label>
                <input type="text" class="form-control ts-input" value="<?php echo $plano['dias_max_primeira'] ?>" disabled>
            </div>
            <div class="col-1">
                <label class="form-label ts-label">Vezes</label>
                <input type="text" class="form-control ts-input" value="<?php echo $plano['qtd_vezes'] ?>" disabled>
            </div>

        </div>

        <!--------- ALTERAR --------->
        <div class="modal" id="alterarModal" tabindex="-1" aria-labelledby="alterarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alterar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="alterarForm">
                            <div class="row">
                                <div class="col-2">
                                    <label class="form-label ts-label">PC</label>
                                    <input type="text" class="form-control ts-input" name="titpar" id="titpar" readonly>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Perc</label>
                                    <input type="text" class="form-control ts-input" name="perc_parcela" id="perc_parcela">
                                    <input type="hidden" class="form-control ts-input" name="id_recid_plan" value="<?php echo $plano['id_recid'] ?>">

                                    <input type="hidden" class="form-control ts-input" name="negcod" value="<?php echo $negcod ?>">
                                    <input type="hidden" class="form-control ts-input" name="placod" value="<?php echo $placod ?>">
                                </div>
                            </div>

                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>PC</th>
                        <th>Perc</th>

                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>

        <h6 class="fixed-bottom" id="textocontador" style="color: #13216A;"></h6>

    </div><!-- container-fluid -->

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
                url: '../database/acoplanparcel.php?operacao=buscar',
                data: {
                    negcod: '<?php echo $negcod ?>',
                    placod: '<?php echo $placod ?>'
                },
                success: function(msg) {
                    //alert(msg)
                    var json = JSON.parse(msg);
                    //alert(JSON.stringify(json));
                    var contadorItem = 0;
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        contadorItem += 1;

                        linha = linha + "<tr>";

                        linha = linha + "<td>" + object.titpar + "</td>";
                        linha = linha + "<td>" + object.perc_parcela + "</td>";

                        linha = linha + "<td class='text-end'><button type='button' class='btn btn-warning btn-sm me-2' data-bs-toggle='modal' data-bs-target='#alterarModal'";
                        linha = linha + " data-titpar='" + object.titpar + "' ";
                        linha = linha + " data-perc_parcela='" + object.perc_parcela + "' ";
                        linha = linha + "><i class='bi bi-pencil-square'></i></button></td>";

                        linha = linha + "</tr>";
                    }

                    $("#dados").html(linha);

                    var texto = $("#textocontador");
                    texto.html('Total: ' + contadorItem);

                }
            });


        }

        // MODAL ALTERAR
        $(document).on('click', 'button[data-bs-target="#alterarModal"]', function() {
            var titpar = $(this).attr("data-titpar");
            var perc_parcela = $(this).attr("data-perc_parcela");

            $('#titpar').val(titpar);
            $('#perc_parcela').val(perc_parcela);

            $('#alterarModal').modal('show');
        });

        $("#alterarForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/acoplanparcel.php?operacao=alterar",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: refreshPage
            });
        });


        function refreshPage() {
            window.location.reload();
        }
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>