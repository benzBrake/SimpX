<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('__THEME_DIR__', dirname(__FILE__));
function themeConfig($form)
{
	$leftSidebar = new Typecho_Widget_Helper_Form_Element_Textarea('leftSidebar', NULL, 'category' . PHP_EOL . 'tagscloud', _t('左边栏模块'), _t('一行一个，可选：<code>' . implode("|", listWidgets()) . '</code>'));
	$form->addInput($leftSidebar);
	$rightSidebar = new Typecho_Widget_Helper_Form_Element_Textarea('rightSidebar', NULL, 'recent-posts' . PHP_EOL . 'recent-comments', _t('右边栏模块'), _t('一行一个，可选：<code>' . implode("|", listWidgets()) . '</code>'));
	$form->addInput($rightSidebar);
	$defaultThumb = new Typecho_Widget_Helper_Form_Element_Text('xmp_default_thumb', NULL, _t('https://ooo.0o0.ooo/2017/02/13/58a165406ce28.png'), _t('默认缩略图'), _t('没有设置题图用此框中的图片链接代替，留空为不显示图片(默认图片：https://ooo.0o0.ooo/2017/02/13/58a165406ce28.png)'));
	$form->addInput($defaultThumb);
	$edit = new Typecho_Widget_Helper_Form_Element_Text('xmp_gravatar_prefix', null, _t('https://gravatar.loli.net/avatar/'), _t('Gravatar 服务器'), _t('防止Gravatar无法访问，图，留空使用默认参数，参考：<code>https://gravatar.loli.net/avatar/</code>'));
	$form->addInput($edit);
	$edit = new Typecho_Widget_Helper_Form_Element_Text('xmp_qr_api', null, _t("https://my.tv.sohu.com/user/a/wvideo/getQRCode.do?text={{content}}"), _t('二维码api'), _t('<code>{{content}}</code>代表二维码内容'));
	$form->addInput($edit);
}


/*
function themeFields($layout) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点LOGO地址'), _t('在这里填入一个图片URL地址, 以在网站标题前加上一个LOGO'));
    $layout->addItem($logoUrl);
}
*/
function themeInit($archive)
{
	if ($archive->is('single')) {
		if ($archive->request->isPost()) {
			if ($archive->request->is('themeAction=comment')) {
				ajaxComment($archive); // AJAX评论
			}
		}
	}
	// 二维码
	if ($archive->is('index') && $archive->request->is('qrcode')) {
		require_once 'QRCode.php';
		$size = floor(110 / 37 * 100) / 100 + 0.01;
		$text = $archive->request->get('text');
		if (empty($text)) {
			$text = Helper::options()->siteUrl;
		}
		QRcode::png($text, false, 'L', 10, 2);
	}
}
function is_pjax()
{
	return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];
}
function is_mobile()
{
	$request = Typecho_Request::getInstance();
	return $request->isMobile();
}
function simpx_get_template_by_part($part)
{
	$DIR_SEP = DIRECTORY_SEPARATOR;
	$part = ($part == "") ? "" : "-" . $part;
	$template = file_exists(dirname(__FILE__) . $DIR_SEP . 'content' . $part . ".php") ? "content" . $part . ".php" : "content.php";
	return $template;
}
function simpx_get_widget($part)
{
	$DIR_SEP = DIRECTORY_SEPARATOR;
	$part = ($part == "") ? "-none" : "-" . $part;
	$template = file_exists(dirname(__FILE__) . $DIR_SEP . 'widgets' . $DIR_SEP . 'widget' . $part . ".php") ? "widgets" . $DIR_SEP . "widget" . $part . ".php" : "widgets" . $DIR_SEP . "widget-none.php";
	return $template;
}
function getDayAgo($date)
{
	$d = new Typecho_Date(Typecho_Date::gmtTime());
	$now = $d->format('Y-m-d H:i:s');
	$post = $date->format('Y-m-d H:i:s');
	$t = strtotime($now) - strtotime($post);
	if ($t < 60) return $t . '秒前';
	if ($t < 3600) return floor($t / 60) .  '分钟前';
	if ($t < 86400) return floor($t / 3670) . '小时前';
	if ($t < 604800) return floor($t / 86400) . '天前';
	if ($t < 2419200) return floor($t / 604800) .  '周前';
	if ($t < 31536000) return floor($t / 2592000) . '月前';
	return floor($t / 31536000) . '年前';
}

