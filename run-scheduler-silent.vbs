Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "cmd /c cd /d ""C:\laragon\www\SSTM"" && php artisan schedule:run >> storage\logs\scheduler.log 2>&1", 0, False
Set WshShell = Nothing
