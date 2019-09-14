<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Credito</title>
    <style>
      body {
            font-family: Arial;
            }

            .coupon {
            border: 1px dotted #bbb;
            width: 65%;
            border-radius: 1px;
            margin: 0 auto;
            max-width: 600px;
            }

            .container {
            padding: 2px 16px;
            background-color: #f1f1f1;
            }

            .promo {
            background: #ccc;
            padding: 3px;
            }

            .expire {
            color: red;
            }
            p{
                line-height: 150%  ;
            }
    </style>
    <body>
            @foreach ($cuotas as $c)
                    <div class="coupon">
                   
                   
                    <div class="container" style="background-color:white">
                            <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                COMPROBANTE DE ABONO</p>
                      
                    <p>NRO CUOTA: {{$c->numerocuota}}  &nbsp; &nbsp; &nbsp; NRO PRESTAMO : {{$c->numeroprestamo}}
                    <br> {{$c->fechacancelacion}}
                     <br>DNI SOCIO  : {{$c->dni}}
                    <br>{{$c->nombre}} {{$c->apellidopaterno}} {{$c->apellidomaterno}}
                    <br>Obs: {{$c->descripcion}}
                    <br>N° CRED: {{$c->numeroprestamo}}
                    <br>PROD.CRED:CREDITO CONGARANTIA LIQUIDA/PLAZO</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="promo">S.Anterior</span> &nbsp;&nbsp;&nbsp;
                            <span class="promo">Pago</span>&nbsp;&nbsp;&nbsp;
                            <span class="promo">S.Actual</span> 
                          <br>PRINCIPAL &nbsp;&nbsp;&nbsp; {{$c->saldopendiente + $c->monto}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$c->monto-(($c->montodesembolsado*($c->tasa/100))/$c->numerocuotas)}}&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;{{($c->saldopendiente)}}
                          <br>INTERES :  {{($c->montodesembolsado*($c->tasa/100))/$c->numerocuotas}}
                          <br> ----------------------
                          <br>La suma de :  {{$c->monto}}
  
                      </p>
                      <p>
                          Cuota N°: {{$c->numerocuota}} <br>
                          
                      </p>
                    
                    </div>
                  
                  </div>
                  
                  <br><br><br><br><br>
                  <div class="coupon">
                   
                   
                    <div class="container" style="background-color:white">
                            <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                COMPROBANTE DE ABONO</p>
                      
                    <p>NRO CUOTA: {{$c->numerocuota}}  &nbsp; &nbsp; &nbsp; NRO PRESTAMO : {{$c->numeroprestamo}}
                    <br> {{$c->fechacancelacion}}
                     <br>DNI SOCIO  : {{$c->dni}}
                    <br>{{$c->nombre}} {{$c->apellidopaterno}} {{$c->apellidomaterno}}
                    <br>Obs: {{$c->descripcion}}
                    <br>N° CRED: {{$c->numeroprestamo}}
                    <br>PROD.CRED:CREDITO CONGARANTIA LIQUIDA/PLAZO</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="promo">S.Anterior</span> &nbsp;&nbsp;&nbsp;
                            <span class="promo">Pago</span>&nbsp;&nbsp;&nbsp;
                            <span class="promo">S.Actual</span> 
                          <br>PRINCIPAL &nbsp;&nbsp;&nbsp; {{$c->saldopendiente + $c->monto}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$c->monto-(($c->montodesembolsado*($c->tasa/100))/$c->numerocuotas)}}&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;{{($c->saldopendiente)}}
                          <br>INTERES :  {{($c->montodesembolsado*($c->tasa/100))/$c->numerocuotas}}
                          <br> ----------------------
                          <br>La suma de :  {{$c->monto}}
  
                      </p>
                      <p>
                          Cuota N°: {{$c->numerocuota}} <br>
                          
                      </p>
                    
                    </div>
                  
                  </div>
            @endforeach
    </body>
</html>