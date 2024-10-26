<?php

namespace App\Imports;

use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class UserSupImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::where('code_unique', $row[0])->first();

        if($user){
            $user_sup = User::where('id', $user->id)->get();
        
            foreach( range(1, 5) as $i){
                if(isset($row[$i])){
                    $sup = User::where('code_unique', $row[$i])->first();
                    if($sup){
                        if (!in_array($sup->id, $user_sup->toArray())) {
                            Supervisor::create([
                                'supervisor_id' => $sup->id,
                                'user_id' => $user->id,
                            ]);
                        }
                    }
                }
            }
        }

    }

}
