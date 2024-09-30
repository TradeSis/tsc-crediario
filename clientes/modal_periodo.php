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
              <div class="form-group col">
                <div class="row">
                  <div class="col-1">
                  </div>
                  <div class="col input-dtproc">
                    <label>Dt Processamento</label>
                  </div>
                  <div class="col d-none input-dtini">
                    <label>Emissão De</label>
                  </div>
                  <div class="col d-none input-dtfim">
                    <label>Até</label>
                  </div>
                </div>
                <div class="input-group mb-2">
                    <button class="btn btn-outline-secondary" type="button" id="button-dti" title="Fixo"><i class="bi bi-arrow-repeat"></i></button>
                    <input type="date" class="form-control input-dtproc" value="<?php echo $dtproc != null ? $dtproc : null?>" name="dtproc" id="dtproc" required>
                    <input type="date" class="form-control d-none input-dtini" value="<?php echo $dtini != null ? $dtini : null?>" name="dtini" id="dtini" disabled>
                    <input type="date" class="form-control d-none input-dtfim" value="<?php echo $dtfim != null ? $dtfim : null?>" name="dtfim" id="dtfim" disabled>
                </div>
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
