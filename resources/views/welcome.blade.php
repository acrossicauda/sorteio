@include('components.header', ['title' => 'Home'])

    <div class="content">
        <div class="row">
            <div class="col-md-4 link" onclick="window.location='{{ url('/') }}/sorteio'">
                Sortear Times
            </div>
            <div class="col-md-4 link" onclick="window.location='{{ url('/') }}/novo_jogador'">
                Cadastrar Jogador / Confirmar presença
            </div>
            <div class="col-md-4 link" onclick="window.location='{{ url('/') }}/configuracao'">
                Configurações
            </div>
        </div>
    </div>

@include('components.footer')