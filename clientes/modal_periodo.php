<!--------- FILTRO PERIODO --------->
<div class="modal" id="periodoModal" tabindex="-1"
    aria-labelledby="periodoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filtro Periodo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="row">
              <div class="col">
                <label class="labelForm">Dt Processamento</label>
                <?php if ($dtproc != null) { ?>
                <input type="date" class="data select form-control" id="dtproc"
                  value="<?php echo $dtproc ?>" name="dtproc" autocomplete="off">
                <?php } else { ?>
                <input type="date" class="data select form-control" id="dtproc" name="dtproc"
                  autocomplete="off">
                <?php } ?>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col">
                <label class="labelForm">Emissão De</label>
                <?php if ($dtini != null) { ?>
                <input type="date" class="data select form-control" id="dtini"
                  value="<?php echo $dtini ?>" name="dtini" autocomplete="off">
                <?php } else { ?>
                <input type="date" class="data select form-control" id="dtini" name="dtini"
                  autocomplete="off">
                <?php } ?>
              </div>
              <div class="col">
                <label class="labelForm">Até</label>
                <?php if ($dtfim != null) { ?>
                <input type="date" class="data select form-control" id="dtfim"
                  value="<?php echo $dtfim ?>" name="dtfim" autocomplete="off">
                <?php } else { ?>
                <input type="date" class="data select form-control" id="dtfim" name="dtfim"
                  autocomplete="off">
                <?php } ?>
              </div>
            </div>
            </div>
            <div class="modal-footer border-0">
              <div class="col-sm text-start">
                <button type="button" class="btn btn-primary" onClick="limparPeriodo()">Limpar</button>
              </div>
              <div class="col-sm text-end">
                <button type="button" class="btn btn-success" id="filtrarButton" data-dismiss="modal">Filtrar</button>
              </div>
            </div>
          </form>
        
      </div>
    </div>
  </div>
