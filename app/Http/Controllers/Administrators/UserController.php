<?php

namespace App\Http\Controllers\Administrators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller {
    protected $mainmodel;
    protected $niceNames;

    public function __construct(User $mainmodel) {
        $this->mainmodel = $mainmodel;
        $this->niceNames = array('name' => 'Nome', 'email' => 'E-mail', 'password' => 'Senha');
    }

    /**
     * Exibe a listagem
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $mainModel = $this->mainmodel->newQuery()->get();

        return view('administrator.user.index', compact('mainModel'));
    }

    /**
     * Exibe a insercao
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('administrator.user.record');
    }

    /**
     * Realiza a insercao
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,null,id',
            'password' => 'required|confirmed|min:6',
        ]);

        if(!$validator->fails()){
            $mainModel = $this->mainmodel->newQuery()->create($request->all());

            return response()->json([
                'result' => true,
                'messages' => 'Registro inserido',
                'url' => route('administrator.user.index')
            ]);
        }
        else{
            return response()->json([
                'result' => false,
                'messages' => 'Preencha os campos corretamente',
                'url' => null,
                'fields' => $validator->errors()
            ]);
        }
    }

    /**
     * Exibe a edicao
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $mainModel = $this->mainmodel->newQuery()->find($id);

        return view('administrator.user.record', compact('mainModel'));
    }

    /**
     * Realiza a edicao
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' .$id. ',id'
        ]);

        if(!$validator->fails()){
            $mainModel = $this->mainmodel->newQuery()->find($id);
            $mainModel->update($request->all());

            return response()->json([
                'result' => true,
                'messages' => 'Registro alterado',
                'url' => route('administrator.user.index')
            ]);
        }
        else{
            return response()->json([
                'result' => false,
                'messages' => 'Preencha os campos corretamente',
                'url' => null,
                'fields' => $validator->errors()
            ]);
        }
    }
}
