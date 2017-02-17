		<nav id="navbar" class="wp" role="navigation" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
			<ul id="site-menu" class="nav-menu floatleft">
				<li <?php if($this->is('index')): ?>class="current"<?php endif; ?>><a href="<?php $this->options->siteUrl(); ?>"><i class="fa fa-registered  fa-3x fa-fw" aria-hidden="true"></i><?php _e('首页'); ?></a></li>
				<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
				<?php while($pages->next()): ?>
				<?php if (array_key_exists('navbar',unserialize($pages->___fields()))): ?>
				<li id="menu-item-<?php $pages->cid() ?>" class="menu-item<?php if($this->is('page', $pages->slug)): ?> current<?php endif; ?>">
					<a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>">
						<?php if(isset($pages->fields->icon) && ($pages->fields->icon != "")) { ?>
							<i class="fa <?php $pages->fields->icon(); ?> fa-3x  fa-fw" aria-hidden="true"></i>
						<?php } else { ?>
							<i class="fa fa-file-o  fa-3x fa-fw" aria-hidden="true"></i>
						<?php } 
							$pages->title(); ?>
					</a>
				</li>
				<?php endif; ?>
				<?php endwhile; ?>
			</ul>
			<ul id="right-menu" class="nav-menu floatright">
				<li>
					<form id="search-form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
						<label for="s" class="icon search"></label>
						<input id="s" type="text" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
						<button type="submit" class="submit search-submit"></button>
					</form>
			    </li>
			    <li class="icon mobile-menu"></li>
			</ul>
		 </nav>