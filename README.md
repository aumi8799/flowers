Internetinė platforma, leidžianti klientams lengvai užsisakyti personalizuotas puokštes, kurti unikalius atvirukus, užsakyti gėlių pristatymą su filmavimu ir gauti renginių dekoravimo paslaugas, pasitelkiant interaktyvias ir patogias funkcijas.

//.env failo turinis:

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:hGI70VxsMsjD8jBUvpWNmrwL1seagpRvZQwRx+niK2E=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=flowers
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=bloomandblissshoponline@gmail.com
MAIL_PASSWORD=mkqsbsrazzhnabun
MAIL_FROM_ADDRESS=bloomandblissshoponline@gmail.com
MAIL_FROM_NAME="Bloom & Bliss"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

PAYPAL_CLIENT_ID=AU2f66qXLZsD9DWOiNQbyWBsvymxXblzkb3RamFKvvPFRZZP79t1tFbaVeelZDhLL47hXFvihnElioor
PAYPAL_CLIENT_SECRET=EIsitfcYEhhQSg0YEc_Q56Q49mtBB_9bfcOG0enQk9LK9OkEbo97C6UfxKNzpqA9IEruTj4UfM8jCx9s
PAYPAL_MODE=sandbox