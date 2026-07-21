<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Código de recuperación</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: Arial, sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding:32px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.08);">
          <tr>
            <td style="background-color:#003366; padding:20px 32px;">
              <span style="color:#ffffff; font-size:18px; font-weight:bold;">UniEnergía ABC</span>
            </td>
          </tr>
          <tr>
            <td style="padding:32px;">
              <p style="font-size:15px; color:#333; margin:0 0 16px;">Hola {{ $usuario->name }},</p>
              <p style="font-size:15px; color:#333; margin:0 0 16px;">
                Recibimos una solicitud para restablecer la contraseña de tu cuenta ({{ $usuario->email }}).
                Usa el siguiente código para continuar:
              </p>
              <div style="text-align:center; margin:28px 0;">
                <span style="display:inline-block; font-size:32px; font-weight:bold; letter-spacing:8px; color:#003366; background:#f1f5f9; padding:14px 24px; border-radius:8px;">
                  {{ $codigo }}
                </span>
              </div>
              <p style="font-size:14px; color:#555; margin:0 0 8px;">
                Este código vence en {{ $minutosValidez }} minutos.
              </p>
              <p style="font-size:14px; color:#555; margin:0;">
                Si tú no solicitaste este cambio, puedes ignorar este correo — tu contraseña actual seguirá funcionando.
              </p>
            </td>
          </tr>
          <tr>
            <td style="background-color:#f8f9fa; padding:16px 32px; text-align:center;">
              <span style="font-size:12px; color:#94a3b8;">UniEnergía ABC &copy; {{ date('Y') }}</span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
