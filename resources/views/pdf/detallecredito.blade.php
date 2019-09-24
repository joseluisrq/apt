<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <title>Reporte de Credito</title>
    <style>
           body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .book{
        width: 40%;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 1cm;
        border: 5px red solid;
        height: 257mm;
        outline: 2cm #FFEAEA solid;
    }
    
    @page {
        size: A4;
        margin: 0;
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
                ID KIVA:  {{$c->idkiva}}<br><br>
            </p>
             <p>
                  Yo,  {{$c->nombre}}  {{$c->apellidopaterno}} {{$c->apellidomaterno}} con DNI  N° 
                   {{$c->dni}};entiendo y estoy de acuerdo realizar los pagos en acuerdo con los
                    términos y condiciones 
            </p>
            <p> Firma de Acreditado ______________________________ Fecha {{date('d/m/Y')}}</p>
            <p> [Representante de APT del Norte] </p>
            <p>Firma ______________________________ Fecha {{date('d/m/Y')}} </p>
            

            <h4> I.Términos de Préstamo</h4>
            <table>
                <tr>
                    <td>Monto de Prestamo y moneda</td>
                    <td>$ {{$c->montodesembolsado}}</td>
                    <td>Fecha de desembolso</td>
                    <td>{{$c->fechadesembolso}}</td>
                </tr>
                <tr>
                    <td>Tasa de Interes (Especificar si es Fija/Sobre Saldo/No aplicable)</td>
                    <td>Fija {{$c->tasa}} % anual</td>
                    <td>Fecha de vencimiento</td>
                    <td></td>
                </tr>

                <tr>  
                    <td>Frecuencia de Pagos (Semana, Mensual,etc)</td>
                    <td>{{$c->periodo}}</td>
                    <td>Cargos y otroscostos</td>
                    <td></td>                         
                    
                </tr>
            </table>


            <h4>II.Plan de Pagos </h4>
                <table>
                    <tr>
                        <th>Fecha de Pago</th>
                        <th>Saldo Pendiente</th>
                        <th>Principal</th>
                        <th>Interes</th>
                        <th>Otros Costos(Comisiones,seguros,G.B.)</th>
                        <th>Pago total</th>
                    </tr>
                    @foreach ($cuotas as $cuot)
                   
                    <tr>
                        <td>{{$cuot->fechapago}}</td>
                        <td>{{$cuot->saldopendiente}}</td>
                        <td>{{$cuot->monto}}</td>
                        <td>{{$c->tasa}}</td>
                        <td>{{$cuot->otroscostos}}</td>
                        <td>{{$cuot->monto}}</td>
                    </tr>
                    @endforeach

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