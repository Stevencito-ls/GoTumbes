<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Reserva - {{ $reservation['destination_title'] }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f766e;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #0f172a;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #64748b;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .content {
            margin-bottom: 30px;
        }
        .title {
            color: #0f172a;
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
        }
        .reservation-id {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 30px;
        }
        .info-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-box h3 {
            margin-top: 0;
            color: #0f172a;
            font-size: 16px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 8px 0;
            color: #475569;
        }
        table td strong {
            color: #0f172a;
        }
        .total-row {
            border-top: 2px solid #0f766e;
            font-size: 18px;
        }
        .total-row td {
            padding-top: 15px;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
        }
        .status-badge {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>GoTumbes</h1>
        <p>Tu agencia de viajes de confianza en el norte del Perú</p>
    </div>

    <div class="content">
        <div class="title">COMPROBANTE DE RESERVA</div>
        <div class="reservation-id">Código de Reserva: <strong>{{ strtoupper($reservation['id']) }}</strong></div>
        
        <div class="info-box">
            <h3>Detalles del Cliente</h3>
            <table>
                <tr>
                    <td><strong>Nombre:</strong></td>
                    <td>{{ $reservation['customer_name'] }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $reservation['customer_email'] }}</td>
                </tr>
                <tr>
                    <td><strong>Fecha de Operación:</strong></td>
                    <td>{{ date('d/m/Y H:i:s', $reservation['created_at']) }}</td>
                </tr>
            </table>
        </div>

        <div class="info-box">
            <h3>Detalles del Tour y Pago</h3>
            <table>
                <tr>
                    <td><strong>Destino:</strong></td>
                    <td>{{ $reservation['destination_title'] }}</td>
                </tr>
                <tr>
                    <td><strong>Fecha del Tour:</strong></td>
                    <td>{{ date('d/m/Y', strtotime($reservation['reservation_date'] ?? time())) }}</td>
                </tr>
                <tr>
                    <td><strong>Medio de Pago:</strong></td>
                    <td><span style="text-transform: uppercase;">{{ $reservation['payment_method'] ?? 'Tarjeta' }}</span></td>
                </tr>
                @if(isset($reservation['operation_number']))
                <tr>
                    <td><strong>N° de Operación:</strong></td>
                    <td>{{ $reservation['operation_number'] }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Tickets / Personas:</strong></td>
                    <td>{{ $reservation['tickets'] }}</td>
                </tr>
                @if(isset($destination['price']))
                <tr>
                    <td><strong>Precio Unitario:</strong></td>
                    <td>S/ {{ number_format($destination['price'], 2) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td><strong>Total Pagado:</strong></td>
                    <td><strong style="color: #0f766e;">S/ {{ number_format($reservation['total_paid'], 2) }}</strong></td>
                </tr>
                <tr>
                    <td><strong>Estado:</strong></td>
                    <td>
                        @if(($reservation['status'] ?? 'paid') === 'pending')
                            <span class="status-badge" style="background-color: #f59e0b;">PENDIENTE DE VALIDACIÓN</span>
                        @else
                            <span class="status-badge">PAGADO</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        @if(isset($destination['included']) && !empty($destination['included']))
        <div class="info-box" style="page-break-inside: avoid;">
            <h3>¿Qué incluye su paquete?</h3>
            <div style="white-space: pre-line; color: #475569; font-size: 14px;">
                {{ $destination['included'] }}
            </div>
        </div>
        @endif
        
        <p style="text-align: center; color: #64748b; font-size: 13px; margin-top: 30px;">
            Presente este comprobante el día de su tour. ¡Gracias por confiar en GoTumbes!
        </p>
    </div>

    <div class="footer">
        <p>GoTumbes - Plaza Principal S/N, Tumbes, Perú | +51 987 654 321 | reservas@gotumbes.pe</p>
    </div>

</body>
</html>
