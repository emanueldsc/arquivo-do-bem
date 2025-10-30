#!/bin/sh
set -e

# Garante o diretório do tema
cd /var/www/html/wp-content/themes/arquivo-do-bem || {
  echo "ERRO: diretório do tema não existe"; exit 1;
}

echo "PWD: $(pwd)"
ls -la

# Confere package.json
if [ ! -f package.json ]; then
  echo "ERRO: package.json não encontrado em $(pwd)"
  echo "Crie o tema em ./wp-content/themes/arquivo-do-bem no host."
  exit 1
fi

# Instala dependências
if [ -f package-lock.json ]; then
  npm ci
else
  npm install
fi

# Sobe o Vite Dev Server
exec npm run dev
