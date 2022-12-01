<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Models\Llibre;
use App\Models\Autor;

class LlibreController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function list() 
    { 
      $llibres = Llibre::all();

      return view('llibre.list', ['llibres' => $llibres]);
    }

    function new(Request $request) 
    { 
      if ($request->isMethod('post')) {    
        // recollim els camps del formulari en un objecte llibre
        
        $validated = $request->validate([
          'titol' => 'required|string|max:20|min:2',
          'vendes' => 'required',
          'dataP' => 'required|date|before_or_equal:'.date('d-m-Y'),
      ], 
      ['titol.required' => "El titol es obligatori.",
       'titol.max' => "El titol ha de ser inferior a 20.",
       'titol.min' => "El titol ha de ser superior a 2",
       'vendes.required' => "Les vendes son obligatories.",
       'dataP.before_or_equal' => "La data ha de ser anterior o igual a la de avui."]);
        

        $llibre = new Llibre;
        $llibre->titol = $request->titol;
        $llibre->dataP = $request->dataP;
        $llibre->vendes = $request->vendes;
        $llibre->autor_id = $request->autor_id;
        $llibre->save();

        if ($llibre->autor_id == null) {
          return redirect()->route('llibre_list')->with('status', 'Nou llibre '.$llibre->titol.' creat!') -> withoutCookie('autor');
        }
        else {
          return redirect()->route('llibre_list')->with('status', 'Nou llibre '.$llibre->titol.' creat!') -> cookie('autor', $llibre->autor_id, 60);
        }

      }
      // si no venim de fer submit al formulari, hem de mostrar el formulari

      $autors = Autor::all();
      $autorId = $request->cookie('autor');
        return view('llibre.new', ['autors' => $autors, 'autorId'=>$autorId] );
    }

    function delete($id) 
    { 
      $llibre = Llibre::find($id);
      $llibre->delete();

      return redirect()->route('llibre_list')->with('status', 'Llibre '.$llibre->titol.' eliminat!');
    }

    function edit(Request $request, $id) 
    { 
      $llibre = Llibre::find($id);
      if ($request->isMethod('post')) {    
        // recollim els camps del formulari en un objecte llibre
        $llibre->titol = $request->titol;
        $llibre->dataP = $request->dataP;
        $llibre->vendes = $request->vendes;
        $llibre->autor_id = $request->autor_id;
        $llibre->save();

        return redirect()->route('llibre_list')->with('status', 'Llibre '.$llibre->titol.' editat!');
      }
      // si no venim de fer submit al formulari, hem de mostrar el formulari

      $autors = Autor::all();

      return view('llibre.edit', ['autors' => $autors, 'llibre' => $llibre]);
    }
}