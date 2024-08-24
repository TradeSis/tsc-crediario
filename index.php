<?php
include_once __DIR__ . "/../config.php";
include_once "header.php";

if (
    !isset($_SESSION['nomeAplicativo']) || 
    $_SESSION['nomeAplicativo'] !== 'Crediario' || 
    !isset($_SESSION['nivelMenu']) || 
    $_SESSION['nivelMenu'] === null
) {
    $_SESSION['nomeAplicativo'] = 'Crediario';
    include_once ROOT . "/sistema/database/loginAplicativo.php";

    $nivelMenuLogin = buscaLoginAplicativo($_SESSION['idLogin'], $_SESSION['nomeAplicativo']);
    $_SESSION['nivelMenu'] = $nivelMenuLogin['nivelMenu'];
}
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <title>Crediário</title>

</head>

<body>
    <?php include_once  ROOT . "/sistema/painelmobile.php"; ?>

    <div class="d-flex">

        <?php include_once  ROOT . "/sistema/painel.php"; ?>

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-10 d-none d-md-none d-lg-block pr-0 pl-0 ts-bgAplicativos">
                    <ul class="nav a" id="myTabs">


                        <?php
                        $tab = '';

                        if (isset($_GET['tab'])) {
                            $tab = $_GET['tab'];
                        }
                        ?>
                        <?php if ($_SESSION['nivelMenu'] >= 2) {
                            if ($tab == '') {
                                $tab = 'cliente';
                            } ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link 
                                <?php if ($tab == "cliente") {echo " active ";} ?>" 
                                href="?tab=cliente" role="tab">Cliente</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "contrato") {echo " active ";} ?>" 
                                href="?tab=contrato" role="tab">Contrato</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "seguros") {echo " active ";} ?>" 
                                href="?tab=seguros" role="tab">Seguros</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "filacredito") {echo " active ";} ?>" 
                                href="?tab=filacredito" role="tab">Fila Crédito</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "termos") {echo " active ";} ?>" 
                                href="?tab=termos" role="tab">Termos</a>
                            </li>
                        <?php }
                           ?>
                    </ul>

                </div>
                <!--Essa coluna só vai aparecer em dispositivo mobile-->
                <div class="col-7 col-md-9 d-md-block d-lg-none ts-bgAplicativos">
                    <!--atraves do GET testa o valor para selecionar um option no select-->
                    <?php if (isset($_GET['tab'])) {
                        $getTab = $_GET['tab'];
                    } else {
                        $getTab = '';
                    } ?>
                    <select class="form-select mt-2 ts-selectSubMenuAplicativos" id="subtabCrediario">

                        <?php if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/crediario/?tab=cliente" 
                        <?php if ($getTab == "cliente") {echo " selected ";} ?>>Cliente</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/crediario/?tab=contrato" 
                        <?php if ($getTab == "contrato") {echo " selected ";} ?>>Contrato</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/crediario/?tab=seguros" 
                        <?php if ($getTab == "seguros") {echo " selected ";} ?>>Seguros</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/crediario/?tab=filacredito" 
                        <?php if ($getTab == "filacredito") {echo " selected ";} ?>>Fila Crédito</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/crediario/?tab=inauguracao" 
                        <?php if ($getTab == "inauguracao") {echo " selected ";} ?>>Cadastro Cliente</option>
                        <?php } ?>

                        <option value="<?php echo URLROOT ?>/crediario/?tab=boletagem" 
                        <?php if ($getTab == "boletagem") {echo " selected ";} ?>>Boletagem</option>

                        <option value="<?php echo URLROOT ?>/crediario/?tab=termos" 
                        <?php if ($getTab == "termos") {echo " selected ";} ?>>Termos</option>

                    </select>
                </div>

                <?php include_once  ROOT . "/sistema/novoperfil.php"; ?>

            </div>



            <?php
            $src = "";

            if ($tab == "cliente") {
                $src = "clientes/cliente_menu.php";
            }

            if ($tab == "contrato") {
                $src = "clientes/contrato_menu.php";
            }
            if ($tab == "seguros") {
                $src = "consultas/seguros_parametros.php";
            }
            if ($tab == "filacredito") {
                $src = "consultas/filacredito.php";
            }

            if ($tab == "inauguracao") {
                $src = "clientes/cliente_cadastro.php";
            }

            if ($tab == "boletagem") {
                $src = "boletagem/";
            }

            if ($tab == "termos") {
                $src = "clientes/termos.php";
            }

            if ($src !== "") {
                //echo URLROOT ."/cadastros/". $src;
            ?>
                <div class="container-fluid p-0 m-0">
                    <iframe class="row p-0 m-0 ts-iframe" src="<?php echo URLROOT ?>/crediario/<?php echo $src ?>"></iframe>
                </div>
            <?php
            }
            ?>
        </div><!-- div container -->
    </div><!-- div class="d-flex" -->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script src="<?php echo URLROOT ?>/sistema/js/mobileSelectTabs.js"></script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>