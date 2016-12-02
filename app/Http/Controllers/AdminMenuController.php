<?php

namespace App\Http\Controllers;
use Redirect, Input, Auth, View, Session, URL;

use Illuminate\Support\Collection; 

use App\App\Repositories\PermisoRepo;

class AdminMenuController {


	public function __construct(){

	}

    public function compose($view)
    {        

        $menu = new Collection();

		$menu->push((object)['title' => 'Dashboard', 'url' => URL::route('dashboard')]);
		$permisoRepo = new PermisoRepo();
		$view->menu = $permisoRepo->getMenu(Auth::user()->perfil_id, 1);


		/* GET USUARIO */
		$view->usuario = Auth::user();
		//dd($view->notificaciones);

    }

}