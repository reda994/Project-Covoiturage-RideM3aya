<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Détails du Trajet - {{ $trip->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 30px; color: #333; background: #f9fafb; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 3px solid #16a34a; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #16a34a; margin: 0; font-size: 32px; font-weight: bold; }
        .header h2 { color: #666; margin: 10px 0 0 0; font-size: 18px; }
        .route { background: linear-gradient(135deg, #16a34a 0%, #10b981 100%); color: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; text-align: center; }
        .route h3 { margin: 0; font-size: 24px; }
        .route p { margin: 10px 0 0 0; opacity: 0.9; }
        .details { margin-bottom: 20px; }
        .details table { width: 100%; border-collapse: collapse; }
        .details th, .details td { text-align: left; padding: 12px 15px; border-bottom: 1px solid #e5e7eb; }
        .details th { color: #16a34a; font-weight: bold; width: 35%; background: #f9fafb; }
        .details tr:hover { background: #f9fafb; }
        .driver-info { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; padding: 20px; background: #f0fdf4; border-radius: 10px; border-left: 4px solid #16a34a; }
        .driver-avatar { width: 60px; height: 60px; border-radius: 50%; border: 3px solid #16a34a; }
        .description { background: #f9fafb; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #16a34a; }
        .description h4 { color: #16a34a; margin: 0 0 10px 0; }
        .footer { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #777; }
        .price-tag { background: #16a34a; color: white; padding: 10px 20px; border-radius: 20px; display: inline-block; font-weight: bold; font-size: 18px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚗 RideM3aya</h1>
            <h2>Récapitulatif du Trajet #{{ $trip->id }}</h2>
        </div>

        <div class="route">
            <h3>{{ $trip->departure_city }} → {{ $trip->arrival_city }}</h3>
            <p>📅 {{ $trip->departure_datetime->format('l d F Y à H:i') }}</p>
        </div>

        <div class="driver-info">
            <div style="flex: 1;">
                <h4 style="margin: 0 0 5px 0; color: #16a34a;">Conducteur</h4>
                <p style="margin: 0; font-size: 18px; font-weight: bold;">{{ $trip->driver->name }}</p>
                <p style="margin: 5px 0 0 0; color: #666;">Membre depuis {{ $trip->driver->created_at->format('Y') }}</p>
            </div>
            <div style="text-align: right;">
                <div class="price-tag">{{ number_format($trip->price_per_seat, 2) }} DH</div>
                <p style="margin: 5px 0 0 0; color: #666;">par place</p>
            </div>
        </div>

        <div class="details">
            <table>
                <tr>
                    <th>🚗 Véhicule</th>
                    <td>{{ $trip->vehicle->brand }} {{ $trip->vehicle->model }} ({{ $trip->vehicle->color }})</td>
                </tr>
                <tr>
                    <th>💺 Places disponibles</th>
                    <td>{{ $trip->available_seats }}</td>
                </tr>
                <tr>
                    <th>📞 Téléphone</th>
                    <td>{{ $trip->driver->phone ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <th>📍 Statut</th>
                    <td>
                        @if($trip->status === 'active')
                            <span style="color: #16a34a; font-weight: bold;">✓ Actif</span>
                        @elseif($trip->status === 'full')
                            <span style="color: #dc2626; font-weight: bold;">✗ Complet</span>
                        @elseif($trip->status === 'cancelled')
                            <span style="color: #dc2626; font-weight: bold;">✗ Annulé</span>
                        @else
                            <span style="color: #666;">{{ $trip->status }}</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        @if($trip->description)
        <div class="description">
            <h4>💬 Mot du conducteur</h4>
            <p style="margin: 0; font-style: italic;">"{{ $trip->description }}"</p>
        </div>
        @endif

        <div class="footer">
            <p>Document généré le {{ now()->format('d/m/Y à H:i') }} via RideM3aya</p>
            <p style="margin-top: 5px;">🇲🇦 L'application de covoiturage au Maroc</p>
            <p style="margin-top: 10px; font-size: 10px; color: #999;">RideM3aya - Voyagez ensemble à travers le Maroc</p>
        </div>
    </div>
</body>
</html>
