<?php
namespace App\Models;
use CodeIgniter\Model;

class PizzaModel extends Model{
    protected $table = "pizza_info";
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $allowedFields = ['name','ingredients','prize'];
    
    public function createPizza($pizzaInfo){
        $this->insert([
            'name' => $pizzaInfo['name'],
            'prize' => $pizzaInfo['prize'],
            'ingredients' => $pizzaInfo['ingredients'],
        ]);
    }

}
