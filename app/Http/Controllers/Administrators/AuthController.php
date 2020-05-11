<?php

namespace App\Http\Controllers\Administrators;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helpers;
use Illuminate\Support\Str;
use Mail;

use App\Models\User;

class AuthController extends Controller {
    protected $userModel;
    protected $niceNames;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
        $this->niceNames = array('email' => 'E-mail', 'password' => 'Senha', 'email_reset' => 'E-mail');
    }

    /**
     * Exibe a tela de login do admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(){
        return view('administrator.auth.login');
    }

    /**
     * Realiza o login do adm
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function doLogin(Request $request){
        $validator = Validator::make($request->all(), array(
            'email' => 'required|email',
            'password' => 'required'
        ));
        $validator->setAttributeNames($this->niceNames);

        if(!$validator->fails()) {
            if (Auth::guard('administrator')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'active' => 1])) {
                return redirect()->route('administrator.dashboard.index');
            }
            else{
                $errors = array('credenciais_invalidas' => array('Usuário e Senha inválidos'));
                return view('administrator.auth.login', compact('errors'));
            }
        }
        else{
            $errors = $validator->errors()->toArray();
            return view('administrator.auth.login', compact('errors'));
        }
    }

    /**
     * Faz o logout
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout(){
        Auth::guard('administrator')->logout();
        return redirect()->route('administrator.auth.login');
    }

    /**
     * Envia o email para o usuario redefinir a senha
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email_reset' => 'required|email'
        ]);

        if(!$validator->fails()){
            $user = $this->userModel->newQuery()->where('email', $request->input('email_reset'))->first();

            if(!is_null($user)) {
                $token = Str::random(64);
                $user->remember_token = $token;
                $user->save();

                $link = 'http://' . $request->getHttpHost().'/administrator/auth/'.$user->id.'/redefpassword/'.($token);
                Mail::send('administrator.emails.auth.resetpassword',
                    ['name' => $user->name, 'link' => $link],
                    function($message) use($request, $user){
                        $message->to($user->email, $user->name)
                            ->subject('Pizzaria 1900 - Redefinir Senha')
                            ->getSwiftMessage()
                            ->getHeaders()
                            ->addTextHeader('x-mailgun-native-send', 'true');
                    }
                );

                return response()->json([
                    'result' => true,
                    'messages' => 'Registro alterado',
                    'url' => route('administrator.user.index')
                ]);
            }
            else{
                return response()->json([
                    'result' => false,
                    'messages' => 'E-mail não encontrado',
                    'url' => null,
                    'fields' => array('E-mail não encontrado')
                ]);
            }
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
     * @param $id
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function redefPassword($id, $token){
        $user = $this->userModel->newQuery()->where(['id' => $id, 'remember_token' => $token])->first();

        if(!is_null($user)){
            return view('administrator.auth.redefpassword',
                compact('user', 'token')
            );
        }
        else{
            return redirect()->route(route('auth.login'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doRedefPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
            'user_id' => 'required',
            'remember_token' => 'required'
        ]);

        if(!$validator->fails()){
            $user = $this->userRepository->getByParams([
                'id' => $request->input('user_id'),
                'remember_token' => $request->input('remember_token')
            ]);

            if($user = $user->first()) {
                $user->password = Hash::make($request->input('password'));
                $user->save();
                $request->session()->flash('success', 'Senha redefinida');
                return redirect()->route('admin.auth.login');
            }
        }
        else{

        }
    }
}
