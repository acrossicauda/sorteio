@include('components.header', ['title' => 'Configuração'])

    <div class="contet">
        <div class="contet-fluid">
            <div class="row">
                <div class="col-md-3 vertical-center horizontal-center">
                    <form action="configuracao" method="POST">
                        @csrf
                        <h3>Configurar Times</h3>
                        <input type="hidden" name="idconfiguracao" 
                        value="{{
                             (isset($configuracao) && !empty($configuracao)) 
                                    ? $configuracao->idconfiguracao : ''
                        }}">
                        Limite por time: 
                            <input type="text" 
                                name="limite_time" 
                                id="limite_time"
                                value="{{ 
                                    (isset($configuracao) && !empty($configuracao)) 
                                    ? $configuracao->limita_time : 0
                                 }}">
                        <input type="submit" value="Salvar">
                    </form>
                </div>
            </div>
        </div>
    </div>

@include('components.footer')