<?php namespace App\Controllers;
use App\Models\PizzaModel;
class Dashboard extends BaseController
{
	public function index()
	{	
		$pizza = new PizzaModel();
		$data['listPizza'] = $pizza->findAll();
		return view('index',$data);
	}

	public function addPizza(){
		helper(['form']);
		$error = [];
		if($this->request->getMethod() == "post"){
			$rules = [
				'name'=>'required',
				'ingredients'=>'required',
				'prize'=>'required'
			];
		    if($this->validate($rules)){
				$pizza = new PizzaModel();
				$name = $this->request->getVar('name');
				$prize = $this->request->getVar('prize');
				$ingredients = $this->request->getVar('ingredients');
				$pizzaData = array(
					'name'=>$name,
					'ingredients'=>$ingredients,
					'prize'=>$prize
				);
				$pizza->createPizza($pizzaData);
				return redirect()->to("/dashboard");
			}
			else{
				$error['validation'] = $this->validator;
				return view('/dashboard',$error);
			}
	    }	
		return view('index',$data);
	}
	public function editPizza($id)
	{
		$pizza = new PizzaModel();
		$data['pizzaList'] = $pizza->find($id);
		return view('index',$data);
	}
	public function updatePizza(){
		$pizza = new PizzaModel();
		$pizza->update($_POST['id'], $_POST);
		return redirect()->to('/dashboard');
	}

	public function deletePizza($id){
		$pizza = new PizzaModel();
		$pizza->find($id);
		$delete = $pizza->delete($id);
		return redirect()->to("/dashboard");
	}
}
