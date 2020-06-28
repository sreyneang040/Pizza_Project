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
		$data = [];
		if($this->request->getMethod() == "post"){
			$rules = [
				'name'=>'required',
				'ingredients'=>'required',
				'prize'=>'required'
			];
		    if(!$this->validate($rules)){
				$data['validation'] = $this->validator;
				// return view('index',$data);	
			}
			else{
				
				$pizza = new PizzaModel();
				$pizzaData = array(
					'name'=>$this->request->getVar('name'),
					'ingredients'=>$this->request->getVar('ingredients'),
					'prize'=>$this->request->getVar('ingredients'),
				);
				$pizza->createPizza($pizzaData);
				return redirect()->to("/dashboard");
			}
	    }	
		return view('index',$data);
	}
	// public function editPizza($id)
	// {
	// 	$pizza = new PizzaModel();
	// 	$data['pizzaList'] = $pizza->find($id);
	// 	return view('index',$data);
	// }
	// public function updatePizza(){
	// 	$pizza = new PizzaModel();
	// 	$pizza->update($_POST['id'], $_POST);
	// 	return redirect()->to('/dashboard');
	// }

	public function deletePizza($id){
		$pizza = new PizzaModel();
		$pizza->find($id);
		$delete = $pizza->delete($id);
		return redirect()->to("/dashboard");
	}
}
