<?php

use App\Http\Requests\Taskrequest;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Task;



#demo task data
// class Task
// {
//   public function __construct(
//     public int $id,
//     public string $title,
//     public string $description,
//     public ?string $long_description,
//     public bool $completed,
//     public string $created_at,
//     public string $updated_at
//   ) {
//   }
// }

// $tasks = [
//   new Task(
//     1,
//     'Buy groceries',
//     'Task 1 description',
//     'Task 1 long description',
//     false,
//     '2023-03-01 12:00:00',
//     '2023-03-01 12:00:00'
//   ),
//   new Task(
//     2,
//     'Sell old stuff',
//     'Task 2 description',
//     null,
//     false,
//     '2023-03-02 12:00:00',
//     '2023-03-02 12:00:00'
//   ),
//   new Task(
//     3,
//     'Learn programming',
//     'Task 3 description',
//     'Task 3 long description',
//     true,
//     '2023-03-03 12:00:00',
//     '2023-03-03 12:00:00'
//   ),
//   new Task(
//     4,
//     'Take dogs for a walk',
//     'Task 4 description',
//     null,
//     false,
//     '2023-03-04 12:00:00',
//     '2023-03-04 12:00:00'
//   ),
// ];

#redirect the main page to the tasks page
Route::get('/', function(){
    return redirect()->route('task.index');
});


// for using the dummy data only
// Route::get('/tasks', function () use ($tasks){ # using the use to pass the tasks variable to the anonymous function
    
//     #showing a different view (also passing the data to the blade template as a php associative array)
//     return view ('index',[
//         #'name' => 'GM' # hide it to check if isset directive is working
//         'tasks' => $tasks
//     ]);

//     #original welcome view
//     #return view('welcome');

// })->name('task.index');

//for using the data from the database
Route::get('/tasks', function () { # using the use to pass the tasks variable to the anonymous function
    
  #showing a different view (also passing the data to the blade template as a php associative array)
  return view ('index',[
      #'name' => 'GM' # hide it to check if isset directive is working
      #'tasks' => Task::all(), #fetching all the tasks from the database
      #'tasks' => Task::latest()->get(), #fetching all the latest tasks from the database (this is the query builder syntax for SQL in object orinted way)
      #'tasks' => Task::latest()->where('completed', true)->get(), #fetching all the latest tasks from the database that are completed (query builder method))

      #using pagination (build in functionality by laravel)
      'tasks' => Task::latest()->paginate(10) //automatically creates the pagination links and divides the data into pages, showing 10 tasks per page
  ]);

  #original welcome view
  #return view('welcome');

})->name('task.index');

#display the individual task details (using the dummy data)
// Route::get('tasks/{id}', function($id) use ($tasks) {

//     #using laravel collection (convert the array to the laravel collection) so you can use the collection methods
//     #firstWhere is a collection method that returns the first element that matches the given condition
//     $task = collect($tasks)->firstWhere('id',$id);

//     #if task is not found, return 404 error
//     if (!$task)
//     {
//         abort(HttpResponse::HTTP_NOT_FOUND);
//     }

//     return view('show',['task'=>$task]);
//     #return 'One Single Task';
// })->name('task.show');

#order in which the route are defined matters in laravel, if i defined this route after the get('tasks/{id}') route, it will be not calling the get('tasks/{id}') route
Route::view('/tasks/create','create')->name('task.create');

#old method to edit the task details
// Route::get('tasks/{id}/edit', function($id) {

//   //using the model method findorfail to get the task details (fetch the one single row from the database)
//   $task = Task::findorfail($id);

//   return view('edit',['task'=>$task]);
//   #return 'One Single Task';
// })->name('task.edit');

#new method to get the task details using the route model binding (implicit binding)
Route::get('tasks/{task}/edit', function(Task $task) {

  // impilicit binding is a feature in laravel that allows you to automatically resolve the model instance based on the route parameter
  return view('edit',['task'=>$task]);
  #return 'One Single Task';
})->name('task.edit');

//old method to get the task details
//using the database data to get the task details
// Route::get('tasks/{id}', function($id) {

//   //using the model method findorfail to get the task details (fetch the one single row from the database)
//   $task = Task::findorfail($id);

//   return view('show',['task'=>$task]);
//   #return 'One Single Task';
// })->name('task.show');

