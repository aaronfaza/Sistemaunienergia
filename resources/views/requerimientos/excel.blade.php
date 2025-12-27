<table border="0" width="100%">
    <tr>
        <td colspan="8" align="center" bgcolor="#1f4e79">
            <strong style="color:#ffffff;">
                REPORTE DE REQUERIMIENTOS – BACKUP
            </strong>
        </td>
    </tr>
</table>

<br>

<table border="1" width="100%">
    <tr bgcolor="#e7eef6">
        <td colspan="4"><strong>Empresa:</strong> EMPRESA DE RECURSOS ENERGÉTICOS UNIENERGIA ABC S.A.C</td>
        <td colspan="4"><strong>RUC:</strong> 20161738272</td>
    </tr>
    <tr>
        <td colspan="4"><strong>Generado por:</strong> {{ Auth::user()->name ?? 'Usuario desconocido' }}</td>
        <td colspan="4"><strong>Cargo:</strong> {{ Auth::user()->cargo ?? 'Sin cargo definido' }}</td>
    </tr>
    <tr>
        <td colspan="8"><strong>Fecha y hora:</strong> {{ now()->format('d/m/Y H:i:s') }}</td>
    </tr>
</table>

<br>

<table border="1" width="100%">
    <thead>
        <tr bgcolor="#1f4e79">
            <th><font color="white">Código</font></th>
            <th><font color="white">Fecha</font></th>
            <th><font color="white">Área Solicitante</font></th>
            <th><font color="white">Nombre Solicitante</font></th>
            <th><font color="white">Cargo Solicitante</font></th>
            <th><font color="white">Servicio</font></th>
            <th><font color="white">Destino</font></th>
            <th><font color="white">Sustento</font></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requerimientos as $r)
        <tr>
            <td>{{ $r->codigo }}</td>
            <td>{{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
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
