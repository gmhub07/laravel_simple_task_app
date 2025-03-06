<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // using the HasFactory trait to allow the task model to use the factory methods
    use HasFactory;

    //to allow the mass assignment, we set the fillable property of the model.
    protected $fillable = ['title','description','long_description']; // add all the columns of the model where we need to allow the mass assignment

    /**this is done due to the security reasons since fillable property is off by default in laravel due to the security reasons as we donot want to allow
     * the mass assignment of the hidden columns of the model like id, password etc.
    **/

    public function toggleComplete(){
        $this->completed = !$this->completed;
        $this->save();
    }

}
