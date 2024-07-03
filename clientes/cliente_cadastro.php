<?php
include_once '../header.php';

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>


  <div class="container-fluid">

    <!-- Header -->
    <div class="text-center">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 mt-4">
          <p class="text-lead text">Cadastramento de clientes</p>
        </div>
        <div class="container">
          <a class="brand">
            <img src="<?php echo URLROOT ?>/img/lebes.png" width="130px">  
          </a>
        </div>
      </div>
    </div>

    <!-- Page content -->
    <div class="container align-items-center justify-content-center" id="body">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card shadow">
            <form role="form" id="clienteForm" action="../database/crediariocliente.php?operacao=cadastrar" method="post">
              <div class="card-body">
                <div class="col">
                  <label><span style="color:red;">*</span> Loja</label>
                  <input class="form-control ts-input my-1" value="<?php echo isset($_COOKIE['codigoFilial']) ? str_pad($_COOKIE['codigoFilial'], 4, '0', STR_PAD_LEFT) : '' ?>" 
                    placeholder="Codigo Loja" type="text" id="codigoFilial" name="codigoFilial" required>
                  <label><span style="color:red;">*</span> CPF</label>
                  <input class="form-control ts-input my-1" placeholder="CPF" type="text" id="cpfCnpj" name="cpfCnpj" required>
                  <label><span style="color:red;">*</span> Nome Completo</label>
                  <input class="form-control ts-input my-1" placeholder="Nome Completo" type="text" id="nomeCliente" name="nomeCliente" disabled required>
                  <label><span style="color:red;">*</span> Data de Nascimento</label>
                  <input class="form-control ts-input my-1" placeholder="dd/mm/aaaa" type="text" id="dataNascimento" name="dataNascimento" disabled required>
                  <label><span style="color:red;">*</span> Telefone</label>
                  <input class="form-control ts-input my-1" placeholder="51999999999" type="tel" id="telefone" name="telefone" disabled required>
                </div>
                <div class="text-center mt-2">
                  <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- footer -->
  <div class="container">
    <div class="copyright text-center">
      <p style="font-size: smaller;">Desenvolvido por TradeSis</p>
    </div>
  </div>


  </div>

  <!-- LOCAL PARA COLOCAR OS JS -->

  <?php include_once ROOT . "/vendor/footer_js.php"; ?>

  <script>
    $(document).ready(function() {
      var timer;
      $("input[name='cpfCnpj']").on("input", function () {
        $("button[type='submit']").prop('disabled', true);
        clearTimeout(timer);  

        timer = setTimeout(function() {
          var codigoFilial = $("input[name='codigoFilial']").val();
          var cpfCnpj = $("input[name='cpfCnpj']").val();
          if (cpfCnpj.length === 11) {
            verificaCPF(codigoFilial, cpfCnpj);
            console.log(cpfCnpj);
          }
        }, 3000); 
      });

      function verificaCPF(codigoFilial, cpfCnpj) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: '../database/crediariocliente.php?operacao=busca',
          data: {
            codigoFilial: codigoFilial,
            cpfCnpj: cpfCnpj
          },
          success: function (data) {
            if (data.status == 404) {
              $("button[type='submit']").prop('disabled', false);
              $('#alerta').attr('hidden', 'hidden');
              $('#nomeCliente').prop('disabled', false);
              $('#dataNascimento').prop('disabled', false);
              $('#telefone').prop('disabled', false);
            } 
            else {
              window.location.href = "cliente_retorno.php?retorno=" + data.retorno;
            } 
          }
        });
      }

      $("input[name='cpfCnpj'], input[name='telefone']").on("input", function () {
        var telefone = $(this).val().replace(/\D/g, ''); 
        telefone = telefone.substring(0, 11); 
        $(this).val(telefone); 
      });
    });

    document.getElementById('nomeCliente').addEventListener('input', function (e) {
      this.value = this.value.replace(/\d/g, '');  
    });

    document.addEventListener("DOMContentLoaded", function() {
      var input = document.getElementById('codigoFilial');
      var placeholder = '0000';

      input.addEventListener('input', function(event) {
        var value = this.value.replace(/\D/g, '');
        var newValue = '';
        var j = value.length - 1;
        for (var i = placeholder.length - 1; i >= 0; i--) {
          if (placeholder[i] === '0' && value[j]) {
            newValue = value[j--] + newValue;
          } else {
            newValue = placeholder[i] + newValue;
          }
        }
        this.value = newValue;
      });

      input.addEventListener('keydown', function(event) {
        if (event.key === 'Backspace') {
          var currentValue = this.value.replace(/\D/g, '');
          if (currentValue.length > 0) {
            currentValue = currentValue.slice(0, -1);
            var newValue = '';
            var j = currentValue.length - 1;
            for (var i = placeholder.length - 1; i >= 0; i--) {
              if (placeholder[i] === '0' && currentValue[j]) {
                newValue = currentValue[j--] + newValue;
              } else {
                newValue = placeholder[i] + newValue;
              }
            }
            this.value = newValue;
          }
          event.preventDefault();
        }
      });
    });

    document.addEventListener("DOMContentLoaded", function() {
      var input = document.getElementById('cpfCnpj');
      var placeholder = '00000000000';

      input.addEventListener('input', function(event) {
        var value = this.value.replace(/\D/g, '');
        var newValue = '';
        var j = value.length - 1;
        for (var i = placeholder.length - 1; i >= 0; i--) {
          if (placeholder[i] === '0' && value[j]) {
            newValue = value[j--] + newValue;
          } else {
            newValue = placeholder[i] + newValue;
          }
        }
        this.value = newValue;
      });

      input.addEventListener('keydown', function(event) {
        if (event.key === 'Backspace') {
          var currentValue = this.value.replace(/\D/g, '');
          if (currentValue.length > 0) {
            currentValue = currentValue.slice(0, -1);
            var newValue = '';
            var j = currentValue.length - 1;
            for (var i = placeholder.length - 1; i >= 0; i--) {
              if (placeholder[i] === '0' && currentValue[j]) {
                newValue = currentValue[j--] + newValue;
              } else {
                newValue = placeholder[i] + newValue;
              }
            }
            this.value = newValue;
          }
          event.preventDefault();
        }
      });
    });
    
    document.addEventListener("DOMContentLoaded", function() {
      var input = document.getElementById('dataNascimento');
      var placeholder = 'dd/mm/aaaa';

      input.addEventListener('input', function(event) {
        var value = this.value.replace(/\D/g, '');
        var newValue = '';
        var j = 0;
        for (var i = 0; i < placeholder.length; i++) {
          if (placeholder[i] === 'd' && value[j]) {
            newValue += value[j++];
          } else if (placeholder[i] === 'm' && value[j]) {
            newValue += value[j++];
          } else if (placeholder[i] === 'a' && value[j]) {
            newValue += value[j++];
          } else {
            newValue += placeholder[i];
          }
        }
        this.value = newValue.substring(0, 10); 
      });

      input.addEventListener('keydown', function(event) {
        if (event.key === 'Backspace') {
          var currentValue = this.value.replace(/\D/g, '');
          currentValue = currentValue.slice(0, -1);
          var newValue = '';
          var j = 0;
          for (var i = 0; i < placeholder.length; i++) {
            if (placeholder[i] === 'd' && currentValue[j]) {
              newValue += currentValue[j++];
            } else if (placeholder[i] === 'm' && currentValue[j]) {
              newValue += currentValue[j++];
            } else if (placeholder[i] === 'a' && currentValue[j]) {
              newValue += currentValue[j++];
            } else {
              newValue += placeholder[i];
            }
          }
          this.value = newValue.substring(0, 10); 
          event.preventDefault();
        }
      });
    });

    document.getElementById('clienteForm').addEventListener('submit', function(event) {
      var input = document.getElementById('dataNascimento');
      var dateParts = input.value.split('/');
      if (dateParts.length === 3) {
        var formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
        input.value = formattedDate;
      }
    });
  </script>
  <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>