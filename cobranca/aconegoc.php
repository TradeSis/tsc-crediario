<?php
//Lucas 05092024 criado
include_once(__DIR__ . '/../header.php');

$tpNegociacao = $_GET['tpNegociacao'];
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>

    <div class="container-fluid">

        <div class="row ">
            <!--<BR> MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!--<BR> BOTOES AUXILIARES -->
        </div>

        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-10">
                <h2 class="ts-tituloPrincipal">Parametrização <?php echo $tpNegociacao ?></h2>
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
                        <h5 class="modal-title" id="exampleModalLabel">Inserir <?php echo $tpNegociacao ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="inserirAcordoForm">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label ts-label">Nome</label>
                                    <input type="text" class="form-control ts-input" name="negnom" required>
                                    <input type="hidden" class="form-control ts-input" name="tpNegociacao" value="<?php echo $tpNegociacao ?>">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">inicio</label>
                                    <input type="date" class="form-control ts-input" name="dtini" id="inserir_dtini">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">final</label>
                                    <input type="date" class="form-control ts-input" name="dtfim">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">vlr contrato</label>
                                    <input type="text" class="form-control ts-input" name="vlr_total">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">perc pagas</label>
                                    <input type="text" class="form-control ts-input" name="perc_pagas">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">qtd pagas</label>
                                    <input type="text" class="form-control ts-input" name="qtd_pagas">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">emissao desde</label>
                                    <input type="date" class="form-control ts-input" name="dtemissao_de">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">ate</label>
                                    <input type="date" class="form-control ts-input" name="dtemissao_ate">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">vlr parcela</label>
                                    <input type="text" class="form-control ts-input" name="vlr_parcela">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">dias atraso</label>
                                    <input type="text" class="form-control ts-input" name="dias_atraso">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">vlr aberto</label>
                                    <input type="text" class="form-control ts-input" name="vlr_aberto">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">modalidade</label>
                                    <input type="text" class="form-control ts-input" name="modcod">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Tipo Contrato</label>
                                    <input type="text" class="form-control ts-input" name="tpcontrato">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">So Parc Vencida</label>
                                    <select class="form-select ts-input" name="ParcVencidaSo">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Qtd Parc Vencida</label>
                                    <input type="text" class="form-control ts-input" name="ParcVencidaQtd">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Qtd Parc Vencr</label>
                                    <input type="text" class="form-control ts-input" name="ParcVencerQtd">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Arrasta Outros Contratos?</label>
                                    <select class="form-select ts-input" name="Arrasta">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Permite Ctr Protesto</label>
                                    <select class="form-select ts-input" name="PermiteTitProtesto">
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
                        <h5 class="modal-title" id="exampleModalLabel">Alterar <?php echo $tpNegociacao ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="alterarAcordoForm">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label ts-label">Nome</label>
                                    <input type="text" class="form-control ts-input" name="negnom" id="negnom" required>
                                    <input type="hidden" class="form-control ts-input" name="negcod" id="negcod">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">inicio</label>
                                    <input type="date" class="form-control ts-input" name="dtini" id="dtini">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">final</label>
                                    <input type="date" class="form-control ts-input" name="dtfim" id="dtfim">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">vlr contrato</label>
                                    <input type="text" class="form-control ts-input" name="vlr_total" id="vlr_total">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">perc pagas</label>
                                    <input type="text" class="form-control ts-input" name="perc_pagas" id="perc_pagas">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">qtd pagas</label>
                                    <input type="text" class="form-control ts-input" name="qtd_pagas" id="qtd_pagas">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">emissao desde</label>
                                    <input type="date" class="form-control ts-input" name="dtemissao_de" id="dtemissao_de">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">ate</label>
                                    <input type="date" class="form-control ts-input" name="dtemissao_ate" id="dtemissao_ate">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">vlr parcela</label>
                                    <input type="text" class="form-control ts-input" name="vlr_parcela" id="vlr_parcela">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">dias atraso</label>
                                    <input type="text" class="form-control ts-input" name="dias_atraso" id="dias_atraso">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">vlr aberto</label>
                                    <input type="text" class="form-control ts-input" name="vlr_aberto" id="vlr_aberto">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">modalidade</label>
                                    <input type="text" class="form-control ts-input" name="modcod" id="modcod">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Tipo Contrato</label>
                                    <input type="text" class="form-control ts-input" name="tpcontrato" id="tpcontrato">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">So Parc Vencida</label>
                                    <select class="form-select ts-input" name="ParcVencidaSo" id="ParcVencidaSo">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Qtd Parc Vencida</label>
                                    <input type="text" class="form-control ts-input" name="ParcVencidaQtd" id="ParcVencidaQtd">
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Qtd Parc Vencr</label>
                                    <input type="text" class="form-control ts-input" name="ParcVencerQtd" id="ParcVencerQtd">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Arrasta Outros Contratos?</label>
                                    <select class="form-select ts-input" name="Arrasta" id="Arrasta">
                                        <option value="false">Nao</option>
                                        <option value="true">Sim</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label ts-label">Permite Ctr Protesto</label>
                                    <select class="form-select ts-input" name="PermiteTitProtesto" id="PermiteTitProtesto">
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

        <!--------- EXCLUIR ACORDO --------->
        <div class="modal" id="excluirAcordoModal" tabindex="-1" aria-labelledby="excluirAcordoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Excluir Acordo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" id="excluirAcordoForm">
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label ts-label">Acordo</label>
                                    <input type="text" class="form-control ts-input" name="negnom" id="excAcordo_negnom" readonly>
                                    <input type="hidden" class="form-control ts-input" name="id_recid" id="excAcordo_id_recid">
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
                        <th style="width: 40px;">ID</th>
                        <th class="text-start">companha</th>
                        <th>inicio</th>
                        <th>final</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>

        <h6 class="fixed-bottom" id="textocontador" style="color: #13216A;"></h6>


    </div><!--container-fluid-->

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
                url: '../database/aconegoc.php?operacao=buscar',
                data: {
                    tpNegociacao: '<?php echo $tpNegociacao ?>'
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
                        linha = linha + "<tr>";

                        linha = linha + "<td>" + object.negcod + "</td>";
                        linha = linha + "<td class='text-start'>" + object.negnom + "</td>";
                        linha = linha + "<td>" + formatDate(object.dtini) + "</td>";
                        linha = linha + "<td>" + formatDate(object.dtfim) + "</td>";
                        // linha = linha + "<td class='text-end pe-2'><a class=' btn btn-warning btn-sm' href='acordoonline_alterar.php?negcod=" + object.negcod + "' role='button'><i class='bi bi-pencil-square'></i></a> ";
                        linha = linha + "<td class='text-end'><button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarModal'";
                        linha = linha + " data-negcod='" + object.negcod + "' ";
                        linha = linha + "><i class='bi bi-pencil-square'></i></button>";

                        linha = linha + "<a class='btn btn-info btn-sm ms-1' href='acoplanos.php?tpNegociacao=" + tpNegociacao + "&negcod=" + object.negcod + "&negnom=" + object.negnom + "' role='button'><i class='bi bi-eye'></i></a> ";

                        linha = linha + "<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#excluirAcordoModal'";
                        linha = linha + " data-negnom='" + object.negnom + "' ";
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
            var negcod = $(this).attr("data-negcod");
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/aconegoc.php?operacao=buscar',
                data: {
                    tpNegociacao: '<?php echo $tpNegociacao ?>',
                    negcod: negcod
                },
                success: function(data) {
                    //alert(data.Arrasta)
                    $('#negcod').val(data.negcod);
                    $('#negnom').val(data.negnom);
                    $('#dtini').val(data.dtini);
                    $('#dtfim').val(data.dtfim);
                    $('#vlr_total').val(data.vlr_total);
                    $('#perc_pagas').val(data.perc_pagas);
                    $('#qtd_pagas').val(data.qtd_pagas);
                    $('#dtemissao_de').val(data.dtemissao_de);
                    $('#dtemissao_ate').val(data.dtemissao_ate);
                    $('#vlr_parcela').val(data.vlr_parcela);
                    $('#dias_atraso').val(data.dias_atraso);
                    $('#vlr_aberto').val(data.vlr_aberto);
                    $('#modcod').val(data.modcod);
                    $('#tpcontrato').val(data.tpcontrato);
                    ParcVencidaSo = data.ParcVencidaSo == true ? "true" : "false";
                    $('#ParcVencidaSo').val(ParcVencidaSo);
                    $('#ParcVencidaQtd').val(data.ParcVencidaQtd);
                    $('#ParcVencerQtd').val(data.ParcVencerQtd);
                    Arrasta = data.Arrasta == true ? "true" : "false";
                    $('#Arrasta').val(Arrasta);
                    PermiteTitProtesto = data.PermiteTitProtesto == true ? "true" : "false";
                    $('#PermiteTitProtesto').val(PermiteTitProtesto);

                    $('#alterarModal').modal('show');
                }
            });
        });

        // MODAL PLANOS EXCLUIR
        $(document).on('click', 'button[data-bs-target="#excluirAcordoModal"]', function() {
            var negnom = $(this).attr("data-negnom");
            var id_recid = $(this).attr("data-id_recid");

            $('#excAcordo_negnom').val(negnom);
            $('#excAcordo_id_recid').val(id_recid);

            $('#excluirAcordoModal').modal('show');

        });

        $("#inserirAcordoForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/aconegoc.php?operacao=inserir",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: refreshPage
            });
        });

        $("#alterarAcordoForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/aconegoc.php?operacao=alterar",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: refreshPage
            });
        });

        $("#excluirAcordoForm").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/aconegoc.php?operacao=excluir",
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