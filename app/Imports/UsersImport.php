<?php

namespace App\Imports;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        $role = Role::where('nom', $row[8])->first();
        
        if (!$role || empty($row[6])) {
            return null; 
        }

        $data = [
            'nom' => $row[1],
            'prenom' => $row[2],
            'code_unique' => $row[0],
            'email' => $row[6],
            'role_id' => $role->id,
        ];

        $request = new UserRequest();

        $request->mapFromApiResponse($data);

        $validation = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'code_unique' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'role_id' => ['integer', 'exists:roles,id'],
        ]);

        if ($validation->fails()) {
            return null;
        }

        $user = User::where('code_unique', $row[0])->first();

        if(!$user){
            
            return new User([
                'nom' => $row[1],
                'prenom' => $row[2],
                'email' => $row[6],
                'password' => Hash::make('12345678'),
                'code_unique' => $row[0],
                'role_id' => $role->id,
                'telephone' => $row[4],
                'domicile' => $row[5],
                'ifu' => $row[7],
                'compte_bancaire' => $row[12],
                'service_id' => $role->service_id,
                'sexe' => $row[3],
                'mode_reglement' => $row[10],
                // 'date_naissance' => $row[0],
                'lieu_naissance' => $row[5],
                'fixe' => $row[13],
                'banque' => $row[11],
                // 'date_collaboration' => $row[9],
            ]);
        }
    }

}
