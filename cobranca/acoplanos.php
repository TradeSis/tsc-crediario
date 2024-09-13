<?php
// Lucas 05092024
include_once('../header.php');
include_once('../database/aconegoc.php');

$tpNegociacao = $_GET['tpNegociacao'];
$negcod = $_GET['negcod'];
$acordo = buscaAcordoOnline($tpNegociacao, $negcod);

$dtini = ($acordo['dtini'] != null ? date('d/m/Y', strtotime($acordo['dtini'])) : "");
$dtfim = ($acordo['dtfim'] != null ? date('d/m/Y', strtotime($acordo['dtfim'])) : "");


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
                <h2 class="ts-tituloPrincipal"><?php echo $_GET['negnom'] ?></h2>

            </div>
            <div class="col-3">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <hr>
        <div class="row d-flex align-items-center justify-content-center">

        
            <div class="col-10 d-flex gap-2">
                <div class="col-2">
                    <label class="form-label ts-label">inicio</label>
                    <input type="text" class="form-control ts-input" value="<?php echo $dtini ?>" disabled>
                </div>
                <div class="col-2">
                    <label class="form-label ts-label">final</label>
                    <input type="text" class="form-control ts-input" value="<?php echo $dtfim ?>" disabled>
                </div>
            </div>

            <div class="col-2 text-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>

        </div>

        <!--------- INSERIR --------->
        <div class="modal" id="inserirModal" tabindex="-1" aria-labelledby="inserirModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inserir Plano</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="inserirForm">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label ts-label">Nome</label>
                                    <input type="text" class="form-control ts-input" name="planom">
                                    <input type="hidden" class="form-control ts-input" name="negcod" value="<?php echo $negcod ?>">
                                    <input type="hidden" class="form-control ts-input" name="id_recid" value="<?php echo $acordo["id_recid"] ?>">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Calc Juro titula</label>
                                    <select class="form-select ts-input" name="calc_juro_titulo">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <!-- SIM-habilita proxima col -->
                                    <label class="form-label ts-label">Com Entrada</label>
                                    <select class="form-select ts-input" name="com_entrada">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Perc Min Entrada</label>
                                    <input type="text" class="form-control ts-input" name="perc_min_entrada">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">dias primeira</label>
                                    <input type="text" class="form-control ts-input" name="dias_max_primeira">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">perc_desconto</label>
                                    <input type="text" class="form-control ts-input" name="perc_desconto">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">valor desc</label>
                                    <input type="text" class="form-control ts-input" name="valor_desc">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">perc_acres</label>
                                    <input type="text" class="form-control ts-input" name="perc_acres">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">valor acres</label>
                                    <input type="text" class="form-control ts-input" name="valor_acres">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Vezes</label>
                                    <input type="text" class="form-control ts-input" name="qtd_vezes">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">permite alteracao</label>
                                    <select class="form-select ts-input" name="permite_alt_vezes">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal" id="alterarModal" tabindex="-1" aria-labelledby="alterarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">alterar Plano</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="alterarForm">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label ts-label">Nome</label>
                                    <input type="text" class="form-control ts-input" name="planom" id="planom" readonly>
                                    <input type="hidden" class="form-control ts-input" name="placod" id="placod">
                                    <input type="hidden" class="form-control ts-input" name="negcod" value="<?php echo $negcod ?>">
                                    <input type="hidden" class="form-control ts-input" name="id_recid_plan" id="id_recid_plan">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Calc Juro titula</label>
                                    <select class="form-select ts-input" name="calc_juro_titulo" id="calc_juro_titulo">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <!-- SIM-habilita proxima col -->
                                    <label class="form-label ts-label">Com Entrada</label>
                                    <select class="form-select ts-input" name="com_entrada" id="com_entrada">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Perc Min Entrada</label>
                                    <input type="text" class="form-control ts-input" name="perc_min_entrada" id="perc_min_entrada">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">dias primeira</label>
                                    <input type="text" class="form-control ts-input" name="dias_max_primeira" id="dias_max_primeira">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">perc_desconto</label>
                                    <input type="text" class="form-control ts-input" name="perc_desconto" id="perc_desconto">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">valor desc</label>
                                    <input type="text" class="form-control ts-input" name="valor_desc" id="valor_desc">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">perc_acres</label>
                                    <input type="text" class="form-control ts-input" name="perc_acres" id="perc_acres">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">valor acres</label>
                                    <input type="text" class="form-control ts-input" name="valor_acres" id="valor_acres">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Vezes</label>
                                    <input type="text" class="form-control ts-input" name="qtd_vezes" id="qtd_vezes">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">permite alteracao</label>
                                    <select class="form-select ts-input" name="permite_alt_vezes" id="permite_alt_vezes">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
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

        <!--------- EXCLUIR --------->
        <div class="modal" id="excluirPlanoModal" tabindex="-1" aria-labelledby="excluirPlanoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Excluir Plano</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="excluirPlanoForm">
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Plano</label>
                                    <input type="text" class="form-control ts-input" name="planom" id="excPlano_planom" readonly>
                                    <input type="hidden" class="form-control ts-input" name="id_recid" id="excPlano_id_recid">
                                </div>
                            </div>

                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Deletar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th style="width: 40px;">Plan</th>
                        <th class="text-start">Plano</th>
                        <th>J</th>
                        <th>Ent</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Vezes</th>
                        <th>desc</th>
                        <th>% acres</th>
                        <th>vlr acres</th>
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
                url: '../database/acoplanos.php?operacao=buscar',
                data: {
                    negcod: '<?php echo $negcod ?>'
                },
                success: function(msg) {
                    var tpNegociacao = '<?php echo $tpNegociacao ?>';
                    var json = JSON.parse(msg);
                    //alert(JSON.stringify(json));
                    var contadorItem = 0;
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        contadorItem += 1;

                        calc_juro_titulo = object.calc_juro_titulo == true ? "S" : "N";
                        com_entrada = object.com_entrada == true ? "Sim" : "Nao";
                        linha = linha + "<tr>";

                        linha = linha + "<td>" + object.placod + "</td>";
                        linha = linha + "<td class='text-start'>" + object.planom + "</td>";
                        linha = linha + "<td>" + calc_juro_titulo + "</td>";
                        linha = linha + "<td>" + com_entrada + "</td>";
                        linha = linha + "<td>" + object.perc_min_entrada + "</td>";
                        linha = linha + "<td>" + object.dias_max_primeira + "</td>";
                        linha = linha + "<td>" + object.qtd_vezes + "</td>";
                        linha = linha + "<td>" + object.perc_desconto + "</td>";
                        linha = linha + "<td>" + object.perc_acres + "</td>";
                        linha = linha + "<td>" + object.valor_acres + "</td>";
                        linha = linha + "<td class='text-end'><button type='button' class='btn btn-warning btn-sm me-1' data-bs-toggle='modal' data-bs-target='#alterarModal'";
                        linha = linha + " data-placod='" + object.placod + "' ";
                        linha = linha + "><i class='bi bi-pencil-square'></i></button>";

                        linha = linha + "<a class='btn btn-info btn-sm' href='acoplanparcel.php?tpNegociacao=" + tpNegociacao + "&negcod=" + object.negcod + "&placod=" + object.placod + "' role='button'><i class='bi bi-eye'></i></a> ";

                        linha = linha + "<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#excluirPlanoModal'";
                        linha = linha + " data-planom='" + object.planom + "' ";
                        linha = linha + " data-id_recid='" + object.id_recid + "' ";
                        linha = linha + "><i class='bi bi-trash'></i></button></td>";

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
            var placod = $(this).attr("data-placod");
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/acoplanos.php?operacao=buscar',
                data: {
                    placod: placod,
                    negcod: '<?php echo $negcod ?>'
                },
                success: function(data) {
                    //alert(data.id_recid)
                    $('#id_recid_plan').val(data.id_recid);
                    $('#negcod').val(data.negcod);
                    $('#placod').val(data.placod);
                    $('#planom').val(data.planom);
                    calc_juro_titulo = data.calc_juro_titulo == true ? "true" : "false";
                    $('#calc_juro_titulo').val(calc_juro_titulo);
                    com_entrada = data.com_entrada == true ? "true" : "false";
                    $('#com_entrada').val(com_entrada);
                    $('#perc_min_entrada').val(data.perc_min_entrada);
                    $('#dias_max_primeira').val(data.dias_max_primeira);
                    $('#qtd_vezes').val(data.qtd_vezes);
                    $('#perc_desconto').val(data.perc_desconto);
                    $('#perc_acres').val(data.perc_acres);
                    permite_alt_vezes = data.permite_alt_vezes == true ? "true" : "false";
                    $('#permite_alt_vezes').val(permite_alt_vezes);
                    $('#valor_acres').val(data.valor_acres);
                    $('#valor_desc').val(data.valor_desc);

                    $('#alterarModal').modal('show');
                }
            });
        });

        // MODAL PLANOS EXCLUIR
        $(document).on('click', 'button[data-bs-target="#excluirPlanoModal"]', function() {
            var planom = $(this).attr("data-planom");
            var id_recid = $(this).attr("data-id_recid");

            $('#excPlano_planom').val(planom);
            $('#excPlano_id_recid').val(id_recid);

            $('#excluirPlanoModal').modal('show');

        });

        $("#inserirForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/acoplanos.php?operacao=inserir",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: refreshPage
            });
        });

        $("#alterarForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/acoplanos.php?operacao=alterar",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: refreshPage
            });
        });

        $("#excluirPlanoForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/acoplanos.php?operacao=excluir",
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

            //modal inserir contaspagar
            const inserir_dtini = document.getElementById("inserir_dtini");
            inserir_dtini.value = dataAtual;

        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>