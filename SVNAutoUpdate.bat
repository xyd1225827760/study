@echo off 
@echo ================================= 
@echo Author-Sun at 2011.7.18 
@echo ��ʱ��SVN���Զ�������Ŀ���ݪ���������Ŀ����web������û��
hudson��ʱ�� 
@echo ʱ��������"����ƻ�"ʱ��ȷ�� 
@echo 1.svn_home=��װtortoise��Ŀ¼���谲װTortoiseSVN�ͻ��� 
@echo 2.svn_work=������Ŀ�ļ���Ŀ¼ 
@echo WIN7��WINVista��WIN2008���û����ù���Ա������� 
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
@echo �������Ĺ���Ŀ¼�Ƿ���ȷ 
echo & pause GOTO :END 
 
:END 
exit 

:gengxin1 
"%svn_home%"\TortoiseProc.exe/command:update /path:"%svn_work1%" /notempfile /closeonend:1 
goto :Update2 
 
:gengxin2 
"%svn_home%"\TortoiseProc.exe/command:update /path:"%svn_work2%" /notempfile /closeonend:1 
 
@echo ��������˳� 
