<?php
include_once '../header.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link href="termos.css" rel="stylesheet" type="text/css">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 card p-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-5">
                            <h3>Testar Termos</h3>
                        </div>

                        <div class="col-5">
                            <div class="input-group">
                                <a href="termos.php" class="ms-4 btn btn-info" role="button">Termos</a>
                            </div>
                        </div>
                        <div class="col-2">
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row justify-content-center mt-2">
                        <div class="container justify-content-center">
                            <div class="centered-textarea-container">
                                <div class="col-4">
                                    <select id="codigoSelect" class="form-select ts-input" hidden></select>
                                </div>
                            </div>
                            <div id="ts-tabs">
                                <div class="tab whiteborder" id="tab-json">JSON</div>
                                <div class="tab" id="tab-termo" hidden>Termo</div>
                                <div class="tab" id="tab-retorno" hidden>Retorno</div>

                                <div class="line"></div>

                                <div class="tabContent">
                                    <div class="text-center">
                                        <button type="button" id="buscar" class="btn btn-warning">Buscar</button>
                                    </div>
                                    <div class="centered-textarea-container">
                                        <textarea class="custom-textarea" rows="18" cols="56" name="json" id="json"></textarea>
                                    </div>
                                </div>
                                <div class="tabContent">
                                    <div class="centered-textarea-container">
                                            <div>
                                                <textarea class="custom-textarea" rows="18" cols="56" name="termo" id="termo" readonly></textarea>
                                            </div>
                                    </div>
                                </div>
                                <div class="tabContent">
                                    <div class="centered-textarea-container">
                                        <textarea class="custom-textarea" rows="18" cols="56" name="retorno" id="retorno" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

    <script>
        $(document).on('click', '#buscar', function() {
            var jsonEntrada = $('#json').val();
            buscaTermoJSON(jsonEntrada);
        });

        $(document).on('change', '#codigoSelect', function() {
            var codigo = $(this).val();
            var conteudo = $(this).find(':selected').data('conteudo');
            updateRetorno(codigo, conteudo);
        });

        function buscaTermoJSON(jsonEntrada) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/termos.php?operacao=buscaTermosJSON',
                data: {
                    jsonEntrada: jsonEntrada
                },
                success: function(data) {
                    console.log(data);
                    criaSelect(data);
                    
                    document.getElementById('tab-termo').removeAttribute('hidden');
                    document.getElementById('tab-retorno').removeAttribute('hidden');
                    document.getElementById('codigoSelect').removeAttribute('hidden');
                    showTabsContent(1); 
                }
            });
        }

        function criaSelect(data) {
            var select = $('#codigoSelect');
            select.empty();
            data.forEach(function(item) {
                select.append($('<option>', {
                    value: item.codigo,
                    text: item.codigo,
                    'data-conteudo': item.conteudo
                }));
            });
            var option = select.find('option:first');
            updateRetorno(option.val(), option.data('conteudo')); 
        }

        function updateRetorno(codigo, conteudo) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/termos.php?operacao=buscaTermos',
                data: {
                    IDtermo: codigo
                },
                success: function(data) {
                    $('#termo').val(data.termo);
                }
            });

            $('#retorno').val(conteudo);
        }

        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'json') {
                showTabsContent(0);
            }
            if (id === 'termo') {
                showTabsContent(1);
            } 
            if (id === 'retorno') {
                showTabsContent(2);
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