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
    <style>
        .custom-textarea {
            font-family: 'Courier New', Courier, monospace !important;
            font-size: 16px !important;
            width: 58ch !important;
            height: auto;
            white-space: pre-wrap !important;
            overflow-wrap: break-word !important;
        }

        .centered-textarea-container {
            display: flex;
            justify-content: center;
            padding: 5px;
        }

        .scrollable-table-container {
            max-height: 650px;
            min-width: 45ch;
            overflow-y: auto;
        }
    </style>
</head>

<body class="ts-noScroll">
    <div class="container-fluid">

        <div class="row justify-content-center mt-2">
            <div class="col-md-7">
                <div class="container justify-content-center card">
                    <form class="mb-4" action="../database/termos.php?operacao=alterar" method="post">
                        <div class="row mt-2">
                            <div class="col-md-5">
                                <label>ID</label>
                                <input type="text" class="form-control" name="IDtermo"
                                    value="<?php echo $termo['IDtermo'] ?>" readonly>
                            </div>
                            <div class="col-md-5">
                                <label>Nome</label>
                                <input type="text" class="form-control" name="termoNome"
                                    value="<?php echo $termo['termoNome'] ?>">
                            </div>
                            <div class="col-md-2">
                                <label>Copias</label>
                                <input type="text" class="form-control" name="termoCopias"
                                    value="<?php echo $termo['termoCopias'] ?>">
                            </div>
                        </div>
                        <div class="mt-3" id="ts-tabs">
                            <div class="tab whiteborder" id="tab-termo">Termo</div>
                            <div class="tab" id="tab-rascunho">Rascunho</div>

                            <div class="line"></div>

                            <div class="tabContent">
                                <div class="centered-textarea-container">
                                    <textarea class="custom-textarea" rows="20" cols="56" name="termo" readonly>
                                    <?php echo $termo['termo'] ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="tabContent">
                                <div class="centered-textarea-container">
                                    <textarea class="custom-textarea" rows="20" cols="56" name="rascunho">
                                    <?php echo $termo['rascunho'] ?>
                                    </textarea>
                                </div>

                                <div class="text-end">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#efetivarModal" class="btn btn-info">Efetivar</button>
                                    <button type="submit" class="btn btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
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
                            <table class="table table-hover table-sm align-middle">
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

        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'termo') {
                showTabsContent(0);
            }
            if (id === 'app') {
                showTabsContent(1);
            } else {
                showTabsContent(0);
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