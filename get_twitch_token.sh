#!/bin/bash

# Script para obtener un nuevo token de Twitch
# Uso: ./get_twitch_token.sh CLIENT_ID CLIENT_SECRET

CLIENT_ID="${1:-0s48g9x154t9geck5exvzg56cca5zc}"
CLIENT_SECRET="${2}"

if [ -z "$CLIENT_SECRET" ]; then
    echo "❌ Error: Necesitas proporcionar el CLIENT_SECRET"
    echo ""
    echo "Uso: ./get_twitch_token.sh CLIENT_ID CLIENT_SECRET"
    echo ""
    echo "1. Ve a https://dev.twitch.tv/console/apps"
    echo "2. Haz clic en tu aplicación"
    echo "3. Copia el Client Secret"
    echo "4. Ejecuta: ./get_twitch_token.sh $CLIENT_ID TU_CLIENT_SECRET"
    exit 1
fi

echo "🔄 Obteniendo nuevo token de Twitch..."
echo ""

RESPONSE=$(curl -s -X POST "https://id.twitch.tv/oauth2/token" \
    -d "client_id=$CLIENT_ID" \
    -d "client_secret=$CLIENT_SECRET" \
    -d "grant_type=client_credentials")

TOKEN=$(echo "$RESPONSE" | grep -o '"access_token":"[^"]*"' | cut -d'"' -f4)

if [ -n "$TOKEN" ]; then
    echo "✅ Token obtenido exitosamente!"
    echo ""
    echo "Nuevo token:"
    echo "$TOKEN"
    echo ""
    echo "Actualiza tu .env con:"
    echo "TWITCH_ACCESS_TOKEN=$TOKEN"
    echo ""
    
    # Validar el token
    VALIDATION=$(curl -s -H "Authorization: Bearer $TOKEN" https://id.twitch.tv/oauth2/validate)
    echo "Validación:"
    echo "$VALIDATION" | jq '.' 2>/dev/null || echo "$VALIDATION"
else
    echo "❌ Error al obtener el token"
    echo "$RESPONSE" | jq '.' 2>/dev/null || echo "$RESPONSE"
fi
