<table>
    <tr>
        <td colspan="5"><strong>Empresa:</strong> EMPRESA DE RECURSOS ENERGETICOS UNIENERGIA ABC S.A.C</td>
        <td colspan="5"><strong>RUC:</strong>20161738272</td>
    </tr>
    <tr>
        <td colspan="5">
            <strong>Generado por:</strong> { Auth::user()->name ?? 'Usuario desconocido' }} 
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <strong>Cargo:</strong>  {{ Auth::user()->cargo ?? 'Sin cargo definido' }}
        </td>
    </tr>
    <tr>
        <td colspan="5"><strong>Fecha y hora:</strong>  {{ now()->format('d/m/Y H:i:s') }}</td>
    </tr>
</table>

<br>

<table border="1">
    <thead>
        <tr>
            <th>Código</th>
            <th>Fecha</th>
            <th>Área Solicitante</th>
            <th>Nombre Solicitante</th>
            <th>Cargo Solicitante</th>
            <th>Servicio</th>
            <th>Destino</th>
            <th>Sustento</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requerimientos as $r)
        <tr>
            <td>{{ $r->codigo }}</td>
            <td>{{ $r->fecha }}</td>
            <td>{{ $r->area_solicitante }}</td>
            <td>{{ $r->nombre_solicitante }}</td>
            <td>{{ $r->cargo_solicitante }}</td>
            <td>{{ $r->servicio }}</td>
            <td>{{ $r->destino }}</td>
            <td>{{ $r->sustento }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

