@echo off
REM ============================================
REM  Restore Database — TokoKita
REM  Usage: restore-database.bat path\to\file.sql
REM ============================================

set MYSQL_BIN=C:\xampp\mysql\bin
set DB_USER=root
set DB_PASS=
set DB_NAME=ecommerce

if "%~1"=="" (
    echo Usage: restore-database.bat C:\backup\tokokita\tokokita_XXXX.sql
    exit /b 1
)

set SQL_FILE=%~1

if not exist "%SQL_FILE%" (
    echo [ERROR] File tidak ditemukan: %SQL_FILE%
    exit /b 1
)

echo [PERINGATAN] Data database "%DB_NAME%" akan ditimpa oleh backup ini.
set /p CONFIRM="Lanjut? (y/N): "
if /I not "%CONFIRM%"=="y" (
    echo Dibatalkan.
    exit /b 0
)

echo [TokoKita] Restore dari %SQL_FILE% ...

if "%DB_PASS%"=="" (
    "%MYSQL_BIN%\mysql.exe" -u %DB_USER% %DB_NAME% < "%SQL_FILE%"
) else (
    "%MYSQL_BIN%\mysql.exe" -u %DB_USER% -p%DB_PASS% %DB_NAME% < "%SQL_FILE%"
)

if %ERRORLEVEL% EQU 0 (
    echo [OK] Restore berhasil.
) else (
    echo [ERROR] Restore gagal.
)
