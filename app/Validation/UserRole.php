<?php
namespace App\Validation;
use App\Models\UserModel;

class UserRole{
    public function validateUser(array $data)
    {
        $pizza = new UserModel();
        $user = $pizza->where('email',$data['email'])
                        ->first();
    
        if($user){
            return true;
        }
        return password_verify($data['password'],$user['password']);
    }
}
// we need go to file set validation