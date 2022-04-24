<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


// ESTE COMPONENTE SE REPITE TANTAS VECES COMO REGISTROS TENEMOS EN LA VISTA Y NOS RECARGA EL PROYECTO CARGANDO MODALES QUE NO VAMOS A USAR
// VAMOS A INTEGRARLO DENTRO DE LA VISTA SHOW-POSTS PARA CARGAR UNICAMENTE UN MODAL EL CUAL SE RELLENE DE LA INFO DEL REGISTRO QUE QUERAMOS

class EditPost extends Component
{
    use WithFileUploads;

    //definimos la propiedad que nos va a abrir el modal iniciandola en false
    public $open=false;

    //recibimos la info del post que viene de la vista y la agregamos a la propiedad post montandola con el método mount
    public $post,$image,$identificador;

    //definimos la reglas de validación para nuestros inputs

    protected $rules=[
        'post.title' => 'required|max:25',
        'post.content' => 'required|min:10',
        'image' => 'nullable|image|max:2048'        
    ];


    public function mount(Post $post){
        $this->post=$post;

        $this->identificador=rand();//borrar el contenido de input file

    }

    //agregamos interactividad a las validaciones con este método.
    //este se encarga de actuar cuando se modifiquen las propiedades que definamos dentro de el

    protected function updated($propertyName){
        $this->validateOnly($propertyName);

    }

    public function save(){
        $this->validate();

        if($this->image){
            Storage::delete([$this->post->image]);//borramos la anterior
            $this->post->image=$this->image->store('posts');//guardamos la imagen en la capeta posts y también la guardo en la propiedad image de post            
        }

        $this->post->save();        

        $this->reset('open','image');

        $this->identificador=rand();

        $this->emitTo('show-posts','render');

        $this->emit('alert','Bien hecho','Se editó correctamente el post');
    }

    public function render()
    {
        return view('livewire.edit-post');
    }

    
}
