		<nav id="navbar" class="wp" role="navigation" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
			<ul id="site-menu" class="nav-menu">
				<li <?php if ($this->is('index')) : ?>class="current" <?php endif; ?>><a href="<?php $this->options->siteUrl(); ?>"><i class="fa fa-registered  fa-3x fa-fw" aria-hidden="true"></i><?php _e('首页'); ?></a></li>
				<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
				<?php while ($pages->next()) : ?>
					<li id="menu-item-<?php $pages->cid() ?>" class="menu-item<?php if ($this->is('page', $pages->slug)) : ?> current<?php endif; ?>">
						<a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>">
							<?php if (isset($pages->fields->icon) && (!empty($pages->fields->ico))) : ?><i class="fa <?php $pages->fields->icon(); ?> fa-3x  fa-fw" aria-hidden="true"></i><?php else : ?><i class="fa fa-file-o  fa-3x fa-fw"></i><?php endif; ?><?php $pages->title(); ?>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
			<ul id="right-menu" class="nav-menu">
				<li class="search-menu">
					<form id="search-form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
						<label for="s" class="sr-only"><?php _e('搜索'); ?></label>
						<input type="text" name="s" class="search-input" placeholder="<?php _e('输入关键字搜索'); ?>" />
						<button type="submit" class="submit search-submit"></button>
					</form>
				</li>
				<li class="icon mobile-menu"></li>
			</ul>
			<ul id="mobile-menu" class="bg-info hidden">
				<li <?php if ($this->is('index')) : ?>class="current" <?php endif; ?>><a href="<?php $this->options->siteUrl(); ?>"><i class="fa fa-registered  fa-3x fa-fw" aria-hidden="true"></i><?php _e('首页'); ?></a></li>
				<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
				<?php while ($pages->next()) : ?>
					<li id="menu-item-<?php $pages->cid() ?>" class="menu-item<?php if ($this->is('page', $pages->slug)) : ?> current<?php endif; ?>">
						<a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>">
							<?php if (isset($pages->fields->icon) && (!empty($pages->fields->ico))) : ?><i class="fa <?php $pages->fields->icon(); ?> fa-3x  fa-fw" aria-hidden="true"></i><?php else : ?><i class="fa fa-file-o  fa-3x fa-fw"></i><?php endif; ?><?php $pages->title(); ?>
						</a>
					</li>
				<?php endwhile; ?>
				<li class="search-menu">
					<form id="search-form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
						<label for="s" class="sr-only"><?php _e('搜索'); ?></label>
						<input type="text" name="s" class="search-input bg-white" placeholder="<?php _e('输入关键字搜索'); ?>" />
						<button type="submit" class="submit search-submit"></button>
					</form>
				</li>
			</ul>
		</nav>