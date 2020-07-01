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
	// add pizza to table pizza
	public function addPizza(){
		helper(['form']);
		$data = [];
		if($this->request->getMethod() == "post"){
			$rules = [
				'name'=>'alpha_space|required',
				'prize'=>'required|numeric|max_length[50]|min_length[1]|numeric',
				'ingredients'=>'required'
			];
			// if differnt from rule above it will diplay error message
		    if(!$this->validate($rules)){
				$data['validation'] = $this->validator;
				return redirect()->to("/dashboard");
			}
			// insert data to table
			else{			
				$pizza = new PizzaModel();
				$pizzaData = array(
					'name'=>$this->request->getVar('name'),
					'prize'=>$this->request->getVar('prize'),
					'ingredients'=>$this->request->getVar('ingredients'),
				);
				$pizza->createPizza($pizzaData);
				return redirect()->to("/dashboard");
			}
	    }	
		return view('index',$data);
	}

	// edit pizza data
	public function editPizza($id)
	{
		$pizza = new PizzaModel();
		$data['pizza'] = $pizza->find($id);
		return view('index',$data);
	}
		// update piza data
		public function updatePizza(){
			$pizza = new PizzaModel();
			$pizza->update($_POST['id'], $_POST);
			return redirect()->to('/dashboard');
		}

	// delete pizza data from table pizza
	public function deletePizza($id){
		$pizza = new PizzaModel();
		$pizza->find($id);
		$delete = $pizza->delete($id);
		return redirect()->to("/dashboard");
	}
}
