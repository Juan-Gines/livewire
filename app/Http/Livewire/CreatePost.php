<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;//para poder subir archivos
use Illuminate\Support\Facades\Storage;

class CreatePost extends Component
{
    use WithFileUploads;//para poder subir archivos

    public $open=false;

    public $title,$content,$image,$identificador;//la variable identificador va a ser la que nos ayude a resetear el input file
    
    public function mount(){
        $this->identificador=rand();
    }

    //definimos la reglas de validación para nuestros inputs

    protected $rules=[
        'title' => 'required|max:25',
        'content' => 'required|min:10',
        'image' => 'required|image|max:2048'
    ];

    //agregamos interactividad a las validaciones con este método.
    //este se encarga de actuar cuando se modifiquen las propiedades que definamos dentro de el

    protected function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function save(){

        $this->validate();

        $image=$this->image->store('posts');//guardamos la imagen en la capeta posts

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image//guadamos la info de la imagen en la DDBB
        ]);
        //emitimos un evento para refrescar el componente showpost
        //$this->emit('render');
        //Podemos limitar la emisión del evento a un solo componente de esta manera asi no renderiza todos los eventos que escuchen 'render'
        $this->emitTo('show-posts','render');
        //una vez refrescada la vista necesitamos cerrar el modal y limpiar los campos, el metodo reset nos lleva las propiedades al contenido inicial
        $this->reset('title','content','open','image');

        //cambiamos el valor de identificador de nuevo
        $this->identificador=rand();

        //Ahora queremos que cuando se haya agregado el post y cerrado el modal, nos aparezca una alerta.Para ello emitimos otro evento
        $this->emit('alert','Bien hecho','Se guardó correctamente el post');
    }

    public function render()
    {
        
        return view('livewire.create-post');
    }

    //creamos el evento hook que nos va a resetear el create cuando lo cerremos y volvamos a abrir

    public function updatingOpen(){
        if(!$this->open){
            $this->reset('title','content','image');
            $this->identificador=rand();
            $this->emit('resetCKEditor');
        }
    }
}
