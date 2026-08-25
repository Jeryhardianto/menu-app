#!/usr/bin/env bash
# Deploy ke vm-gpu: build aset Vite, rsync source, build image, migrate, cetak status.
# Alias SSH `vm-gpu` didefinisikan di dev-ops/home-server/config.
set -euo pipefail

HOST=${DEPLOY_HOST:-vm-gpu}
DIR=${DEPLOY_DIR:-/home/vm-gpu/menu-app}

# nginx melayani public/ hasil rsync, jadi manifest Vite harus dibangun di sini —
# image PHP sengaja tanpa Node.
npm run build

# Tanpa --delete-excluded: .env.prod di VM harus selamat dari --delete.
# vendor/ tidak dikirim — image membangunnya sendiri lewat composer install.
# public/storage tidak dikirim: di VM upload dilayani lewat alias nginx ke volume.
# --inplace WAJIB: docker/nginx.conf di-bind-mount sebagai berkas tunggal, dan
# rsync default mengganti berkas lewat rename. Rename = inode baru, sedangkan
# mount tetap menunjuk inode lama — container diam-diam memakai conf usang.
rsync -az --delete --inplace \
  --exclude '.git' \
  --exclude '.env*' \
  --exclude '.DS_Store' \
  --exclude 'vendor' \
  --exclude 'node_modules' \
  --exclude 'public/storage' \
  --exclude 'storage/logs/*.log' \
  --exclude 'storage/app/public/*' \
  ./ "$HOST:$DIR/"

C="docker compose --env-file .env.prod -f compose.prod.yaml"
ssh "$HOST" "cd $DIR && $C up -d --build"
# Perubahan nginx.conf tidak memicu recreate container — muat ulang eksplisit.
ssh "$HOST" "cd $DIR && $C exec -T web nginx -t && $C exec -T web nginx -s reload"
ssh "$HOST" "cd $DIR && $C exec -T app php artisan migrate --force"
# Seed hanya saat DB masih kosong, supaya deploy berikutnya tidak menumpuk data.
# Hitungannya dibaca dari stdout: `artisan tinker` selalu keluar dengan status 0,
# exit() di dalam --execute tidak diteruskan ke shell.
USERS=$(ssh "$HOST" "cd $DIR && $C exec -T app php artisan tinker --execute='echo \App\Models\User::count();'" | tr -dc '0-9')
if [ "${USERS:-0}" -gt 0 ]; then
  echo "seed dilewati: sudah ada $USERS user"
else
  ssh "$HOST" "cd $DIR && $C exec -T app php artisan db:seed --force"
fi
ssh "$HOST" "cd $DIR && $C ps"
