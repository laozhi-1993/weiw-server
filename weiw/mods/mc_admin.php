<?php return function ()
{
	mc::admin() or die('<center><font size="7">没有权限禁止访问</font></center>');
};