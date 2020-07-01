<?php namespace App\Controllers;
use App\Models\PizzaModel;
class Dashboard extends BaseController
{
	
	public function index()
	{	
		$pizza = new PizzaModel();
		$data['pizzas'] = $pizza->findAll();
		return view('index',$data);
	}
	// add pizza to table pizza
	public function addPizza(){
		$data = [];
		if($this->request->getMethod() == "post"){
			helper(['form']);
			$rules = [
				'name'=>'required',
				'prize'=>'required|numeric|max_length[50]|min_length[1]',
			];
		    if(!$this->validate($rules)){
				$data['validation'] = $this->validator;
				return redirect()->to("/dashboard");
			}
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
		return view("index",$data);
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
