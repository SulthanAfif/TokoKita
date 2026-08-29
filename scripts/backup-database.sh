#!/usr/bin/env bash
# Backup Database Harian — TokoKita (Linux/macOS)
# Jadwalkan dengan cron: 0 23 * * * /path/to/backup-database.sh

set -euo pipefail

DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-}"
DB_NAME="${DB_NAME:-ecommerce}"
BACKUP_DIR="${BACKUP_DIR:-$HOME/backup/tokokita}"
KEEP_DAYS="${KEEP_DAYS:-14}"

mkdir -p "$BACKUP_DIR"
TIMESTAMP=$(date +%Y-%m-%d_%H%M)
FILENAME="tokokita_${TIMESTAMP}.sql"
TARGET="$BACKUP_DIR/$FILENAME"

echo "[TokoKita] Backup database '$DB_NAME' -> $TARGET"

if [[ -n "$DB_PASS" ]]; then
  mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$TARGET"
else
  mysqldump -u "$DB_USER" "$DB_NAME" > "$TARGET"
fi

# Hapus backup lebih lama dari KEEP_DAYS
find "$BACKUP_DIR" -name 'tokokita_*.sql' -type f -mtime +"$KEEP_DAYS" -delete 2>/dev/null || true

echo "[OK] Backup berhasil: $TARGET ($(wc -c < "$TARGET") bytes)"
