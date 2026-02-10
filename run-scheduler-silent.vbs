Set WshShell = CreateObject("WScript.Shell")
Set FSO = CreateObject("Scripting.FileSystemObject")
CurrentDirectory = FSO.GetParentFolderName(WScript.ScriptFullName)
WshShell.Run "cmd /c cd /d """ & CurrentDirectory & """ && php artisan schedule:run >> storage\logs\scheduler.log 2>&1", 0, False
Set WshShell = Nothing
