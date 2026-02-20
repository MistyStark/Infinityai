@echo off
setlocal
cd /d %~dp0
echo --- WordPress Article Retrieval (Ann's Task) ---
.\php-bin\php.exe fetch_articles.php
echo.
echo Duty complete! Press any key to exit.
pause > nul
