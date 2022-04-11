<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;//agregamos el modelo post para traer la info de la bbdd

class ShowPosts extends Component
{
    /*esta propiedad recibe el valor que le pasamos de la vista y la podemos utilizar en el componente si utilizamos un nombre diferente en la vista del componente podemos usar la función mount()
    public $titulo;
    public $title;

    public function mount($title){
        $this->titulo=$title;
    } */

    /* Ahora si queremos usar otra plantilla cuando usamos un componente como controller haríamos así. Le pondríamos el return view('livewire.show-posts')
        ->layout('layouts.base'); 
    */

    /* Para recuperar la informacion pasada por la url desde la ruta escribimos este metodo
    

    public $name;

    public function mount($name){

        $this->name=$name;

    }
    */

    //CREAMOS LA PROPIEDAD QUE VA A SER LIGADA A LA VISTA TIENE QUE TENER EL MISMO NOMBRE QUE EN EL IMPUT
    public $search;
    //CREAMOS LAS PROPIEDADES QUE VAN A ORDENAR NUESTRA TABLA
    public $sort='id';
    public $direction='desc';

    public function render()
    {
        //aqui nos traemos la información de la bbdd y le agregamos un filtro que se updatee al momento
        $posts=Post::where('title', 'like' , '%' . $this->search . '%')
                    ->orWhere('content', 'like' , '%' . $this->search . '%')
                    ->orderBy($this->sort,$this->direction)
                    ->get();
        return view('livewire.show-posts',compact('posts'));        
    }

    //escribimos el metódo que va a realizar la acción de modificar el orden al hacer click

    public function order($sort){
        if ($this->sort==$sort) {
            if ($this->direction=='desc') {
                $this->direction='asc';
            } else {
                $this->direction='desc';
            }            
        } else {
            $this->sort=$sort;
            $this->direction='asc';
        }
        
        
    }
}
