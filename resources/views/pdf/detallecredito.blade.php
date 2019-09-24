<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <title>Reporte de Credito</title>
    <style>
     body {
            margin: 20px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
    table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
    }
    </style>
    <body>
        @foreach ($credito as $c)
       
        <div class="book">
         <div class="page">
            <div align='center'><h4> Contrato de Credito/Pagaré</h4></div>
            <p>
                ID PRESTAMO :  {{$c->numeroprestamo}}<br><br>
                ID CLIENTE:  {{$c->dni}}<br><br>
                ID KIVA:  {{$c->idkiva}}<br><
            </p>
             <p>
                  Yo,  {{$c->nombre}}  {{$c->apellidopaterno}} {{$c->apellidomaterno}} con DNI  N° 
                   {{$c->dni}}; entiendo y estoy de acuerdo realizar los pagos en acuerdo con los
                    términos y condiciones 
            </p>
            <p> Firma de Acreditado ______________________________  &nbsp;&nbsp;&nbsp; Fecha {{date('d/m/Y')}}</p>
            <p> [Representante de APT del Norte] </p>
            <p>Firma ______________________________  &nbsp;&nbsp;&nbsp; Fecha {{date('d/m/Y')}} </p>
            

            <h4> I.Términos de Préstamo</h4>
            <table  style="width:100%">
                <tr>
                    <td style="width:35%">Monto de Prestamo y moneda</td>
                    <td style="width:15%">$ {{$c->montodesembolsado}}</td>
                    <td style="width:35%">Fecha de desembolso</td>
                    <td style="width:15%">{{$c->fechadesembolso}}</td>
                </tr>
                <tr>
                    <td style="width:35%">Tasa de Interes (Especificar si es Fija/Sobre Saldo/No aplicable)</td>
                    <td style="width:15%">Fija {{$c->tasa}} % anual</td>
                    <td style="width:35%">Fecha de vencimiento</td>
                    <td style="width:15%">  <?php
                        echo $meses=($c->numerocuotas)*($c->periodo);

                     ?>
                </td>
                </tr>

                <tr>  
                    <td style="width:35%">Frecuencia de Pagos (Semana, Mensual,etc)</td>
                    <td style="width:15%">
                    <?php
                    if($c->periodo==1)echo "Mensual";
                    elseif($c->periodo==2)echo "Bimestral";
                    elseif($c->periodo==3)echo "Trimestral";
                    elseif($c->periodo==6)echo "Semestral";
                    elseif($c->periodo==12)echo "Anual";
                    ?>
                   
                
                </td>
                    <td style="width:35%">Cargos y otroscostos</td>
                    <td style="width:15%">
                  
                    </td>                         
                    
                </tr>
            </table>


            <h4>II.Plan de Pagos </h4>
                <table style="width:100%">
                    <tr>
                       <td style="width:17%">Fecha de Pago</th>
                       <td style="width:17%">Saldo Pendiente</th>
                       <td style="width:17%">Principal</th>
                       <td style="width:17%">Interes</th>
                       <td style="width:17%">Otros Costos</th>
                       <td style="width:15%">Pago total</th>
                    </tr>
                    <?php 
                        
                        $sumaotros=0; ?>
                    @foreach ($cuotas as $cuot)
                   
                    <tr>
                        <td style="width:17%">{{$cuot->fechapago}}</td>
                        <td style="width:17%">{{round($cuot->saldopendiente,2)}}</td>
                        <td style="width:17%">{{
                            round(
                            $cuot->monto
                            ,2)
                        }}</td>
                        <td style="width:17%">{{
                            round(
                            ($c->montodesembolsado*($c->tasa / 100)) / $c->numerocuotas
                            ,2)
                        
                        }}</td>
                        <td style="width:17%">{{$cuot->otroscostos}}</td>
                        <td style="width:15%">{{round(($cuot->monto)+($cuot->otroscostos)+( ($c->montodesembolsado*($c->tasa / 100)) / $c->numerocuotas),2)}}</td>
                        <?php 
                        
                        $sumaotros=($cuot->otroscostos)+$sumaotros?>
                    </tr>
                    @endforeach
                    <td style="width:17%">TOTAL</td>
                        <td style="width:17%">0</td>
                        <td style="width:17%">{{$c->montodesembolsado}}</td>
                        <td style="width:17%">{{
                            round(
                            $c->montodesembolsado*($c->tasa / 100)
                            ,2)
                        
                        }}</td>
                        <td style="width:17%"><?php echo $sumaotros?></td>
                        <td style="width:15%">{{
                            round(
                            $c->montodesembolsado+$sumaotros+  ($c->montodesembolsado*($c->tasa / 100))
                            ,2)
                        
                        }}</td>
                    </tr>

                </table>
            <h4>
            I.Plan de pagos
            </h4>
            <p>
                Yo,  {{$c->nombre}}  {{$c->apellidopaterno}} {{$c->apellidomaterno}} con DNI  N°  {{$c->dni}};entiendo y estoy de acuerdo realizar los pagos en acuerdo con los términos y condiciones 
            </p>
        </div>
        <div class="page">
        
        </div>
    </div>
    @endforeach
</html>