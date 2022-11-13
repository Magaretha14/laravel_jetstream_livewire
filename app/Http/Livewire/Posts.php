<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{
    public $posts, $nama, $boygrup, $post_id;
    public $isOpen = 0;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    public function openModal()
    {
        $this->isOpen = true;
    }   
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    public function closeModal()
    {
        $this->isOpen = false;
    }
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    private function resetInputFields()
    {
        $this->nama = '';
        $this->boygrup = '';
        $this->post_id = '';
    }
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'boygrup' => 'required',
        ]);

        Post::updateOrCreate(['id' => $this->post_id], [
            'nama' => $this->nama,
            'boygrup' => $this->boygrup
        ]);
        session()->flash(
            'message',
            $this->post_id ? 'Post Updated Successfully.' : 'Post Created 
            Successfully.'
        );
        $this->closeModal();
        $this->resetInputFields();
    } 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $posts = Post::findOrFail($id);
        $this->post_id = $id;
        $this->nama = $posts->nama;
        $this->boygrup = $posts->boygrup;
    
        $this->openModal();
    }
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Posts Deleted Successfully.');
    }
}
