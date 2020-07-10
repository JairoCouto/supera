<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrato\Contrato;
use App\Models\Contrato\Unidade;
use App\Models\Atestado\Atestado;
use App\Models\Contrato\ContratoUsuario;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class FormController extends Controller
{
    /**
     * Função responsável por carregar o index do formulário
     */
    public function index()
    {

        return view('pages.forms.form',[
            'actionContrato' => route('admin.create'),
            'actionUnidade'  => route('unidade.create'),
            'atestados'      => $this->getAtestados(),
            'actionUsuario'  => route('contrato-usuario.create')
        ]);
    }

    /**
     * Função responsável por encontrar um contrato pelo cnpj, razão social ou nome fantasia
     */
    public function findContrato($id)
    {

        $contrato = Contrato::leftJoin('unidade', 'unidade.id_contrato', '=', 'contrato.id_contrato')
                            ->select('contrato.id_contrato',
                                     'contrato.cnpj',
                                     'contrato.razao_social',
                                     'contrato.nome_fantasia',
                                     'contrato.email            as cont_email',
                                     'contrato.logomarca        as cont_logomarca',
                                     'contrato.status           as cont_status',
                                     'unidade.id_unidade',
                                     'unidade.integracao',
                                     'unidade.email             as unid_email',
                                     'unidade.municipio',
                                     'unidade.uf                as uf',
                                     'unidade.logomarca         as unid_logomarca',
                                     'unidade.tipo',
                                     'unidade.status            as unid_status')
                           
                            ->where('contrato.id_contrato', '=', $id)
                            ->first();

        $contratoUsuario = ContratoUsuario::select('id_contrato_usuario',
                                                   'id_contrato',
                                                   'cpf',
                                                   'nome')
                                          ->where('id_contrato', '=', $id)
                                          ->get();

                            
        return view('pages.forms.form',[
            'contrato' => $contrato,
            'actionContrato'  => route('admin.update'),
            'actionUnidade'   => (isset($contrato->id_unidade) && !is_null($contrato->id_unidade)) ? route('unidade.update') : route('unidade.create'),
            'atestados'       => $this->getAtestados(),
            'contratoUsuario' => $contratoUsuario,
            'actionUsuario'  => route('contrato-usuario.create')
        ]); 
                            
    }

    /**
     * Função responsável por criar um novo contrato
     */
    public function createContrato(Request $request)
    {
        $request->validate([
            'cnpj'          => 'required|integer|digits:14|unique:contrato',
            'razao_social'  => 'required|string|max:100',
            'nome_fantasia' => 'required|string|max:100',
            'email'         => 'required|string|max:100|unique:contrato',
            'logomarca'     => 'nullable|file',
            'status'        => 'required|in:0,1'
        ]);

        if(!is_null($request->logomarca)) {
            $extension = $request->logomarca->extension();

            $nameFile = date('dmYHis') .'.'. $extension;

            $upload = $request->logomarca->storeAs('/', $nameFile, 'public');

            if(!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Ocorreu um erro ao realizar o upload da imagem para o servidor.');
            }

        }
        

        try {
           $contrato =  Contrato::create([
                            'cnpj'          => $request->cnpj,
                            'razao_social'  => $request->razao_social,
                            'nome_fantasia' => $request->nome_fantasia,
                            'email'         => $request->email,
                            'logomarca'     => isset($nameFile) ? $nameFile : $request->logomarca,
                            'status'        => $request->status
                        ]);

            return redirect()
                ->route('admin.find', ['id' => $contrato->id_contrato])
                ->with('success', 'Contrato cadastrado com sucesso.');    
            

        } catch (\Exception $ex) {
            report($ex);
            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro ao cadastrar um novo contrato. Erro: ' .$ex->getMessage());
        }
        
    }

    /**
     * Função responsável por atualizar o contrato
     */
    public function updateContrato(Request $request)
    {
        $request->validate([
            'id_contrato'   => 'required|numeric',
            'cnpj'          => 'required|numeric',
            'razao_social'  => 'required|string|max:100',
            'nome_fantasia' => 'required|string|max:100',
            'email'         => 'required|string|max:100',
            'logomarca'     => 'nullable|file',
            'status'        => 'required|in:0,1'
        ]);

        if(!is_null($request->logomarca)) {
            $extension = $request->logomarca->extension();

            $nameFile = date('dmYHis') .'.'. $extension;

            $upload = $request->logomarca->storeAs('/', $nameFile, 'public');

            if(!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Ocorreu um erro ao realizar o upload da imagem para o servidor.');
            }

        }

        try {
            
            Contrato::where('id_contrato', '=', $request->id_contrato)
                    ->update([
                        'cnpj'          => $request->cnpj,
                        'razao_social'  => $request->razao_social,
                        'nome_fantasia' => $request->nome_fantasia,
                        'email'         => $request->email,
                        'logomarca'     => isset($nameFile) ? $nameFile : $request->logomarca_old,
                        'status'        => $request->status
                    ]);

            return redirect()
                ->route('admin.find', ['id' => $request->id_contrato])
                ->with('success', 'Contrato atualizado com sucesso.');


        } catch (\Exception $ex) {
            report($ex);
            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro ao atualizar o contrato. Erro: ' .$ex->getMessage());
        }

    }

    /**
     * Função responsável por remover um contrato existente.
     */
    public function destroyContrato($id)
    {

        if(is_null($id) || empty($id)) {
            return redirect()
                ->back()
                ->with('error', 'Não foi possível localizar o contrato informado.');
        }

        try {
            Contrato::where('id_contrato', '=', $id)
                    ->delete();

            return redirect()
                    ->route('admin.form')
                    ->with('success', 'Contrato removido com sucesso.');

        } catch (\Exception $ex) {
            report($ex);
            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro ao remover o contrato. Erro: ' .$ex->getMessage());
        }
    }

    /**
     * Função responsável por cadastrar uma nova unidade
     */
    public function createUnidade(Request $request)
    {
        $this->validateFormUnidade($request);

        if(!is_null($request->logomarca_unidade)) {
            $extension = $request->logomarca_unidade->extension();

            $nameFile = date('dmYHis') .'.'. $extension;

            $upload = $request->logomarca_unidade->storeAs('/', $nameFile, 'public');

            if(!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Ocorreu um erro ao realizar o upload da imagem para o servidor.');
            }

        }


        try {
            Unidade::create([
                'id_contrato' => $request->id_contrato,
                'integracao'  => $request->integracao,
                'email'       => $request->email_unidade,
                'municipio'   => $request->municipio,
                'uf'          => $request->uf,
                'logomarca'   => isset($nameFile) ? $nameFile : $request->logomarca_unidade,
                'tipo'        => $request->tipo,
                'status'      => $request->status_unidade
            ]);

            return redirect()
                    ->route('admin.find', ['id' => $request->id_contrato])
                    ->with('success', 'Unidade cadastrada com sucesso.');
            
        } catch (\Exception $ex) {
            report($ex);
            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro ao cadastrar a unidade. Erro: ' .$ex->getMessage());
        }
    }

    /**
     * Função responsável por atualizar uma unidade existente
     */
    public function updateUnidade(Request $request)
    {
        $this->validateFormUnidade($request);


        if(!is_null($request->logomarca_unidade)) {
            $extension = $request->logomarca_unidade->extension();

            $nameFile = date('dmYHis') .'.'. $extension;

            $upload = $request->logomarca_unidade->storeAs('/', $nameFile, 'public');

            if(!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Ocorreu um erro ao realizar o upload da imagem para o servidor.');
            }

        }

        try {
            Unidade::where('id_unidade', '=', $request->id_unidade)
                   ->update([
                        'integracao'  => $request->integracao,
                        'email'       => $request->email_unidade,
                        'municipio'   => $request->municipio,
                        'uf'          => $request->uf,
                        'logomarca'   => isset($nameFile) ? $nameFile : $request->logomarca_unidade,
                        'tipo'        => $request->tipo,
                        'status'      => $request->status_unidade
                   ]);
        
        return redirect()
                ->route('admin.find', ['id' => $request->id_contrato])
                ->with('success', 'Unidade atualizada com sucesso.');

        } catch (\Exception $ex) {
            report($ex);

        }

    }

    /**
     * Função responsável por remover uma unidade
     */
    public function destroyUnidade($id)
    {
        if(is_null($id) || empty($id)) {
            return redirect()
                ->back()
                ->with('error', 'Não foi possível localizar o contrato informado.');
        }

        try {
            Unidade::where('id_unidade', '=', $id)
                   ->delete();

            return redirect()
                ->route('admin.form')
                ->with('success', 'Unidade removido com sucesso.');

        } catch (\Exception $ex) {
            report($ex);
            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro ao remover a unidade informada.');
        }
    }


    /**
     * Função responsável por consultar um id_contrato pelo cnpj, razão social ou nome fantasia
     * 1- CNPJ, 2-Razão Social, 3-Nome Fantasia
     */
    public function getIdContrato($type, $parameter)
    {

        $contrato = Contrato::select('id_contrato')
                            ->where(function($query) use ($type, $parameter) {
                                if($type == 1) {
                                    $query->where('contrato.cnpj', '=', $parameter);
                                } else if ($type == 2) {
                                    $query->where('contrato.razao_social', '=', $parameter);
                                } else if ($type == 3) {
                                    $query->where('contrato.nome_fantasia', '=', $parameter);
                                }
                            })
                            ->first();


        $id_contrato = $contrato->id_contrato;

        return $id_contrato;

    }


    /**
     * Função responsável por carregar a lista de atestados
     */
    public function getAtestados()
    {
        $atestado = Atestado::select('id_atestado',
                                     'paciente')
                            ->get();

        return $atestado;
    }


    /**
     * Função responsável por cadastrar novos usuários ao contrato
     */
    public function createUserContrato(Request $request)
    {
        $request->validate([
            'id_contrato'  => 'required|numeric',
            'cpf'          => 'required|numeric|digits:11|unique:contrato_usuario',
            'nome'         => 'required|string|max:100' 
        ]);



        try {
            ContratoUsuario::create([
                'id_contrato' => $request->id_contrato,
                'cpf'         => $request->cpf,
                'nome'        => $request->nome
            ]);

        return redirect()
            ->route('admin.find', ['id' => $request->id_contrato])
            ->with('success', 'Usuário vinculado ao contrato com sucesso.');

        } catch (\Exception $ex) {
            report($ex);
            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro ao vincular o usuário ao contrato. Erro: ' .$ex->getMessage());
        }
    }


    /**
     * Função responsável por remover usuários vinculados ao contrato
     */
    public function destroyUserContrato($id, $idContrato)
    {
        if(is_null($id) || empty($id)) {
            return redirect()
                ->back()
                ->with('error', 'Não foi possível localizar o usuário informado.');
        }

        try {
            ContratoUsuario::where('id_contrato_usuario', '=', $id)
                           ->delete();

            return redirect()
                ->route('admin.find', ['id' => $idContrato])
                ->with('success', 'Usuário removido com sucesso.'); 

        } catch (\Exception $ex) {
            report($ex);
        }      

    }


    /**
     * Função responsável por validar os campos de inserção e atualização de unidades
     */
    private function validateFormUnidade(Request $request)
    {
        $request->validate([
            'id_contrato'       => 'required|numeric',
            'integracao'        => 'nullable|string|max:100',
            'email_unidade'     => 'nullable|string|max:100',
            'municipio'         => 'required|string|max:100',
            'uf'                => 'required|string|max:2',
            'logomarca_unidade' => 'nullable|file',
            'tipo'              => 'required|in:0,1,2,3',
            'status_unidade'    => 'required|in:0,1'
        ]);

        return $request;
    }

    /**
     * Função responsável por usuário por um id_usuario, nome
     * 1- CPF, 2-Nome
     */
    public function getIdUsuario($type, $parameter)
    {

        $contrato = ContratoUsuario::select('nome',
                                            'cpf')
                            ->where(function($query) use ($type, $parameter) {
                                if($type == 1) {
                                    $query->where('contrato_usuario.cpf', '=', $parameter);
                                } else if ($type == 2) {
                                    $query->where('contrato_usuario.nome', '=', $parameter);
                                } 
                            })
                            ->first();


        return [
            'cpf'  => $contrato->cpf,
            'nome' => $contrato->nome
        ];

    }


}
