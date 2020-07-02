<?php namespace App\Controllers;
use App\Models\PizzaModel;
class Pizzas extends BaseController
{
	// display Pizza data in table list
	public function index()
	{	
		$pizza = new PizzaModel();
		$data['pizzas'] = $pizza->findAll();
		return view('index',$data);
	}

	// add pizza to table pizza
	public function addPizza(){
		$data = [];
		helper(['form']);
		if($this->request->getMethod() == "post"){
			$rules = [
				'name'=>'required',
				'prize'=>'required|numeric|max_length[50]|min_length[1]',
				'ingredients'=>'required',
			];
		    if(!$this->validate($rules)){
				$data['validation'] = $this->validator;
				return redirect()->to("/dashboard");
			}
			else{
				$pizza = new PizzaModel();
					$name = $this->request->getVar('name');
					$price = $this->request->getVar('prize');
					$ingredients = $this->request->getVar('ingredients');
					$pizzaData = array(
						'name'=>$name,
						'prize'=>$price,
						'ingredients'=>$ingredients
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
			$data = [];
			helper(['form']);
			if($this->request->getMethod() == "post"){
				$rules = [
					'name'=>'required',
					'prize'=>'required|min_length[1]|max_length[50]',
					'ingredients'=>'required',
				];
				 if($this->validate($rules)){
					$pizza = new PizzaModel();
					$id = $this->request->getVar('id');
					$name = $this->request->getVar('name');
					$price = $this->request->getVar('prize');
					$ingredients = $this->request->getVar('ingredients');
					$pizzaData = array(
						'name'=>$name,
						'prize'=>$price,
						'ingredients'=>$ingredients
					);
					$pizza->update($id,$pizzaData);
					return redirect()->to('/dashboard');
				}else{
					$data['validation'] = $this->validator;
					return redirect()->to('/dashboard');
				}
			}
			return view('/index',$data);
			
		}

	// delete pizza data from table pizza
	public function deletePizza($id){
		$pizza = new PizzaModel();
		$pizza->find($id);
		$delete = $pizza->delete($id);
		return redirect()->to("/dashboard");
	}
}
