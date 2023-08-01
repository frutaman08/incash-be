<?php

namespace App\Http\Controllers\API;

use App\Helper\ResponseDefault;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseDefault;
    //
    public function index()
    {
        $users = User::paginate('10');
        $arr = $users->toArray();
        return $this->setSuccessResponse($arr['data'], 200, [
            'total' => $arr['total'],
            'from' => $arr['from'],
            'to' => $arr['to'],
            'per_page' => $arr['per_page'],
            'current_page' => $arr['current_page']
        ]);
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return $this->setSuccessResponse($user, 200);
        } catch(ModelNotFoundException) {
            return $this->setErrorResponse(null, 404);
        }
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
