# ---------- STAGE 1: build do Vite ----------
FROM node:20 AS builder

# Caminho do tema
WORKDIR /app/theme

# Copia package.json do tema e instala deps (use npm ci se tiver package-lock.json)
COPY wp-content/themes/arquivo-do-bem/package*.json ./
RUN npm ci

# Copia o restante do tema e roda build
COPY wp-content/themes/arquivo-do-bem ./
RUN npm run build

# ---------- STAGE 2: imagem do WordPress ----------
FROM wordpress:6.6-php8.2-apache

# Ajustes de upload (opcional)
COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Copia todo o wp-content (plugins/temas) para dentro do container
COPY wp-content /var/www/html/wp-content

# Sobrescreve o dist do tema com o que foi buildado no Stage 1
COPY --from=builder /app/theme/dist /var/www/html/wp-content/themes/arquivo-do-bem/dist

# Permissões
RUN chown -R www-data:www-data /var/www/html/wp-content

EXPOSE 80
