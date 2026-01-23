#!/bin/bash
# Script para obtener token de Kick

CLIENT_ID="01KFK1K07VQ82MW4KRDW8MY0R3"
CLIENT_SECRET="7ff603de6989b3d1f1b3c4cd7e5cd65849eee2da52b05cacaddef7b6a355957e"

echo "🔄 Intentando obtener token de Kick..."
echo ""

# Kick probablemente use OAuth2 similar a Twitch
# Primero intentamos client_credentials grant
RESPONSE=$(curl -s -X POST "https://kick.com/oauth2/token" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -d "client_id=$CLIENT_ID" \
    -d "client_secret=$CLIENT_SECRET" \
    -d "grant_type=client_credentials")

echo "Respuesta:"
echo "$RESPONSE" | jq '.' 2>/dev/null || echo "$RESPONSE"
