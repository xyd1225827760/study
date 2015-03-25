@echo off 
@echo ================================= 
@echo Author-Sun at 2011.7.18 
@echo 定时在SVN上自动更新项目内容可用于项目放在web服务器没有
hudson的时候 
@echo 时间由您的"任务计划"时间确定 
@echo 1.svn_home=安装tortoise的目录需安装TortoiseSVN客户端 
@echo 2.svn_work=更新项目文件的目录 
@echo WIN7或WINVista或WIN2008的用户请用管理员身份运行 
@echo ================================= 
set svn_home=D:\Program Files\TortoiseSVN\bin 
set svn_work1=D:\web\CandorPHP\app_xw 
set svn_work2=D:\web\CandorPHP\app_xw
goto :Update1 
 
:Update1 
if exist %svn_work1% GOTO :gengxin1 else goto :MK 
 
:Update2 
if exist %svn_work2% GOTO :gengxin2 else goto :MK 
 
:MK 
@echo 请检查您的工作目录是否正确 
echo & pause GOTO :END 
 
:END 
exit 

:gengxin1 
"%svn_home%"\TortoiseProc.exe/command:update /path:"%svn_work1%" /notempfile /closeonend:1 
goto :Update2 
 
:gengxin2 
"%svn_home%"\TortoiseProc.exe/command:update /path:"%svn_work2%" /notempfile /closeonend:1 
 
@echo 更新完成退出 
