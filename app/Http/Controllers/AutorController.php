<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File; 

use Illuminate\Http\Request;

use App\Models\Llibre;
use App\Models\Autor;

class AutorController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function list() 
    { 
      $autors = Autor::all();

      return view('autor.list', ['autors' => $autors]);
    }

    function new(Request $request) 
    { 
      if ($request->isMethod('post')) {    
        // recollim els camps del formulari en un objecte autor
        $validated = $request->validate([
          'nom' => 'required|string|max:20',
          'cognoms' => 'required|string|max:30',
      ], 
      ['nom.required' => "El nom es obligatori.",
       'cognoms.required' => "Els cognoms son obligatoris.",
       'nom.max' => "El nom ha de ser inferior a 20.",
       'cognoms.max' => "Els cognoms han de ser inferior a 30",
       ]);

        $autor = new Autor;
        $autor->nom = $request->nom;
        $autor->cognoms = $request->cognoms;

        if($request->file('imatge')){
          $file = $request->file('imatge');
          //guardem en una variable $filename el nom que posarem al fitxer
          //$filename = $file->getClientOriginalName();
          $filename = $request->nom.'_'.$request->cognoms.'.'.$file->getClientOriginalExtension();
          $file->move(public_path(env('RUTA_IMATGES')), $filename);
          $autor->imatge = $filename;
        }

        $autor->save();

        return redirect()->route('autor_list')->with('status', 'Nou autor '.$autor->nom.' '. $autor->cognoms .' creat!');
      }
      // si no venim de fer submit al formulari, hem de mostrar el formulari

      $autors = Autor::all();

      return view('autor.new', ['autors' => $autors]);
    }

    function delete($id) 
    { 
      $autor = Autor::find($id);
      $autor->delete();

      return redirect()->route('autor_list')->with('status', 'autor '.$autor->nom.' eliminat!');
    }

    function edit(Request $request, $id) 
    { 
      $autor = autor::find($id);
      if ($request->isMethod('post')) {    
        // recollim els camps del formulari en un objecte autor
        $autor->nom = $request->nom;
        $autor->cognoms = $request->cognoms;
        if($request->file('imatge')){
          File::delete(env('RUTA_IMATGES').$autor->imatge);
          $autor->imatge = NULL;
          $file = $request->file('imatge');
          //guardem en una variable $filename el nom que posarem al fitxer
          //$filename = $file->getClientOriginalName();
          $filename = $request->nom.'_'.$request->cognoms.'.'.$file->getClientOriginalExtension();
          $file->move(public_path(env('RUTA_IMATGES')), $filename);
          $autor->imatge = $filename;
        }
        if (isset($request->esborrarImg)) {
          File::delete(env('RUTA_IMATGES').$autor->imatge);
          $autor->imatge = NULL;
        }


        $autor->save();

        return redirect()->route('autor_list')->with('status', 'autor '.$autor->nom.' editat!');
      }
      // si no venim de fer submit al formulari, hem de mostrar el formulari

      $autors = Autor::all();

      return view('autor.edit', ['autors' => $autors, 'autor' => $autor]);
    }
}