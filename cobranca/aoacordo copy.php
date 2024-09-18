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

            <div class="col d-flex">
                <!-- TITULO -->
                <a href="aoacordo.php" style="text-decoration: none;">
                    <h6 class="ts-tituloSecundaria">Gestão de Acordos</h6>
                </a>
                <?php if ($Tipo != "") { ?>
                    &nbsp; / &nbsp;
                    <h2 class="ts-tituloPrincipal"><?php echo $Tipo ?></h2>

                <?php } ?>

            </div>

            <div class="col-2 d-flex gap-2 align-items-end justify-content-end">
                <select class="form-select ts-input" id="FiltroTipo">
                    <option value="<?php echo "null" ?>" <?php if ($Tipo == "") {echo "selected"; } ?>>Selecione</option>
                    <option value="ACORDO ONLINE" <?php if ($Tipo == "ACORDO ONLINE") {echo "selected"; } ?>>ACORDO ONLINE</option>
                    <option value="SERASA" <?php if ($Tipo == "SERASA") {echo "selected"; } ?>>SERASA</option>
                </select>
            </div>

            <div class="col d-flex">

                <div class="col-4 d-flex">
                    <input type="date" class="form-control ts-input" name="DtAcordoini" id="DtAcordoini" required>
                    <p class="mx-2" style="margin-bottom: -5px;">até</p>
                    <input type="date" class="form-control ts-input me-2" name="DtAcordofim" id="DtAcordofim" required>
                
                    <button type="submit" class="btn btn-primary" id="filtrardata">Filtrar</button>
                    <button type="submit" class="btn btn-info ms-1" onclick="limpar()">Limpar</button>
                </div>
            </div>

            <div class="col-2">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="IDAcordo" placeholder="Buscar por IDAcordo">
                    <button class="btn btn-primary rounded" type="button" id="buscarAcordo"><i class="bi bi-search"></i></button>
                </div>
            </div>

        </div>

        <!-- botão de modais que ficam escondidos -->
        <button type="button" class="btn btn-success d-none" data-bs-toggle="modal" data-bs-target="#zoomEstabModal" id="abreEstabModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>


        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>IDAcordo</th>
                        <th>Data</th>
                        <th>Estab</th>
                        <th>Cliente</th>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Valor Acordo</th>
                        <th>Dt Efetivacao</th>
                        <th>Situacao</th>
                        <th></th>
                    </tr>
                    <tr class="ts-headerTabelaLinhaBaixo">
                        <th></th>
                        <th></th>
                        <th>
                            <div class="input-group">
                                <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela mt-1 input-etbcod" placeholder="Digite Filial [ENTER]"
                                name="etbcod" id="etbcod" required>
                                <button class="btn ts-input btn-outline-secondary ts-acionaZoomEstab" type="button" id="button-etbcod" title="Fixo"><i class="bi bi-search"></i></button>
                            </div>
                        </th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela text-center" placeholder="Cliente [ENTER]"
                            name="CliFor" id="CliFor" required>
                        </th>
                        <th>
                            <input type="text" class="form-control ts-input ts-selectFiltrosHeaderTabela text-center" placeholder="Cpf/Cnpj [ENTER]"
                            name="cpfcnpj" id="cpfcnpj" required>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>

        <h6 class="fixed-bottom" id="textocontador" style="color: #13216A;"></h6>

    <!-- MODAIS DE ZOOM -->
    <?php include ROOT . '/cadastros/zoom/estab.php'; ?>

    </div><!--container-fluid-->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        $(document).ready(function() {
            var texto = $("#textocontador");
            texto.html('Total: ' + 0 + " | Valor Total Acordo: " + 0);
        });

        function limpar(){
            buscar(null,null,null,null,null,null);
        }
        //buscar($("#IDAcordo").val(), $("#DtAcordoini").val(), $("#DtAcordofim").val(), $("#CliFor").val(), $("#cpfcnpj").val(), $("#etbcod").val());

        function buscar(Tipo, IDAcordo, DtAcordoini, DtAcordofim, CliFor, cpfcnpj, etbcod) {  
            //alert(Tipo)
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/aoacordo.php?operacao=buscar',
                data: {
                    Tipo: '<?php echo $Tipo ?>',
                    IDAcordo: IDAcordo,
                    DtAcordoini: DtAcordoini,
                    DtAcordofim: DtAcordofim,
                    CliFor: CliFor,
                    cpfcnpj: cpfcnpj,
                    etbcod: etbcod
                },
                success: function(msg) {
                    //alert(msg)
                    var Tipo = '<?php echo $Tipo ?>';
                    var json = JSON.parse(msg);
                    alert(JSON.stringify(json));
                    var contadorItem = 0;
                    var contadorVlrAcordo = 0;
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        alert(object.IDAcordo)
                        var object = json[$i];
                        contadorItem += 1;
                        contadorVlrAcordo += object.VlAcordo;
                        linha = linha + "<tr>";

                        linha = linha + "<td>" + object.IDAcordo + "</td>";
                        linha = linha + "<td>" + (object.DtAcordo != "null" ? formatDate(object.DtAcordo) : "") + "</td>";
                        linha = linha + "<td>" + object.etbcod + "</td>";
                        linha = linha + "<td>" + object.clicod + "</td>";
                        linha = linha + "<td>" + object.ciccgc + "</td>";
                        linha = linha + "<td>" + object.clinom + "</td>";
                        linha = linha + "<td class='text-end'>" + object.VlAcordo.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }) + "</td>";
                        linha = linha + "<td>" + (object.DtEfetiva != "null" ? formatDate(object.DtEfetiva) : "") + "</td>";
                        linha = linha + "<td>" + object.Situacao + "</td>";


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

        $("#buscarAcordo").click(function() {
            buscar('<?php echo $Tipo ?>', $("#IDAcordo").val(), $("#DtAcordoini").val(), $("#DtAcordofim").val(), $("#CliFor").val(), $("#cpfcnpj").val(), $("#etbcod").val());
        })
        
        $("#filtrardata").click(function() {
            Tipo = $("#FiltroTipo").val();

            var url = window.location.href.split('?')[0];
            var newUrl = url + '?Tipo=' + Tipo;
            window.location.href = newUrl;

            buscar(Tipo, $("#IDAcordo").val(), $("#DtAcordoini").val(), $("#DtAcordofim").val(), $("#CliFor").val(), $("#cpfcnpj").val(), $("#etbcod").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar('<?php echo $Tipo ?>', $("#IDAcordo").val(), $("#DtAcordoini").val(), $("#DtAcordofim").val(), $("#CliFor").val(), $("#cpfcnpj").val(), $("#etbcod").val());            }
        });

        // Ao clicar no input Filial simula um click no botão do modal "Estabelecimentos"
        $(document).on('click', '.ts-acionaZoomEstab', function() {
            const elemento = document.getElementById('abreEstabModal');
            elemento.click()
        });

        // Ao selecionar um estabelecimento, passa Etbcod e munic para form inserir 
       /*  $(document).on('click', '.ts-click', function() {
            var etbcod = $(this).attr("data-etbcod");
            var munic = $(this).attr("data-munic");

            $('#inserir_Etbcod').val(etbcod);
            $('#inserir_munic').val(munic);

            $('#zoomEstabModal').modal('hide');
        }); */

        $(document).on('click', '.ts-click', function () {
            var etbcod = $(this).attr("data-etbcod");
            buscar($("#IDAcordo").val(), $("#DtAcordoini").val(), $("#DtAcordofim").val(), $("#CliFor").val(), $("#cpfcnpj").val(), etbcod);
            $('#etbcod').val(etbcod);
            $('#zoomEstabModal').modal('hide');
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

            const DtAcordoini = document.getElementById("DtAcordoini");
            DtAcordoini.value = primeirodiadomes;

            const DtAcordofim = document.getElementById("DtAcordofim");
            DtAcordofim.value = dataAtual;

        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>