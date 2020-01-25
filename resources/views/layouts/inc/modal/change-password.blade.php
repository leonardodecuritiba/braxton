<div class="modal" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePassword"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePassword">Alterar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{Form::open(
            array(
                'route' => 'change.password',
                'method'=>'POST',
                'class'=>'form-horizontal'
            )
            )}}
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-control-label">
                        <label for="email_address_2">Senha</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::password('password', ['id'=>'password','placeholder'=>'Senha','class'=>'form-control','minlength'=>'3', 'required'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-control-label">
                        <label for="password_2">Confirmar Senha</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::password('password_confirmation', ['id'=>'password_confirmation','placeholder'=>'Confirmar Senha','class'=>'form-control','minlength'=>'3', 'required'])}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>

            {{Form::close()}}
        </div>
    </div>
</div>