Route::get('tasks/{task}', function(Task $task) {

  // using implicit binding to get the task details (model gets injected into the route but if model is not found, it will return 404 error)
  return view('show',['task'=>$task]); // by default laravel will assume that the task is the id.
  #return 'One Single Task';
})->name('task.show');

Route::post('/tasks', function(Taskrequest $request){
  #dd($request->all());

  // removing the validation as it has been moved in the task request class
  // $data = $request->validate([
  //   'title' => 'required|max:255',
  //   'description' => 'required',
  //   'long_description' => 'required',
  // ]);

  //now to access the data from the Taskrequest class we can do the following:
  $data = $request->validated(); // this will return the validated data from the request class


  //old method of creating a new task
  // $task = new Task;
  // $task->title = $data['title'];
  // $task->description = $data['description'];
  // $task->long_description = $data['long_description'];
  // $task->save();

  //calling the create method from the task model which accepts an array of data as parameter which we can get from the validated data since 
  // validated data is an array of keyvalue pairs

  //new method of creating a new task
  $task = Task::create($data); // this is example of the mass assignment


  // old method of redirect
  //return redirect()->route('task.show', ['id' => $task->id])->with('success','Task created successfully!'); //showing the flash message of success


  //new method of redirect using the implicit binding
  return redirect()->route('task.show', ['task' => $task->id])->with('success','Task created successfully!'); //showing the flash message of success

})->name('task.store');

//old method to update the task details
// Route::put('/tasks/{id}', function($id,Request $request){
//   #dd($request->all());
//   $data = $request->validate([
//     'title' => 'required|max:255',
//     'description' => 'required',
//     'long_description' => 'required',
//   ]);

//   $task = Task::findorfail($id);
//   $task->title = $data['title'];
//   $task->description = $data['description'];
//   $task->long_description = $data['long_description'];
//   $task->save(); //db will run the update query here since laravel knows that the route is a put request

//   return redirect()->route('task.show', ['id' => $task->id])->with('success','Task updated successfully!'); //showing the flash message of success

// })->name('task.update');

//new method to update the task details using the route model binding (implicit binding)
Route::put('/tasks/{task}', function(Task $task,Taskrequest $request){
  #dd($request->all());

  //removing the validation as it has been moved in the task request class
  // $data = $request->validate([
  //   'title' => 'required|max:255',
  //   'description' => 'required',
  //   'long_description' => 'required',
  // ]);

  //now to access the data from the Taskrequest class we can do the following:
  $data = $request->validated(); // this will return the validated data from the request class, validation happens before the request of this route is called


  //old method of updating the task details


  #$task = Task::findorfail($id);
  // $task->title = $data['title'];
  // $task->description = $data['description'];
  // $task->long_description = $data['long_description'];
  // $task->save(); //db will run the update query here since laravel knows that the route is a put request

  //new method of updating the task details
  // since we have the implicit binding, we can directly use the update method from the task model (make sure the properties are fillable in the model for this to work)
  $task->update($data); // this is example of the mass assignment

  // old method of redirect 
  //return redirect()->route('task.show', ['id' => $task->id])->with('success','Task updated successfully!'); //showing the flash message of success

  // new method of redirect using the implicit binding
  return redirect()->route('task.show', ['task' => $task->id])->with('success','Task updated successfully!'); //showing the flash message of success

})->name('task.update');

//dynamic route that takes the name and greets it
// Route::get('/greet/{name}', function($name) {
//     return 'Hello ' . $name . '!';
// });

// //redirect url example (with named route)
// Route::get('hello', function(){
//     // redirect to the home page
//     #return redirect('/');

//     // redirect using named route
//     return redirect()->route('home');
// })->name('hello123'); // named route is defined here

// //fallback route to catch all route that are not defined
// Route::fallback(function(){
//     return 'You got lost!';
// });

#creating a new route for the delete the task
Route::delete('/tasks/{task}', function(Task $task) {
  #using model binding we can get the task and use the delete method to delete the task
  $task->delete();

  #redirect to the index page
  return redirect()->route('task.index')->with('success', 'Task deleted successfully!');
})->name('task.destroy');


#creating a new route for toggle complete the task
Route::put('/tasks/{task}/toggle-complete', function(Task $task) {
  $task->toggleComplete();

  return redirect()->back()->with('success', 'Task Completed Status Updated!');
})->name('task.toggle-complete');