function thumbs($widget, $quantity = 3, $return = false, $parse = false, $template = '<img src="%s" />')
{
	$thumbs = array();
	$quantity = intval($quantity);
	$fields = unserialize($widget->fields);
	$options = Helper::options();
	// 首先使用自定义字段 thumb
	if (array_key_exists('thumb', $fields) && (!empty($fields['thumb'])) && $quantity > 0) {
		if (!in_array($fields['thumb'], $thumbs)) {
			$thumbs[] = $fields['thumb'];
			$quantity -= 1;
		}
	}
	// 然后是正文匹配
	preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $widget->content, $matches);
	foreach ($matches[1] as $match) {
		if ($quantity <= 0) {
			break;
		}
		// 2020.03.29 修正输出插件图标的BUG
		if (strpos($match, __TYPECHO_PLUGIN_DIR__ . "/") !== false) {
			continue;
		}
		if (!in_array($match, $thumbs)) {
			$thumbs[] = $match;
			$quantity -= 1;
		}
	}

	// 接着是附件匹配
	$attachments = null;
	Typecho_Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $widget->cid)->to($attachments);
	while ($attachments->next()) {
		if ($quantity <= 0) {
			break;
		}
		if (isset($attachments->isImage) && $attachments->isImage == 1) {
			if (!in_array($attachments->url, $thumbs)) {
				$thumbs[] = $attachments->url;
				$quantity -= 1;
			}
		}
	}

	// 最后是随机
	while ($quantity-- > 0) {
		$thumbs[] = Helper::options()->themeUrl . '/assets/img/thumbs/' . mt_rand(0, 9) . '.jpg';
	}

	// 转换
	if ($parse && (!empty($template))) {
		if ($options->xmp_cdn_domain !== null && $options->xmp_cdn_domain !== "") {
			for ($i = 0; $i < count($thumbs); $i++) {
				// CDN
				if (strpos($thumbs[$i], rtrim($options->siteUrl, '/')) !== false) {
					$thumbs[$i] = sprintf($template, str_replace(rtrim($options->siteUrl, '/'), rtrim($options->xmp_cdn_domain, '/'), $thumbs[$i]));
				}
			}
		} else {
			for ($i = 0; $i < count($thumbs); $i++) {
				$thumbs[$i] = sprintf($template, $thumbs[$i]);
			}
		}
	}

	// 输出或返回
	if ($return) {
		if (count($thumbs) == 1) {
			return $thumbs[0];
		}
		return $thumbs;
	} else {
		foreach ($thumbs as $thumb) {
			echo $thumb;
		}
	}
}
function randomPosts()
{
	$defaults = array(
		'number' => 5,
		'before' => '<ul class="list">',
		'after' => '</ul>',
		'xformat' => '<li><a href="{permalink}" title="{title}">{title}</a></li>'
	);
	$db = Typecho_Db::get();
	$sql = $db->select()->from('table.contents')
		->where('status = ?', 'publish')
		->where('type = ?', 'post')
		->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
		->limit($defaults['number'])
		->order('RAND()');
	$result = $db->fetchAll($sql);
	echo $defaults['before'];
	foreach ($result as $val) {
		$val = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($val);
		echo str_replace(array('{permalink}', '{title}'), array($val['permalink'], $val['title']), $defaults['xformat']);
	}
	echo $defaults['after'];
}
/**
 * ajaxComment
 * 实现Ajax评论的方法(实现feedback中的comment功能)
 * @param Widget_Archive $archive
 * @return void
 */
