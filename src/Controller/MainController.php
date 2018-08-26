<?php
namespace Controller;
class MainController{
	private $currentActive=NULL;

	private $controller=NULL;

	private static $menu=[
		"PolynomExampleController" => "Polynom Formattierungs Beispiel",
		"FunctionExampleController" => "Funktionsauswertung Beispiel",
		"LagrangeController" => "Lagrange Interpolation",
		"NewtonController" => "Newton Interpolation",
		"CubicSplinesController" => "Kubische Splines Interpolation",
		"ButcherTableController" => "Butcher Tableu",
		"MatrixController" => "Matrix",
		"CholeskyDecompositionController" => "Cholesky Zerlegung",
		"OneDimensionalTestSeriesController" => "1D Messreihe",
		"TwoDimensionalTestSeriesController" => "2D Messreihe"
	];

	public function __construct($controller){
		if($controller !== NULL){
			if(in_array($controller, array_keys(self::$menu))){
				$test = new PolynomExampleController();
				$this->currentActive=$controller;
				$controller="\Controller\\".$controller;
				$this->controller = new $controller;
				$this->controller->setData($_GET);
			}
		}
	}

	public function getInputHTML(){
		if($this->controller !== NULL){
			return $this->controller->getInputHTML();
		}
	} 

	public function getOutputHTML(){
		if($this->controller !== NULL){
			try{
				$html =  $this->controller->getOutputHTML();
			}catch(\Exception $e){
				$html= "Es ist ein Fehler aufgetreten:<br>".get_class($e)."<br>".$e->getMessage();
			}
			return $html;
		}
	}

	public function getMenuHTML(){
		$html = '<ul class="nav nav-sidebar">';

		foreach(self::$menu as $controller => $label){
			$html.='<li '.(($controller === $this->currentActive)?' class="active"':'').'><a href="'.$controller.'">'.$label.'</a></li>';
		}

		$html.= '</ul>';
		return $html;
	}

	public static function getControllerNames(){
		return array_keys(self::$menu);
	}

	public function getChartHTML(){
		if($this->controller !== NULL && $this->controller->getChart() !== NULL){
			if(is_array($this->controller->getChart())){
				$html = "";
				foreach($this->controller->getChart() as $chart){
					$html.=$chart->getHTML();
				}
				return $html;
			}else{
				if(is_string($this->controller->getChart())){
					return $this->controller->getChart();
				}
				return $this->controller->getChart()->getHTML();
			}
			
		}
	}
}