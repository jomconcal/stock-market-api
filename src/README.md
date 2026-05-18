## 🔐 Generar claves JWT

Para que la autenticación JWT funcione, es necesario generar el par de claves pública/privada.  
Ejecuta el siguiente comando dentro del contenedor:

```bash
php bin/console lexik:jwt:generate-keypair
```

o fuera:
```bash
docker exec -it stock_market_api_php php bin/console lexik:jwt:generate-keypai
```

Add XDEBUG_SESSION_START: PHPSTORM
to debug and endpoint