function ajaxComment($archive)
{
	$options = Helper::options();
	$user = Typecho_Widget::widget('Widget_User');
	$db = Typecho_Db::get();
	// Security 验证不通过时会直接跳转，所以需要自己进行判断
	// 需要开启反垃圾保护，此时将不验证来源
	if ($archive->request->get('_') != Helper::security()->getToken($archive->request->getReferer())) {
		$archive->response->throwJson(array('status' => 0, 'msg' => _t('非法请求:' . $archive->request->getReferer())));
	}
	/** 评论关闭 */
	if (!$archive->allow('comment')) {
		$archive->response->throwJson(array('status' => 0, 'msg' => _t('评论已关闭')));
	}
	/** 检查ip评论间隔 */
	if (
		!$user->pass('editor', true) && $archive->authorId != $user->uid &&
		$options->commentsPostIntervalEnable
	) {
		$latestComment = $db->fetchRow($db->select('created')->from('table.comments')
			->where('cid = ?', $archive->cid)
			->where('ip = ?', $archive->request->getIp())
			->order('created', Typecho_Db::SORT_DESC)
			->limit(1));

		if ($latestComment && ($options->gmtTime - $latestComment['created'] > 0 &&
			$options->gmtTime - $latestComment['created'] < $options->commentsPostInterval)) {
			$archive->response->throwJson(array('status' => 0, 'msg' => _t('对不起, 您的发言过于频繁, 请稍侯再次发布')));
		}
	}

	$comment = array(
		'cid' => $archive->cid,
		'created' => $options->gmtTime,
		'agent' => $archive->request->getAgent(),
		'ip' => $archive->request->getIp(),
		'ownerId' => $archive->author->uid,
		'type' => 'comment',
		'status' => !$archive->allow('edit') && $options->commentsRequireModeration ? 'waiting' : 'approved',
	);

	/** 判断父节点 */
	if ($parentId = $archive->request->filter('int')->get('parent')) {
		if ($options->commentsThreaded && ($parent = $db->fetchRow($db->select('coid', 'cid')->from('table.comments')
			->where('coid = ?', $parentId))) && $archive->cid == $parent['cid']) {
			$comment['parent'] = $parentId;
		} else {
			$archive->response->throwJson(array('status' => 0, 'msg' => _t('父级评论不存在')));
		}
	}
	$feedback = Typecho_Widget::widget('Widget_Feedback');
	//检验格式
	$validator = new Typecho_Validate();
	$validator->addRule('author', 'required', _t('必须填写用户名'));
	$validator->addRule('author', 'xssCheck', _t('请不要在用户名中使用特殊字符'));
	// $validator->addRule('author', array($feedback, 'requireUserLogin'), _t('您所使用的用户名已经被注册,请登录后再次提交'));
	$validator->addRule('author', 'maxLength', _t('用户名最多包含200个字符'), 200);

	if ($options->commentsRequireMail && !$user->hasLogin()) {
		$validator->addRule('mail', 'required', _t('必须填写电子邮箱地址'));
	}

	$validator->addRule('mail', 'email', _t('邮箱地址不合法'));
	$validator->addRule('mail', 'maxLength', _t('电子邮箱最多包含200个字符'), 200);

	if ($options->commentsRequireUrl && !$user->hasLogin()) {
		$validator->addRule('url', 'required', _t('必须填写个人主页'));
	}
	$validator->addRule('url', 'url', _t('个人主页地址格式错误'));
	$validator->addRule('url', 'maxLength', _t('个人主页地址最多包含200个字符'), 200);

	$validator->addRule('text', 'required', _t('必须填写评论内容'));

	$comment['text'] = $archive->request->text;

	/** 对一般匿名访问者,将用户数据保存一个月 */
	if (!$user->hasLogin()) {
		/** Anti-XSS */
		$comment['author'] = $archive->request->filter('trim')->author;
		$comment['mail'] = $archive->request->filter('trim')->mail;
		$comment['url'] = $archive->request->filter('trim')->url;

		/** 修正用户提交的url */
		if (!empty($comment['url'])) {
			$urlParams = parse_url($comment['url']);
			if (!isset($urlParams['scheme'])) {
				$comment['url'] = 'http://' . $comment['url'];
			}
		}

		$expire = $options->gmtTime + $options->timezone + 30 * 24 * 3600;
		Typecho_Cookie::set('__typecho_remember_author', $comment['author'], $expire);
		Typecho_Cookie::set('__typecho_remember_mail', $comment['mail'], $expire);
		Typecho_Cookie::set('__typecho_remember_url', $comment['url'], $expire);
	} else {
		$comment['author'] = $user->screenName;
		$comment['mail'] = $user->mail;
		$comment['url'] = $user->url;

		/** 记录登录用户的id */
		$comment['authorId'] = $user->uid;
	}

	/** 评论者之前须有评论通过了审核 */
	if (!$options->commentsRequireModeration && $options->commentsWhitelist) {
		if ($feedback->size($feedback->select()->where('author = ? AND mail = ? AND status = ?', $comment['author'], $comment['mail'], 'approved'))) {
			$comment['status'] = 'approved';
		} else {
			$comment['status'] = 'waiting';
		}
	}

	if ($error = $validator->run($comment)) {
		$archive->response->throwJson(array('status' => 0, 'msg' => implode(';', $error)));
	}
	//评论过程的插件接口，一般用于过滤垃圾评论的插件
	try {
		$comment = $feedback->pluginHandle()->comment($comment, $feedback->_content);
	} catch (Typecho_Exception $e) {
		Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
		$archive->response->throwJson(array('status' => 0, 'msg' => _t($e->getMessage())));
		throw $e;
	}
	/** 添加评论 */
	$commentId = $feedback->insert($comment);
	if (!$commentId) {
		$archive->response->throwJson(array('status' => 0, 'msg' => _t('评论失败')));
	}
	Typecho_Cookie::delete('__typecho_remember_text');
	$db->fetchRow($feedback->select()->where('coid = ?', $commentId)
		->limit(1), array($feedback, 'push'));
	//评论完成后的接口，一般用于评论提醒插件
	$feedback->pluginHandle()->finishComment($feedback);

	// 返回评论数据
	$data = array(
		'cid' => $feedback->cid,
		'coid' => $feedback->coid,
		'parent' => $feedback->parent,
		'mail' => $feedback->mail,
		'url' => $feedback->url,
		'ip' => $feedback->ip,
		'agent' => $feedback->agent,
		'author' => $feedback->author,
		'authorId' => $feedback->authorId,
		'permalink' => $feedback->permalink,
		'created' => $feedback->created,
		'datetime' => $feedback->date->format(Helper::options()->commentDateFormat),
		'datetimeC' => $feedback->date->format('c'),
		'status' => $feedback->status,
	);
	// 评论内容
	ob_start();
	$feedback->content();
	$data['content'] = ob_get_clean();
	$data['avatar'] = gravatarUrl($data['mail'], 'size=50');
	$archive->response->throwJson(array('status' => 1, 'comment' => $data));
}
function ajaxCommentJs($widget, $commentErrMsg = "评论出错", $ajaxErrMsg = "评论失败，请重试", $buttonText = "提交评论", $buttonDisabled = "提交中...")
{
	$gravatarPrefix = Helper::options()->xmp_gravatar_prefix;
	if (empty($gravatarPrefix)) {
		$gravatarPrefix = __TYPECHO_GRAVATAR_PREFIX__;
	}
	if (empty($gravatarPrefix)) {
		$gravatarPrefix = 'https://secure.gravatar.com/avatar/';
	}
?>
	<script type="text/javascript">
		window.TypechoComment = {
			reply: function(theId) {
				$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
				$body.animate({
					scrollTop: $('#' + theId).offset().top - 280
				}, 1000);

				// 父子评论区分
				if ($(".comment-form").find("#comment-parent").length > 0) {
					$('#comment-parent').val(theId.split("-").pop());
				} else {
					$(".comment-form").prepend('<input name="parent" id="comment-parent" value="' + theId.split("-").pop() + '" type="hidden">')
				}

				// 使用 detach 可以保留事件
				var respond = $(".comment-respond").hide().detach();

				// 增加新的评论框
				$('#' + theId + ' > .comment-body').after(respond);
				$(".comment-respond").fadeIn();

				// 回复/取消 交替显示
				$('.cancel-comment-reply').hide();
				$('.comment-reply').show();
				$('.cr-' + theId).fadeOut();
				$('.ccr-' + theId).fadeIn();

				// 评论框聚焦
				$("#comment").focus();
				return false;
			},
			cancelReply: function(theId) {
				$("#comment").val();
				// 默认无父评论
				if ($(".comment-respond").find("#comment-parent")) {
					$('#comment-parent').remove();
				}

				$("#comments").prepend($(".comment-respond").detach());

				if (!typeof theId == undefined) {
					$('.ccr-' + theId).fadeOut();
					$('.cr-' + theId).fadeIn();
				} else {
					$('.cancel-comment-reply').hide();
					$('.comment-reply').show();
				}
				return false;
			},
		}

		function bindReplyButtonEvent(el) {
			$('.comment-reply a', el).click(function() {
				TypechoComment.reply('comment-' + $(this).data('tid'));
				return false;
			});
			$('.cancel-comment-reply a', el).click(function() {
				TypechoComment.cancelReply('comment-' + $(this).data('tid'));
				return false;
			});
		}

		function bindCommentSubmit() {
			if (typeof $("#comment-form") == undefined) return;
			$(".comment-body-right", $("#comments")).each(function(el) {
				bindReplyButtonEvent(el);
			});
			$("#mail").blur(function() {
				if (
					/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/.test(
						$("#mail").val()
					)
				)
					$("#comment-form .avatar").attr(
						"src",
						"<?php echo $gravatarPrefix; ?>" +
						hex_md5($("#mail").val()) +
						"?d=mm&s=50"
					);
			});
			$("#comment-form").submit(function() {
				var form = $(this),
					params = form.serialize();
				// 添加functions.php中定义的判断参数
				params += "&themeAction=comment";
				// 解析新评论并附加到评论列表

				maxLevels = "<?php echo intval(Helper::options()->commentsMaxNestingLevels); ?>"

				replyButton = '<span class="comment-reply cr-comment-{coid}"><a href="#" rel="nofollow" data-tid="{coid}"><?php _e("回复"); ?></a></span><span class="cancel-comment-reply ccr-comment-{coid}" style="display:none"><a href="#" rel="nofollow"><?php _e("取消"); ?></a></span>';

				var appendComment = function(comment) {
					// 默认评论 Class
					commentClass = "comment-parent";
					// 评论列表
					var el = $("#comments > .comments-list");
					if (0 != comment.parent) {
						// 子评论 Class 不一样
						commentClass = "comment-child";
						// 子评论则重新定位评论列表
						var el = $("#comment-" + comment.parent);
						if (el.parents('.comments-list').length >= (maxLevels - 1)) {
							replyButton = "";
						}
						// 父评论不存在子评论时
						if (el.find(".comment-children").length < 1) {
							$('<div class="comment-children"><ul class="comments-list"></ul></div>').appendTo(el);
						} else if (el.find(".comment-children > .comments-list").length < 1) {
							$('<ul class="comments-list"></ul>').appendTo(el.find(".comment-children"));
						}
						el = $("#comment-" + comment.parent).find(".comment-children").find(".comments-list");
					}
					if (0 == el.length) {
						$('<ul class="comments-list"></ul>').appendTo($("#comments"));
						el = $("#comments > .comments-list");
					}
					// 评论html模板，根据具体主题定制
					var html = '<li id="comment-{coid}" class="' + commentClass + '"><div class="comment-body"><div class="comment-body-left"><img class="avatar" src="{avatar}" alt="{author}"/></div><div class="comment-body-right"><div class="comment-meta"><cite class="fn"><a href="{url}" rel="external nofollow">{author}</a></cite><time class="date" datetime="{datetimeC}" itemprop="datePublished">{datetime}</time></div><div class="comment-content">{content}</div>' + replyButton + '</div></div></li>';
					$.each(comment,
						function(k, v) {
							regExp = new RegExp("{" + k + "}", "g");
							html = html.replace(regExp, v);
						});
					$(el).append($(html));
					$(".comment-body-right", $("#comments")).each(function(el) {
						bindReplyButtonEvent(el);
					});
				};
				// ajax提交评论
				$.ajax({
					url: $(this).attr('action'),
					type: "POST",
					data: params,
					dataType: "json",
					beforeSend: function() {
						form.find(".submit").addClass("loading").html('<?php _e($buttonDisabled); ?>').attr("disabled", "disabled");
					},
					complete: function() {
						$("#comment-form").find(".submit").removeClass("loading").html('<?php _e($buttonText); ?>').removeAttr("disabled");
					},
					success: function(result) {
						if (1 == result.status) {
							// 新评论附加到评论列表
							appendComment(result.comment);
							form.find("textarea").val("");
							if (result.comment.parent > 0) {
								TypechoComment.cancelReply('comment-' + result.comment.parent);
							} else {
								TypechoComment.cancelReply();
							}
							$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
							$body.animate({
								scrollTop: $('#comment-' + result.comment.coid).offset().top - 200
							}, 1000);
							return false;
						} else {
							// 提醒错误消息
							alert(undefined === result.msg ? "<?php _e($commentErrMsg); ?>" : result.msg);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						console.log(thrownError);
						console.log(xhr.responseText);
						alert("<?php _e($ajaxErrMsg); ?>");
					},
				});
				return false;
			});
		}
		(function() {
			bindCommentSubmit();
		})();
	</script>
<?php }
function gravatarUrl($mail = null, $gravatarOptions = null)
{
	$gravatarOptions = Typecho_Config::factory($gravatarOptions);
	$gravatarOptions->setDefault(array(
		'prefix' => (Helper::options()->xmp_gravatar_prefix),
		'size' => '32',
		'rating' => Helper::options()->commentsAvatarRating,
		'default' => 'mm',
		'defaultGravatar' => Typecho_Widget::widget('Widget_Options')->themeUrl . '/img/default-avatar.png',
	), false);
	if ($mail === null) {
		return $gravatarOptions->defaultGravatar;
	}
	preg_match_all('/((\d)*)@qq.com/', $mail, $matches);
	$url = '';
	if (empty($matches['1']['0'])) {
		if ($gravatarOptions->prefix !== "") {
			$url = $gravatarOptions->prefix;
		} else if (defined('__TYPECHO_GRAVATAR_PREFIX__')) {
			$url = __TYPECHO_GRAVATAR_PREFIX__;
		} else {
			$url = 'https://secure.gravatar.com/avatar/';
		}
		if (!empty($mail)) {
			$url .= md5(strtolower(trim($mail)));
		} else {
			return $gravatarOptions->defaultGravatar;
		}
		$url .= '?s=' . $gravatarOptions->size;
		$url .= '&amp;r=' . $gravatarOptions->rating;
		$url .= '&amp;d=' . $gravatarOptions->default;
		return $url;
	} else {
		return 'https://q2.qlogo.cn/headimg_dl?dst_uin=' . $matches['1']['0'] . '&spec=100';
	}
}
/**
 * 输出头像
 *
 * @param String $mail 邮箱地址
 * @param mixed $gravatarOptions 配置
 * @return void
 * @date 2020-04-10
 */
function gravatar($mail = null, $gravatarOptions = null)
{
	$gravatarOptions = Typecho_Config::factory($gravatarOptions);
	$gravatarOptions->setDefault(array(
		'prefix' => Helper::options()->xmp_gravatar_prefix,
		'itemClass' => 'avatar',
		'size' => '32',
		'rating' => Helper::options()->commentsAvatarRating,
		'default' => 'mm',
		'defaultThumb' => Helper::options()->themeUrl . '/img/default-avatar.png',
	), false);
	echo '<img ' . ($gravatarOptions->itemClass === '' ? '' : ' class="' . $gravatarOptions->itemClass . '" ') . 'src="' . gravatarUrl($mail, $gravatarOptions) . '"/>';
}
/**
 * 列出所有插件
 *
 * @return array
 * @date 2020-04-11
 */
function listWidgets()
{
	$widgetPath = __THEME_DIR__ . DIRECTORY_SEPARATOR . 'widgets';
	$files = array_filter(glob($widgetPath . DIRECTORY_SEPARATOR . '*'), function ($path) {
		return preg_match("/\.(php)$/i", $path);
	});
	$info = array();
	foreach ($files as $file) {
		$item = Typecho_Plugin::parseInfo($file);
		$_arr = explode(DIRECTORY_SEPARATOR, $file);
		$item['filename'] = array_pop($_arr);
		if (empty($item['description'])) {
			continue;
		}
		$info[] = $item['description'] . '(' . str_replace("widget-", "", explode(".", $item['filename'])[0]) . ')';
	}
	return $info;
}
function qrcode(string $text = null, $forceLocal = false)
{
	$text = empty($text) ? Helper::options()->siteUrl : $text;
	$baseUrl = $forceLocal || empty(Helper::options()->xmp_qr_api) ? Helper::options()->index . '?qrcode&text={content}' : Helper::options()->xmp_qr_api;
	return str_replace("{content}", $text, $baseUrl);
}
