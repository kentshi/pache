<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Mail;
use \Htmldom;

class CarController extends Controller
{
  private $url_base = 'https://www.carsales.com.au/new-cars/';

  public function index(){
    // $car = Car::all();
    // dd($car);
    return view('cars.index');
  }

  public function create(){
    $car1 = new Car();
    $car1->fill(['brand'=>'bmw', 'model' => '', 'variant' => '', 'msrp' => '0.00'])->save();
  }

  public function store(Request $request){
    $webpage=$request->input('webpage');

    $html = new \Htmldom();
    // Load HTML from a string
    $html->load($webpage);
    // foreach($html->find('div.model-list-items') as $element) {
    //   foreach($element->find('article._c-model-card') as $card){
    //     $title = $card->find('a._c-model-card__title', 0);
    //     dd($title->plaintext);
    //   }
    // }
    $data = [];
    foreach($html->find('article._c-vehicle-card') as $element){
      $title = trim($element->find('._c-vehicle-card__title', 0)->plaintext);
      $price = preg_replace('/\$|,/', '', $element->find('._c-vehicle-card__price', 0)->find('._c-price__amount', 0)->plaintext);
      $data[] = ['title' => $title, 'price' => $price];
    }
    dd($data);
  }

  public function update(Request $request){

  }

  public function destroy($id){

  }

  public function show($id){

  }

  public function edit($id){

  }

  public function pa(){
    $page = $this->get_web_content($this->url_base . 'audi/');
    // Mail::to('kent@maiche.com.au')->body($page)->send();

    $html = new \Htmldom();
    // Load HTML from a string
    $html->load($page);
    foreach($html->find('div.model-list-items') as $element) {
      foreach($element->find('article._c-model-card') as $card){
        dd($card);
        $title = $card->find('._c-model-card__title');
        dd($title);
      }
    }
  }
}
