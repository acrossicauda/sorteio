<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Sorteio extends Controller
{

    private $sorteioInstance = null;

    public function __construct()
    {
        $this->sorteioInstance = new SorteioDao();
    }
    
    public function _setConfigurations(Request $request)
    {
        $post = $request->all();
        unset($post['_token']);
        $dataRequest = [
            'limita_time' => $post['limite_time'],
        ];
        $ids = array();
        if(isset($post['idconfiguracao']) && isset($post['idconfiguracao'])) {
            $ids = ['idconfiguracao' => $post['idconfiguracao']];
        }

        $this->sorteioInstance->edit($dataRequest, 'configuracao', $ids);

        $limite = $this->teamLimit();
        return view('configuracao', ['configuracao' => $limite]);
    }

    public function storeNewPlayer(Request $request)
    {
        if($request != null) {
            $post = $request->all();
            unset($post['_token']);

            $dataRequest = [
                'nome' => $post['nome'],
                'nivel' => ($post['nivel'] > 10) ? 10 : $post['nivel'] * 1,
                'categoria' => $post['categoria']
            ];
            $idvendedor = array();
            if(
                isset($post['idjogadores']) 
                && !empty($post['idjogadores'])
            ) {
                $idvendedor['idjogadores'] = $post['idjogadores'];
            }
            
            $dataRequest['confirmar'] = 0;
            if(
                isset($post['confirmar']) 
                && !empty($post['confirmar'])
            ) {
                $dataRequest['confirmar'] = 1;
            }
    
            $this->sorteioInstance->edit($dataRequest, 'jogadores', $idvendedor);
        }

        $players = $this->_getPlayers();
        return view('novo_jogador', ['jogadores' => $players]);
    }

    // return numero de jogadores permitidos por time
    public function teamLimit()
    {
        $jogadoresPorTime = $this->sorteioInstance->show([], 'configuracao');
        // default 5
        return !empty($jogadoresPorTime[0]) ? $jogadoresPorTime[0] : [];
    }

    public function _getConfirmedPlayers(Array $players = array())
    {
        $players = $this->_getPlayers();
        return $players;
    }
    
    public function _getPlayers(Array $players = array())
    {
        $players = $this->sorteioInstance->show([], 'jogadores');
        // default 5
        return !empty($players[0]) ? $players : [];
        
    }

    public function montaEquipe() {
        $jogadores[] = $this->_getPlayers();
        $confirmados = $this->_getConfirmedPlayers();
        $jogadoresPorTime = $this->teamLimit();
        $limita_time = $jogadoresPorTime->limita_time;

        if(empty($jogadoresPorTime) || empty($confirmados)) {
            return view('sorteio', ['teams' => ['erro' => 'Nenhum Jogador configurado']]);
        }
        if( count($confirmados) < ($limita_time * 2) ) {
            return view('sorteio', ['teams' => ['erro' => 'precisa de mais jogadores']]);
        }

        $teams = [];
        
        // convertendo para array
        $confirmados = json_decode(json_encode($confirmados), true);
        $limite = count($confirmados);

        // trazendo primeiro os goleiros
        usort($confirmados, function($a, $b) {
			return $a['categoria'] != 'goleiro';
		});
        
        
        $i = 0;
        $cont = 0;
        // evita looping infinito
        $retryLimite = 0;
        while ($i <= $limite && $retryLimite < 1000) {
            $retryLimite++;

            $ramdom = array_rand(array_keys($confirmados));

            if(isset($confirmados[$ramdom]) && !empty($confirmados[$ramdom])) {
                
                if(
                    (!isset($teams[$cont]))
                    || (
                        isset($teams[$cont])
                        && (count($teams[$cont]) >= $limita_time)
                        )
                ) {
                    $cont++;
                    $teams[$cont] = [];
                }
                if( isset($teams[$cont]) ) {
                    

                    $existGoleiro = '';
                    // separa os goleiros
                    $existGoleiro = false;
                    if(!empty($teams[$cont])) {
                        $existGoleiro = json_encode($teams[$cont]);
                        $existGoleiro = (false !== strpos($existGoleiro, 'goleiro')) ? true : false;

                    }
                    // se ja existir goleiro no time deve pular para o proximo jogador
                    if(
                        $confirmados[$ramdom]['categoria'] == 'goleiro' 
                        && $existGoleiro
                        ) {
                        continue;
                    } else if(
                        (count($confirmados[$ramdom]) >= $limite - 1)
                        && $confirmados[$ramdom]['categoria'] == 'goleiro' 
                        && $existGoleiro
                        ) {
                            continue;
                        
                    } else {
                        $teams[$cont][] = $confirmados[$ramdom];
                        $i++;
                        unset($confirmados[$ramdom]);
                    }
                }
                
            }

        }

        return view('sorteio', ['teams' => $teams]);
    }
}
