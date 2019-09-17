<table>
    <thead>
    <tr>
        <th>ID CREDITO CUOTA</th>
        <th>ID CREDITO CREDITO</th>
        <th>NUMERO PRESTAMO</th>
        <th>MONTO DE DESEMBOLSADO</th>
        <th>MONTO TOTAL PAGADO</th>
        <th>MONTO QUE DEBE</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cuotas as $cuota)
        @foreach($creditos as $credito)
        <tr>
            <td>{{ $cuota->idcredito}}</td>
            <td>{{ $credito->id}}</td>
            <td>{{ $credito->numeroprestamo}}</td>
           
            <td>{{ $credito->montodesembolsado}}</td>
            <td>{{ $cuota->montosporcredito }}</td>
            <td>{{ $credito->montodesembolsado-$cuota->montosporcredito }}</td>
           
          
          
            
         
        </tr>
        @endforeach
    @endforeach

    
    </tbody>
</table>