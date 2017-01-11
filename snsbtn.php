<div class="share-btn">
    <ul>
    <li><a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( get_the_title() . ' - ' . get_bloginfo('name') ); ?>&amp;url=<?php echo urlencode( get_permalink() ); ?>&amp;via=magonote"
    onclick="window.open(this.href, 'SNS', 'width=500, height=300, menubar=no, toolbar=no, scrollbars=yes'); return false;" class="share-tw">
        <i class="fa fa-twitter fa-fw"></i><span>Twitter</span>
    </a></li>
    <li><a href="http://www.facebook.com/share.php?u=<?php echo urlencode( get_permalink() ); ?>"
    onclick="window.open(this.href, 'SNS', 'width=500, height=500, menubar=no, toolbar=no, scrollbars=yes'); return false;" class="share-fb">
        <i class="fa fa-facebook fa-fw"></i><span>Facebook</span>
    </a></li>
    <li><a href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink() ); ?>"
    onclick="window.open(this.href, 'SNS', 'width=500, height=500, menubar=no, toolbar=no, scrollbars=yes'); return false;" class="share-gp">
        <i class="fa fa-google-plus fa-fw"></i><span>Google+</span>
    </a></li>
	<li><a href="http://line.me/R/msg/text/?<?php echo urlencode( get_the_title() ); ?>%0D%0A<?php echo urlencode( get_permalink() ); ?>"
    onclick="window.open(this.href, 'SNS', 'width=500, height=500, menubar=no, toolbar=no, scrollbars=yes'); return false;" class="share-line">
        <img src="<?php echo get_stylesheet_directory_uri().'/164x40 (82x20).png'; ?>" width="80px" height="20px" alt="" />
    </a></li>
    </ul>
</div><!-- end share -->
