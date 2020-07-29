<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 豆瓣书单
 *
 * @package custom
 */
?>
<?php $this->need('components/header.php'); ?>
<div <article id="post-<?php $this->cid() ?>" class="post entry box" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
	<?php if ($this->is('page')) { ?>
		<div class="entry-content" itemprop="articleBody">
			<?php
			$userID = "ijacko";
			if (isset($this->fields->user) && ($this->fields->user != "")) $userID = $this->fields->user;
			$url = "https://api.douban.com/v2/book/user/$userID/collections?count=100"; //最多取100条数据
			$res = json_decode(file_get_contents($url), true); //读取api得到json
			$res = $res['collections'];
			foreach ($res as $v) {
				//已经读过的书
				if ($v['status'] == "read") {
					$book_name = $v['book']['title'];
					$book_img = $v['book']['images']['medium'];
					$book_url = $v['book']['alt'];
					$readlist[] = array("name" => $book_name, "img" => $book_img, "url" => $book_url);
				} elseif ($v['status'] == "reading") {
					//正在读的书
					$book_name = $v['book']['title'];
					$book_img = $v['book']['images']['medium'];
					$book_url = $v['book']['alt'];
					$readinglist[] = array("name" => $book_name, "img" => $book_img, "url" => $book_url);
				}
			}
			?>
			<div class="booklist">
				<div class="section">
					<h4><?php _e('正在读的书'); ?></h4>
					<ul class="clearfix">
						<?php foreach ($readinglist as $v) { ?>
							<li>
								<a href="<?php echo $v['url']; ?>" target="_blank">
									<div class="photo"><img src="<?php echo $v['img']; ?>" width="98" height="151" /></div>
									<div class="rsp">
										<div class="text">
											<h3><?php echo $v['name']; ?></h3>
										</div>
									</div>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
				<div class="section">
					<h4><?php _e('已读的书'); ?></h4>
					<ul class="clearfix">
						<?php foreach ($readlist as $v) { ?>
							<li>
								<a href="<?php echo $v['url']; ?>" target="_blank">
									<div class="photo"><img src="<?php echo $v['img']; ?>" width="98" height="151" /></div>
									<div class="rsp">
										<div class="text">
											<h3><?php echo $v['name']; ?></h3>
										</div>
									</div>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="entry-footer">
			<?php _e('源码 ：<a href="http://muguang.me/guff/douban-booklist-page.html">《为WordPress创建一个「豆瓣书单」页面》</a>'); ?>
		</div>
	<?php } else { ?>
		<header class="entry-header">
			<h2 class="entry-title" itemprop="name"><a rel="bookmark" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
			<div class="entry-meta">
				<span class="cats" itemprop="keywords"><?php $this->category(','); ?></span>
				<span class="slash"> / </span>
				<time class="entry-date published" datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('F j, Y'); ?></time>
				<span class="slash"> / </span>
				<a href="<?php $this->permalink() ?>#comments" class="comments-link" itemprop="discussionUrl"><span itemprop="commentCount"><?php $this->commentsNum('我要', '1 条', '%d 条'); ?></span>评论</a>
				<span class="slash"> / </span>
				<span class="author" itemprop="author" itemscope itemtype="http://schema.org/Person"><a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></span>
			</div>
		</header>
		<div class="entry-summary" itemprop="description">
			<?php $this->excerpt(150, '...'); ?>
		</div>
	<?php } ?>
	</article>
	<style>
		.booklist .section h4 {
			margin: 10px 0px;
			padding: 3px 0px 3px 15px;
			font-size: 1.6em;
		}

		.booklist .section ul {
			list-style: none;
		}

		.booklist .section ul li {
			display: inline-block;
			overflow: hidden;
			width: 98px;
			height: 151px;
			position: relative;
			margin-left: 15px;
			*display: inline;
			*zoom: 1;
		}

		.booklist .section ul li .rsp {
			position: absolute;
			top: 0px;
			left: 0px;
			right: 0px;
			bottom: 0px;
			transition: all 0.2s ease 0s;
			background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;
			.background: #000;
			.filter: alpha(opacity=0);
			cursor: pointer;
		}

		.booklist .section ul li a:hover .rsp {
			background: rgba(0, 0, 0, .6) none repeat scroll 0% 0%;
			.background: #000;
			.filter: alpha(opacity=60);
		}

		.booklist .section ul li .text {
			text-align: center;
			padding: 5px;
			position: relative;
			top: 30%;
			margin-top: -15px;
			left: -100%;
			transition: all 0.2s ease 0s;
			cursor: pointer;
		}

		.booklist .section ul li:hover .text {
			left: 0
		}
	</style>
	<?php $this->need('components/comments.php'); ?>
</div>
<?php $this->need('components/footer.php'); ?>