
@include('components.header', ['title' => 'Monte sua Seleção'])

    <div class="contet">
        <div class="contet-fluid">
            <div class="row">
                @if(isset($teams['erro']) && !empty($teams['erro']))
                <div class="col-md-5 well link">
                    {{ $teams['erro'] }} 
                    <button onclick="window.location='{{ url('/') }}/novo_jogador'">
                        Cadastrar Jogador / Confirmar presença
                    </button>
                </div>
                @elseif(isset($teams) && !empty($teams))
                    @foreach ($teams as $kTeam => $team)
                    <div class="col-md-3">
                        <h3>Time {{  $kTeam  }}</h3>
                        @foreach ($team as $k => $v)
                            <div class="row well">
                                <p>Nome: {{  $v['nome']  }} | Nível: {{  $v['nivel']  }} | Posição: {{  $v['categoria']  }}</p>
                            </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    
@include('components.footer')