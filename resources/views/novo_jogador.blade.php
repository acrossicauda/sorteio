@include('components.header', ['title' => 'Novo Jogador'])    

<div class="container">
        <div class="container-fluid">
            @if(isset($jogadores) && !empty($jogadores))
                <div class="row">
                    @foreach ($jogadores as $k => $v)
                    <form action="novo_jogador" method="post">
                        @csrf
                        <div class="col-md-12">
                            <div class="well">
                                <input type="hidden" name="idjogadores" id="idjogadores" value="{{  $v->idjogadores  }}">
                                Nome: <input type="text" name="nome" id="nome" value="{{  $v->nome  }}" required>
                                Nível: <input type="number" name="nivel" id="nivel" value="{{  $v->nivel  }}" required>
                                    <select name="categoria" id="categoria">
                                        <option value="jogador" <?= ($v->categoria == 'jogador') ? 'selected' : '' ?>>Jogador</option>
                                        <option value="goleiro" <?= ($v->categoria == 'goleiro') ? 'selected' : '' ?>>Goleiro</option>
                                    </select>
                                    <input type="hidden" name="confirmar" value="0" />
                                    Confirmar Presença: <input type="checkbox" name="confirmar" 
                                    value="1" 
                                    id="confirmar" <?= ($v->confirmar == 1) ? 'checked' : '' ?> 
                                    onchange="($(this).is(':checked')) ? $(this).val(1) : $(this).val(0)">
                                <input type="submit" value="Atualizar Jogadores">
                            </div>
                        </div>
                    </form>
                    @endforeach
                </div>
            @endif
            <div class="row">
                <div class="col-md-3 vertical-center horizontal-center">
                    <form action="novo_jogador" method="post">
                        @csrf
                        <h3>Cadastrar Jogador</h3>
                        <p>Nome: <input type="text" name="nome" id="nome" required></p>
                        <p>Nível: <input type="number" name="nivel" id="nivel" required></p>
                        <p>
                            <select name="categoria" id="categoria">
                                <option value="jogador">Jogador</option>
                                <option value="goleiro">Goleiro</option>
                            </select>
                        </p>
                        <input type="submit" value="Salvar">
                    </form>
                </div>
            </div>
        </div>
    </div>

@include('components.footer')