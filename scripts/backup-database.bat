@echo off
REM ============================================
REM  Backup Database Harian — TokoKita
REM  Jalankan manual ATAU jadwalkan di Task Scheduler
REM ============================================

set MYSQL_BIN=C:\xampp\mysql\bin
set DB_USER=root
set DB_PASS=
set DB_NAME=ecommerce
set BACKUP_DIR=C:\backup\tokokita

REM Buat folder backup jika belum ada
if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

REM Nama file: tokokita_YYYY-MM-DD_HHMM.sql
set TIMESTAMP=%date:~-4,4%-%date:~-7,2%-%date:~-10,2%_%time:~0,2%%time:~3,2%
set TIMESTAMP=%TIMESTAMP: =0%
set FILENAME=tokokita_%TIMESTAMP%.sql

echo [TokoKita] Backup database "%DB_NAME%" ...
echo Tujuan: %BACKUP_DIR%\%FILENAME%

if "%DB_PASS%"=="" (
    "%MYSQL_BIN%\mysqldump.exe" -u %DB_USER% %DB_NAME% > "%BACKUP_DIR%\%FILENAME%"
) else (
    "%MYSQL_BIN%\mysqldump.exe" -u %DB_USER% -p%DB_PASS% %DB_NAME% > "%BACKUP_DIR%\%FILENAME%"
)

if %ERRORLEVEL% EQU 0 (
    echo [OK] Backup berhasil: %BACKUP_DIR%\%FILENAME%
) else (
    echo [ERROR] Backup gagal. Cek path MySQL dan nama database.
)

REM Hapus backup lebih dari 14 hari (opsional)
forfiles /p "%BACKUP_DIR%" /m tokokita_*.sql /d -14 /c "cmd /c del @path" 2>nul

echo Selesai.
