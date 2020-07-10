@extends('layouts.app')




@section('content')
    @include('layouts.headers.form')
    <div class="container-fluid mt--6">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Formulário</h3>
                    </div>
                    <br/>
                    @include('alerts.alerts_status')

                    <div class="card-body">
                        <!-- Contrato -->
                        <div class="card">
                            <div class="card-header bg-primary text-white">Contrato</div>
                            <div class="card-body">
                                <form action="{{ $actionContrato }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id_contrato" id="id_contrato" value="{{ old('id_contrato', isset($contrato->id_contrato) ? $contrato->id_contrato : '') }}">

                                    <!-- CNPJ -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">CNPJ</label>
                                        <div class="col-md-5">
                                            <input type="number"  class="form-control" name="cnpj" id="cnpj" value="{{ old('cnpj', isset($contrato->cnpj) ? $contrato->cnpj : '' ) }}"  required>
                                        </div>
                                        <a class="btn btn-info pop-bottom" title="Consultar CNPJ" href="javascript:;" id="btn-search-cnpj"><i class="fas fa-search"></i></a>
                                    </div>

                                    <!-- Razão Social -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Razão Social</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="razao_social" id="razao_social" value="{{ old('razao_social', isset($contrato->razao_social) ? $contrato->razao_social : '') }}" required>
                                        </div>
                                        <a class="btn btn-info pop-bottom" title="Consultar Razão Social" href="javascript:;" id="btn-search-razao_social"><i class="fas fa-search"></i></a>
                                    </div>

                                    <!-- Nome Fantasia -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Nome Fantasia</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="nome_fantasia" id="nome_fantasia" value="{{ old('nome_fantasia', isset($contrato->nome_fantasia) ? $contrato->nome_fantasia : '') }}" required>
                                        </div>
                                        <a class="btn btn-info pop-bottom" title="Consultar Nome Fantasia" href="javascript:;" id="btn-search-nome-fantasia"><i class="fas fa-search"></i></a>
                                    </div>

                                    <!-- E-mail -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">E-mail</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="email" value="{{ old('email', isset($contrato->cont_email) ? $contrato->cont_email : '') }}" required>
                                        </div>
                                    </div>

                                    <!-- In-User -->
                                    <!--
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">In User</label>
                                        <div class="col-md-6">
                                            <input type="text"  class="form-control" name="in_user" value="{{ old('in_user', isset($contrato->in_user) ? $contrato->in_user : '') }}" >
                                        </div>
                                        <button type="button" class="btn btn-info pop-bottom"  title="Carregar Imagem"><i class="fas fa-retweet"></i></button>
                                    </div>
                                    -->

                                    <!-- Logomarca -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Logomarca</label>
                                        <div class="col-md-5 ml-3">
                                            <input type="file" class="custom-file-input" id="logomarca" name="logomarca" value="{{ old('logomarca', isset($contrato->cont_logomarca) ? $contrato->cont_logomarca : '') }}">
                                            <input type="hidden" name="logomarca_old" value="{{ isset($contrato->cont_logomarca) ? $contrato->cont_logomarca : '' }}">
                                            <label class="custom-file-label" for="customFile" id="nome_logomarca" >Selecione uma imagem</label>
                                            <!--<input type="text"  class="form-control" name="logomarca" value="{{ old('logomarca', isset($contrato->cont_logomarca) ? $contrato->cont_logomarca : '') }}"> -->
                                        </div>
                                        <button type="button" class="btn btn-info pop-bottom ml-1"  title="Carregar Imagem"><i class="fas fa-download"></i></button>
                                        <a  target="_blank" rel="noopener noreferrer" href="../../storage/{{ isset($contrato->cont_logomarca) ? $contrato->cont_logomarca : null }}" class="btn btn-info pop-bottom" title="Ver Imagem"><i class="fas fa-eye"></i></a>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Status</label>
                                        <div class="col-md-5">
                                            <select class="form-control custom-select" name="status" id="status">
                                                <option value="0" @if(old('status', (isset($contrato->cont_status) ? $contrato->cont_status : '0')) == '0') selected="selected" @endif>Ativo</option>
                                                <option value="1" @if(old('status', (isset($contrato->cont_status) ? $contrato->cont_status : '1')) == '1') selected="selected" @endif>Inativo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <br/>

                                    <!-- Salvar -->
                                    <div class="btn-group">
                                       
                                        <button type="submit" class="btn btn-primary" id="btn-incluir-contrato" disabled>
                                            Incluir
                                        </button>

                                        <button type="submit" class="btn btn-primary" id="btn-alterar-contrato" disabled>
                                            Alterar
                                        </button>

                                        <button type="button" class="btn btn-danger" id="btn-remover-contrato" data-toggle="modal" data-target="#destroy-contrato" disabled>
                                            Remover
                                        </button>

                                        <a href="{{ route('admin.form') }}" class="btn btn-primary">Limpar</a>
                                    </div>


                                    <!-- Modal Destroy Contrato -->
                                    <div class="modal fade" id="destroy-contrato" tabindex="-1" role="dialog" aria-labelledby="destroy-contratoLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Aviso</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Deseja confirmar a remoção do contrato: {{ isset($contrato->id_contrato) ? $contrato->id_contrato : '' }} - {{ isset($contrato->razao_social) ? $contrato->razao_social : '' }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
                                                    @if(isset($contrato->id_contrato) != null)
                                                        <a href="{{ route('admin.destroy',['id' => $contrato->id_contrato ]) }}"  class="btn btn-primary">Remover</a>
                                                    @endif
                                                </div>
                                            </div> <!-- fim modal-content -->
                                        </div> <!-- fim modal-dialog -->
                                    </div> <!-- fim modal fade -->


                                </form>
                            </div> <!-- fim card-body - contrato -->
                        </div> <!-- fim card - contrato -->

                        <br/>

                        <!-- Unidade -->
                        <div class="card">
                            <div class="card-header bg-primary text-white">Unidade</div>
                            <div class="card-body">
                                <form action="{{ $actionUnidade }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id_unidade" id="id_unidade" value="{{ old('id_unidade', isset($contrato->id_unidade) ? $contrato->id_unidade : '') }}">

                                    <input type="hidden" name="id_contrato" value="{{ old('id_contrato', isset($contrato->id_contrato) ? $contrato->id_contrato : '') }}">

                                    <!-- Nome Fantasia -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Nome Fantasia</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="nome_fantasia" value="{{ old('cnpj', isset($contrato->nome_fantasia) ? $contrato->nome_fantasia : '') }}" readonly>
                                        </div>
                                    </div>

                                    <!-- Integração -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Integração</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="integracao" value="{{ old('integracao', isset($contrato->integracao) ? $contrato->integracao : '') }}" required>
                                        </div>
                                        <button type="button" class="btn btn-info pop-bottom" ><i class="fas fa-search"></i></button>
                                    </div>

                                    <!-- In Key -->
                                    <!--
                                    <div class="form-group row">
                                        <label for="" class="col-md-3 col-form-label">In Key</label>
                                        <div class="col-md-6">
                                            <input type="text"  class="form-control" name="in_key" value="{{ old('in_key', isset($contrato->in_key) ? $contrato->in_key : '') }}" required>
                                        </div>
                                        <button type="button" class="btn btn-info pop-bottom"  title="Carregar Imagem"><i class="fas fa-retweet"></i></button>
                                    </div>
                                    -->

                                    <!-- E-mail -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">E-mail</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="email_unidade" value="{{ old('email_unidade', isset($contrato->unid_email) ? $contrato->unid_email : '') }}" required>
                                        </div>
                                    </div>

                                    <!-- Município -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Município</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="municipio" id="municipio" value="{{ old('municipio', isset($contrato->municipio) ? $contrato->municipio : '') }}" >
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control custom-select" name="uf" id="uf">
                                                <option value="AC" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'AC')) == 'AC') selected="selected" @endif>AC</option>
                                                <option value="AL" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'AL')) == 'AL') selected="selected" @endif>AL</option>
                                                <option value="AP" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'AP')) == 'AP') selected="selected" @endif>AP</option>
                                                <option value="AM" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'AM')) == 'AM') selected="selected" @endif>AM</option>
                                                <option value="BA" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'BA')) == 'BA') selected="selected" @endif>BA</option>
                                                <option value="CE" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'CE')) == 'CE') selected="selected" @endif>CE</option>
                                                <option value="DF" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'DF')) == 'DF') selected="selected" @endif>DF</option>
                                                <option value="ES" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'ES')) == 'ES') selected="selected" @endif>ES</option>
                                                <option value="GO" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'GO')) == 'GO') selected="selected" @endif>GO</option>
                                                <option value="MA" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'MA')) == 'MA') selected="selected" @endif>MA</option>
                                                <option value="MT" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'MT')) == 'MT') selected="selected" @endif>MT</option>
                                                <option value="MS" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'MS')) == 'MS') selected="selected" @endif>MS</option>
                                                <option value="MG" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'MG')) == 'MG') selected="selected" @endif>MG</option>
                                                <option value="PA" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'PA')) == 'PA') selected="selected" @endif>PA</option>
                                                <option value="PB" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'PB')) == 'PB') selected="selected" @endif>PB</option>
                                                <option value="PR" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'PR')) == 'PR') selected="selected" @endif>PR</option>
                                                <option value="PE" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'PE')) == 'PE') selected="selected" @endif>PE</option>
                                                <option value="PR" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'PR')) == 'PR') selected="selected" @endif>PR</option>
                                                <option value="PR" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'PR')) == 'PR') selected="selected" @endif>PR</option>
                                                <option value="PI" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'PI')) == 'PI') selected="selected" @endif>PI</option>
                                                <option value="RJ" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'RJ')) == 'RJ') selected="selected" @endif>RJ</option>
                                                <option value="RN" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'RN')) == 'RN') selected="selected" @endif>RN</option>
                                                <option value="RS" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'RS')) == 'RS') selected="selected" @endif>RS</option>
                                                <option value="RO" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'RO')) == 'RO') selected="selected" @endif>RO</option>
                                                <option value="RR" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'RR')) == 'RR') selected="selected" @endif>RR</option>
                                                <option value="SC" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'SC')) == 'SC') selected="selected" @endif>SC</option>
                                                <option value="SP" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'SP')) == 'SP') selected="selected" @endif>SP</option>
                                                <option value="SE" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'SE')) == 'SE') selected="selected" @endif>SE</option>
                                                <option value="TO" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : 'TO')) == 'TO') selected="selected" @endif>TO</option>
                                                <option value="" @if(old('uf', (isset($contrato->uf) ? $contrato->uf : '')) == '') selected="selected" @endif>UF</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text"  class="form-control" name="cep" id="cep" value="" placeholder="Informe o CEP" >
                                        </div>

                                        <button type="button" class="btn btn-info pop-bottom"  title="Pesquisar CEP" id="btn-search-cep"><i class="fas fa-search"></i></button>
                                    </div>

                                    <!-- Logomarca -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Logomarca</label>
                                        <div class="col-md-5 ml-3">
                                            <input type="file" class="custom-file-input" id="logomarca_unidade" name="logomarca_unidade" value="{{ old('logomarca_unidade', isset($contrato->unid_logomarca) ? $contrato->unid_logomarca : '') }}">
                                            <input type="hidden" name="logomarca_unidade_old" value="{{ isset($contrato->unid_logomarca) ? $contrato->unid_logomarca : '' }}">
                                            <label class="custom-file-label" for="customFile" id="label_logomarca_unidade" >Selecione uma imagem</label>
                                        </div>
                                        <button type="button" class="btn btn-info pop-bottom ml-1"  title="Carregar Imagem"><i class="fas fa-download"></i></button>
                                        <a  target="_blank" rel="noopener noreferrer" href="../../storage/{{ isset($contrato->unid_logomarca) ? $contrato->unid_logomarca : null }}" class="btn btn-info pop-bottom" title="Ver Imagem"><i class="fas fa-eye"></i></a>
                                    </div>

                                    <!-- Tipo -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Tipo</label>
                                        <div class="col-md-5">
                                            <select class="form-control custom-select" name="tipo" id="tipo">
                                                <option value="0" @if(old('tipo', (isset($contrato->tipo) ? $contrato->tipo : '0')) == '0') selected="selected" @endif>Json</option>
                                                <option value="1" @if(old('tipo', (isset($contrato->tipo) ? $contrato->tipo : '1')) == '1') selected="selected" @endif>Webview</option>
                                                <option value="2" @if(old('tipo', (isset($contrato->tipo) ? $contrato->tipo : '2')) == '2') selected="selected" @endif>XML</option>
                                                <option value="3" @if(old('tipo', (isset($contrato->tipo) ? $contrato->tipo : '3')) == '3') selected="selected" @endif>HL-7</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Status</label>
                                        <div class="col-md-5">
                                            <select class="form-control custom-select" name="status_unidade" id="status_unidade">
                                                <option value="0" @if(old('status_unidade', (isset($contrato->unid_status) ? $contrato->unid_status : '0')) == '0') selected="selected" @endif>Ativo</option>
                                                <option value="1" @if(old('status_unidade', (isset($contrato->unid_status) ? $contrato->unid_status : '1')) == '1') selected="selected" @endif>Inativo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Salvar -->
                                    <div class="btn-group">
                                       
                                        <button type="submit" class="btn btn-primary" id="btn-incluir-unidade" disabled>
                                            Incluir
                                        </button>

                                        <button type="submit" class="btn btn-primary" id="btn-alterar-unidade" disabled>
                                            Alterar
                                        </button>

                                        <button type="button" class="btn btn-danger" id="btn-remover-unidade" data-toggle="modal" data-target="#destroy-unidade" disabled>
                                            Remover
                                        </button>

                                        <a href="{{ route('admin.form') }}" class="btn btn-primary">Limpar</a>
                                    </div>


                                    <!-- Modal Destroy Unidade -->
                                    <div class="modal fade" id="destroy-unidade" tabindex="-1" role="dialog" aria-labelledby="destroy-unidadeLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Aviso</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Deseja confirmar a remoção da unidade: {{ isset($contrato->id_unidade) ? $contrato->id_unidade : '' }} - Contrato: {{ isset($contrato->razao_social) ? $contrato->razao_social : '' }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
                                                    @if(isset($contrato->id_contrato) != null && isset($contrato->id_unidade) != null)
                                                        <a href="{{ route('unidade.destroy',['id' => $contrato->id_unidade ]) }}"  class="btn btn-primary">Remover</a>
                                                    @endif
                                                </div>
                                            </div> <!-- fim modal-content -->
                                        </div> <!-- fim modal-dialog -->
                                    </div> <!-- fim modal fade -->

                                </form>
                            </div> <!-- fim card-body - unidade -->
                        </div> <!-- fim card - unidade -->

                        <br/>

                        <!-- Atestados -->
                        <div class="card">
                            <div class="card-header bg-primary text-white">Atestados</div>
                            <div class="card-body">
                                <form action="">
                                    <!-- Nome Fantasia -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Nome Fantasia</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="nome_fantasia" value="{{ old('cnpj', isset($contrato->nome_fantasia) ? $contrato->nome_fantasia : '') }}" readonly>
                                        </div>
                                    </div>

                                    <!-- Integração -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Integração</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="integracao" value="{{ old('integracao', isset($contrato->integracao) ? $contrato->integracao : '') }}" readonly>
                                        </div>
                                    </div>

                                    <!-- Paciente -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Paciente</label>
                                        <div class="col-md-5">
                                            <select class="form-control custom-select" name="paciente" id="paciente">
                                                @foreach ($atestados as $atestado)
                                                    <option value="{{ $atestado['id_atestado'] }}" > {{ $atestado['paciente'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Acompanhamente -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Acompanhante</label>
                                        <div class="col-md-5">
                                            <select class="form-control custom-select" name="acompanhante" id="acompanhante">
                                                @foreach ($atestados as $atestado)
                                                    <option value="{{ $atestado['id_atestado'] }}" > {{ $atestado['paciente'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Óbito -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Óbito</label>
                                        <div class="col-md-5">
                                            <select class="form-control custom-select" name="obito" id="obito">
                                                @foreach ($atestados as $atestado)
                                                    <option value="{{ $atestado['id_atestado'] }}" > {{ $atestado['paciente'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </form>
                            </div> <!-- fim card-body - atestados -->
                        </div> <!-- fim card - atestados -->

                        <br/>

                        <!-- Usuário -->
                        <div class="card">
                            <div class="card-header bg-primary text-white">Usuário</div>
                            <div class="card-body">
                                <form action=" {{ $actionUsuario }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_contrato" id="id_contrato" value="{{ old('id_contrato', isset($contrato->id_contrato) ? $contrato->id_contrato : '') }}">

                                    <!-- Nome Fantasia -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Nome Fantasia</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="nome_fantasia" value="{{ old('cnpj', isset($contrato->nome_fantasia) ? $contrato->nome_fantasia : '') }}" readonly>
                                        </div>
                                    </div>

                                    <!-- CPF -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">CPF</label>
                                        <div class="col-md-5">
                                            <input type="number"  class="form-control" name="cpf" id="cpf" value="{{ old('cpf', isset($usuario->cpf) ? $usuario->cpf : '') }}">
                                        </div>
                                        <a href="javascript:;" class="btn btn-info pop-bottom"  title="Pesquisar" id="btn-search-cpf"><i class="fas fa-search"></i></a>
                                    </div>

                                    <!-- Nome -->
                                    <div class="form-group row">
                                        <label for="" class="col-md-2 col-form-label">Nome</label>
                                        <div class="col-md-5">
                                            <input type="text"  class="form-control" name="nome" id="nome" value="{{ old('nome', isset($usuario->nome) ? $usuario->nome : '') }}" >
                                        </div>
                                        <a href="javascript:;" class="btn btn-info pop-bottom"  title="Pesquisar" id="btn-search-nome"><i class="fas fa-search"></i></a>
                                    </div>


                                   <!-- Lista -->
                                   <div class="table-responsive">
                                        <table class="table align-items-center table-light table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col" class="sort" data-sort="cpf">CPF</th>
                                                    <th scope="col" class="sort" data-sort="usuario">Usuário</th>
                                                    <th scope="col" class="sort" data-sort="usuario">Remover</th>
                                                </tr>
                                            </thead>
                                            @if(isset($contrato->id_contrato) && $contrato->id_contrato != null)
                                            <tbody class="list">
                                                @foreach ($contratoUsuario as $itemContratoUsuario)
                                                    <tr>
                                                        <td>{{ $itemContratoUsuario->cpf }}</td>
                                                        <td>{{ $itemContratoUsuario->nome }}</td>
                                                        <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#usuario-contrato-{{ $itemContratoUsuario->id_contrato_usuario }}"><i class="far fa-trash-alt"></i></td>
                                                    </tr>

                                                    <!-- Modal Usuários Contrato -->
                                                    <div class="modal fade" id="usuario-contrato-{{ $itemContratoUsuario->id_contrato_usuario }}" tabindex="-1" role="dialog" aria-labelledby="usuario-contrato-label{{ $itemContratoUsuario->id_contrato_usuario }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Aviso</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Deseja confirmar a remoção do usuário: {{ isset($itemContratoUsuario->id_contrato_usuario) ? $itemContratoUsuario->id_contrato_usuario : '' }} - {{ isset($itemContratoUsuario->nome) ? $itemContratoUsuario->nome : '' }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
                                                                    @if(isset($itemContratoUsuario->id_contrato_usuario) != null)
                                                                        <a href="{{ route('contrato-usuario.destroy',['id' => $itemContratoUsuario->id_contrato_usuario, 'idContrato' => $itemContratoUsuario->id_contrato ]) }}"  class="btn btn-primary">Remover</a>
                                                                    @endif
                                                                </div>
                                                            </div> <!-- fim modal-content -->
                                                        </div> <!-- fim modal-dialog -->
                                                    </div> <!-- fim modal fade -->
                                                @endforeach
                                            </tbody>
                                            @endif
                                        </table> <!-- fim table --->
                                   </div> <!-- fim table-responsive -->

                                   <br/>

                                    <!-- Salvar -->
                                    <div class="btn-group">
                                       
                                        <button type="submit" class="btn btn-primary">
                                            Incluir
                                        </button>

                                        <a href="{{ route('admin.form') }}" class="btn btn-primary">Limpar</a>
                                    </div>

                                </form>
                            </div> <!-- fim card-body - atestados -->
                        </div> <!-- fim card - atestados -->
                    </div>
                </div> <!-- fim card -->
            </div> <!-- fim col -->
        </div> <!-- fim row -->
    </div> <!-- fim container-fluid -->
    
@endsection