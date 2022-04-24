<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;//agregamos el modelo post para traer la info de la bbdd
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithFileUploads;//guardar archivos
    use WithPagination;//usar la paginación sin refresh

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
    
    //VAMOS A INTEGRAR LA OPCIÓN DE EDIT A ESTE COMPONENTE PARA NO RECARGAR LA PAGINA CON COMPONENTES EDIT ANIDADOS Y HACE 1 SOLO
    //EMPEZAREMOS AÑADIENDO PROPIEDADES PARA RECIBIR LOS DATOS 

    
    public $post,$image,$identificador;//propiedades para albergar los datos de los registros y modificarlos o crearlos

    //CREAMOS LA PROPIEDAD QUE VA A SER LIGADA A LA VISTA TIENE QUE TENER EL MISMO NOMBRE QUE EN EL IMPUT
    
    public $search='';
    //CREAMOS LAS PROPIEDADES QUE VAN A ORDENAR NUESTRA TABLA
    public $sort='id';
    public $direction='desc';
    public $cant='10';
    public $readyToLoad=false;//propiedad para cargar el contenido despues de cargar la plantilla. Esto es útil cuando el contenido a mostrar de la base de datos es pesado como las imagenes

    public $open_edit=false;//Abre y cierra el modal edit

    //array en el que ponemos a escuchar los eventos que se emitan y le pasamos el método que debe renderizar

    //protected $listeners=['render'=>'render'];

    //Si en el listeners la escucha del evento y el método que va a usar se esciben igual 'render'=>'render' obtenemos lo mismo de esta manera
    protected $listeners=['render','delete'];

    protected $queryString = [// Esta propiedad nos permite poner en la url las opciones que nosotros cambienos en la tabla exceptuando las opciones por defecto
        'cant' => ['except'=>'10'],
        'sort' => ['except'=>'id'],
        'direction' => ['except'=>'desc'],
        'search' => ['except'=>''],
    ];

    public function mount(){
        $this->identificador=rand();
        $this->post= new Post();
    }

    //METODO QUE ACTUA CUANDO LA PROPIEDAD SEARCH CAMBIA
    public function updatingSearch(){
        $this->resetPage();//metodo que resetea la paginación al escribir algo en search
    }

    //NECESITAMOS LAS VALIDACIONES PARA PODER USAR LAS PROPIEDADES DE $POST EN LA VISTA EDIT
    
    protected $rules=[
        'post.title' => 'required|min:8|max:25',
        'post.content' => 'required|min:10',               
    ];

    
    public function render()
    {
        if ($this->readyToLoad) {//hasta que no haya cargado la página no empezamos a cargar la info de la BBDD
            $posts=Post::where('title', 'like', '%' . $this->search . '%')//aqui nos traemos la información de la bbdd y le agregamos un filtro que se updatee al momento
                    ->orWhere('content', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)//aqui lo ordenamos con las propiedades que se escojan
                    ->paginate($this->cant);            
        }else{
            $posts=[];
        }
        return view('livewire.show-posts', compact('posts'));        
    }

    //funcion que se ejecuta al cargar la página y nos da paso a cargar el contenido

    public function loadPosts(){
        $this->readyToLoad=true;
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

    // METODO QUE RECIBE UN REGISTRO DE POST Y SE LO PASA AL MODAL DE EDITAR Y LO ABRE

    public function edit(Post $post){
        $this->post=$post;
        $this->open_edit=true;
    }

    //METODO QUE GUARDA LOS CAMBIOS EDITADOS EN LOS REGISTROS Y MUESTRA DE NUEVO LA VISTA

    public function update(){
        $this->validate();

        if($this->image){
            Storage::delete([$this->post->image]);//borramos la anterior
            $this->post->image=$this->image->store('posts');//guardamos la imagen en la capeta posts y también la guardo en la propiedad image de post            
        }

        $this->post->save();        

        $this->reset('open_edit','image');

        $this->identificador=rand();        

        $this->emit('alert','Bien hecho','Se editó correctamente el post');
    }

    public function delete(Post $post){
        $post->delete();
    }
    
}
