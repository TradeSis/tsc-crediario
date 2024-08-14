<?php
include_once '../header.php';
include_once '../database/termos.php';

$termo = buscaTermos($_GET['IDtermo']);
$mnemos = buscaMnemos();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link href="termos.css" rel="stylesheet" type="text/css">
 
</head>

<body class="ts-noScroll">
    <div class="container-fluid">

        <div class="row justify-content-center mt-2">
            <div class="col-md-7">
                <div class="container justify-content-center card">
                    <form class="mb-4" action="../database/termos.php?operacao=alterar" method="post">
                        <div class="row mt-3">
                            <div class="col-md-5 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="mr-2">ID: </label>
                                </div>
                                <input type="text" class="form-control ts-input" name="IDtermo" value="<?php echo $termo['IDtermo'] ?>" readonly>
                            </div>
                            <div class="col-md-5 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="mr-2">Nome: </label>
                                </div>
                                <input type="text" class="form-control ts-input" name="termoNome" value="<?php echo $termo['termoNome'] ?>">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <div class="form-group">
                                    <label class="mr-2">Copias: </label>
                                </div>
                                <input type="text" class="form-control ts-input" name="termoCopias" value="<?php echo $termo['termoCopias'] ?>">
                            </div>
                        </div>
                        <div class="mt-2" id="ts-tabs">
                            <div class="tab whiteborder" id="tab-termo">Termo</div>
                            <div class="tab" id="tab-rascunho">Rascunho</div>
                            <div class="tab" id="tab-json">JSON</div>
                            <div class="tab" id="tab-termoJSON" hidden>Termo Preenchido</div>
                            <div class="tab" id="tab-rascunhoJSON" hidden>Rascunho Preenchido</div>

                            <div class="line"></div>

                            <div class="tabContent">
                                <div class="text-center mt-3">
                                    <br>
                                </div>
                                <div class="centered-textarea-container">
                                    <textarea class="custom-textarea" rows="18" cols="56" name="termo" readonly>
                                    <?php echo $termo['termo'] ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="tabContent">
                                <div class="text-center">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#efetivarModal" class="btn btn-info">Efetivar</button>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
                                </div>
                                <div class="centered-textarea-container">
                                    <textarea class="custom-textarea" rows="18" cols="56" name="rascunho">
                                    <?php echo $termo['rascunho'] ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="tabContent">
                                <div class="text-center">
                                    <button type="button" id="buscar" class="btn btn-success">Buscar Termo</button>
                                </div>
                                <div class="centered-textarea-container">
                                    <textarea class="custom-textarea" rows="18" cols="56" name="json" id="json"></textarea>
                                </div>
                            </div>
                            <div class="tabContent">
                                <div class="text-center mt-3">
                                    <br>
                                </div>
                                <div class="centered-textarea-container">
                                    <textarea class="custom-textarea" rows="18" cols="56" name="termoJSON" id="termoJSON" readonly></textarea>
                                </div>
                            </div>
                            <div class="tabContent">
                                <div class="text-center mt-3">
                                    <br>
                                </div>
                                <div class="centered-textarea-container">
                                    <textarea class="custom-textarea" rows="18" cols="56" name="rascunhoJSON" id="rascunhoJSON" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container justify-content-center">
                    <div class="container-fluid mb-2">
                        <div class="table mt-2 ts-tableFiltros text-center scrollable-table-container ts-noScroll">
                            <table class="table table-striped table-hover table-sm align-middle">
                                <thead class="ts-headertabelafixo">
                                    <tr>
                                        <th>Mnemo</th>
                                        <th>Nome</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mnemos as $mnemo) { ?>
                                        <tr>
                                            <td><?php echo $mnemo['mnemo'] ?></td>
                                            <td><?php echo $mnemo['nome'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------- MODAL COONFIRMA --------->
    <div class="modal" id="efetivarModal" tabindex="-1" role="dialog" aria-labelledby="efetivarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Efetivar termo: <?php echo $termo['IDtermo'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="container-fluid p-0 text-center">
                            <h4>CONFIRMA EFETIVAÇÃO DO TERMO?</h4>
                        </div>
                        <input type="hidden" class="form-control" name="IDtermo" value="<?php echo $termo['IDtermo'] ?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" formaction="../database/termos.php?operacao=efetivar" class="btn btn-success">Efetivar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->
    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

    <script>
        document.querySelector('textarea[name="termo"]').addEventListener('input', function (e) {
            let normalizedValue = this.value.normalize('NFD');

            normalizedValue = normalizedValue.replace(/[\u0300-\u036f]/g, '');

            this.value = normalizedValue.replace(/[^a-zA-Z0-9\s\-{}\[\].,:/|\\$_()%*]/g, '');
        });

        $(document).on('click', '#buscar', function() {
            var jsonEntrada = $('#json').val();
            var termoID = '<?php echo $termo['IDtermo'] ?>';

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/termos.php?operacao=buscaTermosJSON',
                beforeSend: function() {
                    $("#termoJSON").val("Carregando termo...");
                },
                data: {
                    jsonEntrada: jsonEntrada
                },
                
                success: function(data) {
                    var termo = data.find(termo => termo.tipo === termoID);

                    if (termo?.termoBase64) {
                        $('#termoJSON').val(atob(termo.termoBase64));
                    }
                    
                }
            });
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/termos.php?operacao=buscaRascunhoJSON',
                beforeSend: function() {
                    $("#rascunhoJSON").val("Carregando termo...");
                },
                data: {
                    jsonEntrada: jsonEntrada
                },
                success: function(data) {
                    var termo = data.find(termo => termo.tipo === termoID);

                    if (termo?.termoBase64) {
                        $('#rascunhoJSON').val(atob(termo.termoBase64));
                    }
    
                }
            });
            
            document.getElementById('tab-termoJSON').removeAttribute('hidden');
            document.getElementById('tab-rascunhoJSON').removeAttribute('hidden');
            showTabsContent(3);
        });

        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'termo') {
                showTabsContent(0);
            }
            if (id === 'rascunho') {
                showTabsContent(1);
            }
            if (id === 'json') {
                showTabsContent(2);
            }
            if (id === 'termoJSON') {
                showTabsContent(3);
            }
            if (id === 'rascunhoJSON') {
                showTabsContent(4);
            }
        }

        document.getElementById('ts-tabs').onclick = function (event) {
            var target = event.target;
            if (target.className.includes('tab')) {
                for (var i = 0; i < tab.length; i++) {
                    if (target == tab[i]) {
                        showTabsContent(i);
                        break;
                    }
                }
            }
        }

        function hideTabsContent(startIndex) {
            for (var i = startIndex; i < tabContent.length; i++) {
                tabContent[i].classList.remove('show');
                tabContent[i].classList.add("hide");
                tab[i].classList.remove('whiteborder');
            }
        }

        function showTabsContent(index) {
            if (tabContent[index].classList.contains('hide')) {
                hideTabsContent(0);
                tab[index].classList.add('whiteborder');
                tabContent[index].classList.remove('hide');
                tabContent[index].classList.add('show');
            }
        }
    </script>
</body>

</html>