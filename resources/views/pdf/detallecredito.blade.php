<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Credito</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #datcliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }

        #datcliente thead{
        padding: 20px;
        background: #30b817;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }

        #datanalista{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #datanalista thead{
        padding: 20px;
        background: #30b817;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #detallecuotass{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #detallecuotass thead{
        padding: 20px;
        background: #30b817;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #gracias{
        text-align: center; 
        }
    </style>
    <body>
        @foreach ($credito as $c)
            
        
        <header>
            <div id="logo">
                <img src="img/logo.png" alt="incanatoIT" id="imagen">
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b>Apt San Marcos</b><br>Direccion San Marcos<br>Telefono: 964923450 <br>Email: aprsanmarcos@gmail.com
                </p>
            </div>
            <div id="fact">
                <p>N° de Prestamo<br>
               {{$c->numeroprestamo}}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="datcliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th><p id="cliente">Sr(a). 
                            {{$c->nombre}}  {{$c->apellidopaterno}} {{$c->apellidomaterno}}<br>
                            Documento: {{$c->dni}}<br>
                            Dirección:{{$c->direccion}}<br>
                            Teléfono: {{$c->telefono}}<br>
                            Email: {{$c->email}}</p></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>
            <div>
                <table id="datanalista">
                    <thead>
                        <tr id="fv">
                            <th>ANALISTA</th>
                            <th>FECHA DE DESEMBOLSO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$c->usuario}}</td>
                            <td>{{$c->fechadesembolso}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @endforeach
        <br>
        <section>
            <div>
              
                    
                
                <table id="detallecuotass">
                    <thead>
                        <tr id="fa">
                            <th>N°</th>
                            <th>Monto</th>
                            <th>Saldo pendiente</th>
                            <th>Fecha de Pago</th>
                            <th>Otros Pagos</th>
                            <th>Descripcion</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($cuotas as $cuot)
                        <tr>
                            <td>{{$cuot->numerocuota}}</td>
                            <td>{{$cuot->monto}}</td>
                            <td>{{$cuot->saldopendiente}}</td>
                            
                            <td>{{$cuot->fechapago}}</td>
                            <td>{{$cuot->otroscostos}}</td>
                            <td>{{$cuot->descripcion}}</td>
                            
                            
                        </tr>
                        @endforeach
                    </tbody>
                  
                </table>
             
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>Gracias, Apt San Marcos siempre a tu servicio</b></p>
            </div>
        </footer>
    </body>
</html>