# 欢迎使用 Cihook

------

>相信真正深层用过CodeIgniter框架钩子功能的开发者们都会发现一个问题，就是在控制器中调用钩子的时候，是不能够传递参数的，这极大地影响了业务正常逻辑，阻碍了应用程序与扩展程序之间的信息传递。
基于这个需求，趁着有空，花了半天的时间写了一个简单Cihook类来实现解决这个问题。

### 使用方法

##### （1）安装
如果你的CI框架是使用composer来安装的，使用这种方式来安装这个钩子类将会极为方便。
1.在项目根目录下的composer.json文件中增加如下依赖；
```json
"require": {
	"junec/cihook": "dev-master"
}
```
2.执行`composer update`即可完成安装

##### （2）使用
1.在application/config/config.php中找到如下开关：
```php
// CI钩子开关配置，启用
$config['enable_hooks'] = TRUE;
```
2.找到application/config/hook.php，如果没有则可手动创建
3.注册你的钩子
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$hook['pre_system'] = function()
{
	// 方式一，直接在此注册你的钩子
	\Junec\Cihook\Hook::add('pay', 'before');
	\Junec\Cihook\Hook::add('pay', 'after');
};
```
4.在application目录下创建文件夹plugin，再创建文件application/plugin/Pay/Pay.php
```php
<?php
class Pay {
	
	public function before()
	{
		echo '我要开始支付啦<br>';
	}
	
	public function after($order_id)
	{
	    echo '将此订单信息通过短息发给用户';
	}
}
```
5.埋下钩子
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pay extends CI_Controller {

    // 订单支付
	public function submit($order_id)
	{
	    // 调用钩子
	    \Junec\Cihook\Hook::listen('Pay', 'before');
	    // 支付
	    $bool = $this->order_model->pay($order_id);
	    if ($bool) {
	        // 调用钩子
	        \Junec\Cihook\Hook::listen('pay', 'after', $order_id);
	    }
    }
}
```
输入结果：
> 我要开始支付啦
将此订单信息通过短息发给用户

### Done
