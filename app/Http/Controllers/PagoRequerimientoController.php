<?php

namespace App\Http\Controllers;
use Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\PagoRequerimiento;
use App\App\Repositories\PagoRequerimientoRepo;
use App\App\Managers\PagoRequerimientoManager;

use App\App\Repositories\PolizaRequerimientoRepo;
use App\App\Repositories\PolizaRepo;
use App\App\Repositories\BancoRepo;
use App\App\Managers\SaveDataException;

class PagoRequerimientoController extends BaseController {

	protected $pagoRequerimientoRepo;
	protected $polizaRequerimientoRepo;
	protected $polizaRepo;
	protected $bancoRepo;

	public function __construct(PagoRequerimientoRepo $pagoRequerimientoRepo, PolizaRequerimientoRepo $polizaRequerimientoRepo, PolizaRepo $polizaRepo, BancoRepo $bancoRepo)
	{
		$this->pagoRequerimientoRepo = $pagoRequerimientoRepo;
		$this->polizaRequerimientoRepo = $polizaRequerimientoRepo;
		$this->polizaRepo = $polizaRepo;
		$this->bancoRepo = $bancoRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarAgregar($polizaId){
		$poliza = $this->polizaRepo->find($polizaId);
		$formasPago = Variable::getFormasPago();
		$requerimientos = $this->polizaRequerimientoRepo->getByPolizaByEstado($polizaId, ['N']);
		$bancos = $this->bancoRepo->lists('nombre','id');
		return View::make('administracion/pagos_requerimientos/agregar',compact('requerimientos','formasPago','bancos','poliza'));
	}

	public function agregar($polizaId)
	{
		$data = Input::all();
		$requerimientosSeleccionados = 0;
		foreach($data['requerimientos'] as $r){
			if(isset($r['check'])){
				$requerimientosSeleccionados++;
			}
		}
		if($requerimientosSeleccionados == 0)
		{
			throw new SaveDataException("Error", new \Exception('Por favor elija al menos un requerimiento a pagar.'));
		}


		$manager = new PagoRequerimientoManager(null, $data);
		$manager->agregarPagoRequerimiento();
		Session::flash('success', 'Se agregó el pago de requerimientos con éxito.');
		return Redirect::route('requerimientos_pendientes');
	}
}