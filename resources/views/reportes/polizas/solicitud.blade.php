<html>
<head>
  
  <link href="http://localhost/sistemas/segurosmyc/assets/css/tables.css" rel="stylesheet" type="text/css" />
  <link href="http://localhost/sistemas/segurosmyc/assets/css/core.css" rel="stylesheet" type="text/css" />
  <link href="http://localhost/sistemas/segurosmyc/assets/css/components.css" rel="stylesheet" type="text/css" />
  <link href="http://localhost/sistemas/segurosmyc/assets/css/custom_reports.css" rel="stylesheet" type="text/css" />
  <style>
    @page { margin: 150px 50px; }
    #header { position: fixed; left: 0px; top: -150px; right: 0px; height: 100px; text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 50px; text-align: center; display: block}
    #footer .page:after { content: counter(page); }
    .logo { float: left; height: 100px;  }
    .title { height: 100px; vertical-align: middle;  line-height: 100px; }
    body { background: white; }
  </style>

<body>
  <div id="header">
    <img src="http://localhost/sistemas/segurosmyc/assets/imagenes/logos/laceiba.png" class="logo">
    <h1 class="title">Solicitud de Póliza</h1>
  </div>
  <div id="footer">
    <p class="page">Page </p>
  </div>
  <div id="content">
    <h1>Datos Generales de la Póliza</h1>
    Solicitud: {{$poliza->numero_solicitud}} <br/>
    Asegurado: {{$poliza->cliente->nombre}}
    
    <h2 style="page-break-before: always;">Coberturas Generales</h2>
    <table class="table table-responsive">
      <thead>
        <tr>
          <th class="text-center">COBERTURA</th>
          <th class="text-center">SUMA ASEGURADA</th>
          <th class="text-center">DEDUCIBLE</th>
        </tr>
      </thead>
      <tbody>
        @foreach($coberturasGenerales as $cg)
        <tr>
          <td>{{$cg->cobertura->nombre}}</td>
          <td class="text-right">Q. {{ number_format($cg->suma_asegurada,2)}}</td>
          <td class="text-right">Q. {{ number_format($cg->deducible,2)}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <h2 style="page-break-before: always;">Vehículos</h2>
    <table class="table table-responsive">
      <thead>
        <tr>
          <th class="text-center">PLACA</th>
          <th class="text-center">TIPO</th>
          <th class="text-center">MARCA</th>
          <th class="text-center">MODELO</th>
          <th class="text-center">LINEA</th>
          <th class="text-center">COLOR</th>
        </tr>
      </thead>
      <tbody>
        @foreach($vehiculos as $v)
        <tr>
          <td>{{$v->vehiculo->placa}}</td>
          <td>{{$v->vehiculo->tipoVehiculo->nombre}}</td>
          <td>{{$v->vehiculo->marca->nombre}}</td>
          <td>{{$v->vehiculo->modelo}}</td>
          <td>{{$v->vehiculo->linea}}</td>
          <td>{{$v->vehiculo->color}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @if(count($coberturasParticulares) > 0)
    <h2 style="page-break-before: always;">Coberturas Particulares</h2>
    <table class="table table-responsive">
      <thead>
        <tr>
          <th class="text-center">PLACA</th>
          <th class="text-center">COBERTURA</th>
          <th class="text-center">SUMA ASEGURADA</th>
          <th class="text-center">DEDUCIBLE</th>
        </tr>
      </thead>
      <tbody>
        @foreach($coberturasParticulares as $cp)
        <tr>
          <td>{{$cp->vehiculo->placa}}</td>
          <td>{{$cp->cobertura->nombre}}</td>
          <td class="text-right">Q. {{ number_format($cp->suma_asegurada,2) }}</td>
          <td class="text-right">Q. {{ number_format($cp->deducible,2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif

  </div>
</body>
</html>