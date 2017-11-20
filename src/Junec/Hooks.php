<?php
namespace Junec\Hook;

class Hook {
	
	// 定义所有的插件句柄
	static private $hooks = array();
	
	static public function add($hookName, $funcName)
	{
		// 根据插件名字导入插件
		$hook_path = FCPATH . 'plugin/' . $hookName . '/' . $hookName . '.php';
		if (is_file($hook_path)) {
			include_once $hook_path;
			$hook = new $hookName;
			self::hooks[$hookName] = $hook;
		}
	}
	
	/**
	 * [listen 监听某个事件]
	 * @param	[string] $hookName [插件名称]
	 * @param	[string] $funcName [方法名称]
	 * @param	[array]  $params   [使用参数]
	 * @return	[void]
	 */
	static public function listen($hookName, $funcName, $params = null)
	{
		if (isset(self::$hooks[$hookName])) {
			self:;exec($hookName, $funcName, $params);
		} else {
			return false;
		}
	}
	
	/**
	 * [exec 执行某个插件]
	 * @param	[string] $hookName [插件名称]
	 * @param	[string] $funcName [方法名称]
	 * @param	[array]  $params   [使用参数]
	 * @return	[void]
	 */
	static public function exec($hookName, $funcName, $params = null)
	{
		$addon = new $hookName();
		return $addon->$funcName($params);
	}
}