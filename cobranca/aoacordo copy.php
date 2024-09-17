<?php
//Lucas 13092024 criado
include_once(__DIR__ . '/../header.php');

$Tipo = "";
if (isset($_GET['Tipo']) && $_GET['Tipo'] != "null") {
    $Tipo = $_GET['Tipo'];
}
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

            <div class="col-6 d-flex">
                <!-- TITULO -->
                <a href="aoacordo.php" style="text-decoration: none;">
                    <h6 class="ts-tituloSecundaria">Gestão de Acordos</h6>
                </a>
                <?php if ($Tipo != "") { ?>
                    &nbsp; / &nbsp;
                    <h2 class="ts-tituloPrincipal">Acordo de Cobrança - Via <?php echo $Tipo ?></h2>

                <?php } ?>

            </div>

            <div class="col-6 d-flex gap-2 align-items-end justify-content-end">
                <div class="col-4">
                    <select class="form-select ts-input" id="FiltroTipo">
                        <?php if ($Tipo == "") { ?>
                            <option value="<?php echo "null" ?>">Selecione</option>
                            <option value="ACORDO ONLINE">ACORDO ONLINE</option>
                            <option value="SERASA">SERASA</option>
                        <?php } else { ?>
                            <option <?php
                                    echo "selected";

                                    ?> value="<?php echo $Tipo ?>">
                                <?php echo $Tipo ?>
                            </option>
                            <option value="<?php echo "null" ?>">Selecione</option>
                            <option value="ACORDO ONLINE">ACORDO ONLINE</option>
                            <option value="SERASA">SERASA</option>

                        <?php } ?>

                    </select>
                </div>
                <div class="col-1">
                    <button type="submit" class="btn btn-primary btn-sm" id="filtrarTipo">Filtrar</button>
                </div>
            </div>

        </div>


        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>ID Acordo</th>
                        <th>Estab</th>
                        <th>Cli/For</th>
                        <th>Situacao</th>
                        <th>Dt Acordo</th>
                        <th>Hora</th>
                        <th>Dt Efetivacao</th>
                        <th>Hr</th>
                        <th>Vlr ori</th>
                        <th>Vlr Acordo</th>
                        <th>DtVincula</th>
                        <th>Tipo</th>
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
            texto.html('Total: ' + 0 + " | Valor Total Acordo: " + 0);
        });
        buscar()

        function buscar() {
            //alert(FiltroPortador)
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/aoacordo.php?operacao=buscar',
                data: {
                    Tipo: '<?php echo $Tipo ?>'
                },
                success: function(msg) {
                    var Tipo = '<?php echo $Tipo ?>';
                    var json = JSON.parse(msg);
                    //alert(JSON.stringify(json));
                    var contadorItem = 0;
                    var contadorVlrAcordo = 0;
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];
                        contadorItem += 1;
                        contadorVlrAcordo += object.VlAcordo;
                        linha = linha + "<tr>";

                        linha = linha + "<td>" + object.IDAcordo + "</td>";
                        linha = linha + "<td>" + object.etbcod + "</td>";
                        linha = linha + "<td>" + object.CliFor + "</td>";
                        linha = linha + "<td>" + object.Situacao + "</td>";
                        linha = linha + "<td>" + (object.DtAcordo != "null" ? formatDate(object.DtAcordo) : "") + "</td>";
                        linha = linha + "<td>" + object.HrAcordo + "</td>";
                        linha = linha + "<td>" + (object.DtEfetiva != "null" ? formatDate(object.DtEfetiva) : "") + "</td>";
                        linha = linha + "<td>" + object.HrEfetiva + "</td>";
                        linha = linha + "<td class='text-end'>" + object.VlOriginal.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }) + "</td>";
                        linha = linha + "<td class='text-end'>" + object.VlAcordo.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }) + "</td>";
                        linha = linha + "<td>" + (object.DtVinculo != "null" ? formatDate(object.DtVinculo) : "") + "</td>";
                        linha = linha + "<td>" + object.Tipo + "</td>";

                        linha = linha + "<td class='text-end'>";

                        linha = linha + "<a class='btn btn-info btn-sm ms-1' href='aoacordo_visualizar.php?Tipo=" + Tipo + "&IDAcordo=" + object.IDAcordo + "' role='button'><i class='bi bi-eye'></i></a> ";

                        linha = linha + "</td>";

                        linha = linha + "</tr>";
                    }

                    $("#dados").html(linha);

                    var texto = $("#textocontador");
                    contadorVlrAcordoFormat = contadorVlrAcordo.toLocaleString('pt-br', {
                        minimumFractionDigits: 2
                    });
                    texto.html('Total: ' + contadorItem + " | Valor Total Acordo: " + contadorVlrAcordoFormat);

                }
            });


        }

        $("#filtrarTipo").click(function() {
            Tipo = $("#FiltroTipo").val();

            var url = window.location.href.split('?')[0];
            var newUrl = url + '?Tipo=' + Tipo;
            window.location.href = newUrl;
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
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>