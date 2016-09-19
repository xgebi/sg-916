<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sg-916
 */

 $emailSent = false;
 $errorName = false;
 $errorEmail = false;
 $errorMsg = false;
 $errorRobot = false;

 $botici = filter_input(INPUT_POST, "botici",FILTER_SANITIZE_STRING);
 $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
 $name = trim(filter_input(INPUT_POST, "sender-name", FILTER_SANITIZE_STRING));
 $msg = trim(filter_input(INPUT_POST, "msg", FILTER_SANITIZE_STRING));
 $sent = trim(filter_input(INPUT_GET, "sent", FILTER_SANITIZE_NUMBER_INT));

 if (!$botici && ($sent == 1)) {
 	$first = false;
 	if ($email && $name && $msg) {
 		$subject = 'From '.$name;
 		$body = "Name: $name \n\nEmail: $email \n\nMessage $msg";
 		$headers = 'From: '.$name.' <sarah@sarahgebauer.com>' . "\r\n" . 'Reply-To: ' . $email;

 		wp_mail('sarah@sarahgebauer.com', $subject, $body, $headers);
 		$emailSent = true;
 	} else {
 		if (!$msg) {
 			$errorMsg = true;
 		}
 		if (!$name) {
 			$errorName = true;
 		}
 		if (!$email) {
 			$errorEmail = true;
 		}
 	}
 }

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="hero">
				Hi! I am Sarah and I am a Front-End Developer.<br />
My specialties are:
<ul>
	<li>Wordpress</li>
	<li>HTML & CSS</li>
	<li>JavaScript & jQuery</li>
</ul>
			</div>
			<div class="front-flex-parent">
				<div class="front-flex-child front-blogpost">
							<?php query_posts('posts_per_page=1'); ?>

			<?php while (have_posts()) : the_post(); ?>
				<h2 class="section-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
				<?php
                if (has_post_thumbnail()) { ?>
                  <a href="<?php the_permalink(); ?>"><?php
                    the_post_thumbnail(array(440, 264)); ?>
                    </a> <?php
                }
                                the_excerpt();
                ?>
							<?php endwhile; ?>		
				</div>
				<div class="front-flex-child front-portfolio">
					<?php query_posts('post_type=piece&posts_per_page=1'); ?>

			<?php while (have_posts()) : the_post(); ?>
				<h2 class="section-title">Latest project:</h2>
				<div class="right-align">
				<?php
								if (has_post_thumbnail()) { ?>
                  <a href="<?php the_permalink(); ?>"><?php
										the_post_thumbnail(array(440, 264)); ?>
                  </a> <?php
								}
								?>
								<br />
								<a href="<?php the_permalink(); ?>">Read more about it</a>
							</div>
							<?php endwhile; ?>

<?php wp_reset_query(); ?>
				</div>
				<div class="front-flex-child front-contact">
					<h2 class="section-title">Contact me</h2>
			<p>
				My e-mail is sarah@sarahgebauer.com or use the form below.
			</p>
			<?php if ($emailSent) :	?>
			Your e-mail has been sent!
		  <?php endif; ?>
			<form action="<?php echo bloginfo('url'); ?>?sent=1" method="post">
				<?php if ($errorMsg && !$first) :?>
					<div>Your message is empty</div>
				<?php endif; ?>
				<label for="msg">Your message:</label><br />
				<textarea id="msg" name="msg"></textarea>
				<?php if ($errorName && !$first) :?>
					<div>Your name is empty</div>
				<?php endif; ?>
				<label for="sender-name">Your name:</label><br />
				<input type="text" id="sender-name" name="sender-name" /><br />
				<?php if ($errorEmail && !$first) :?>
					<div>Your email is empty</div>
				<?php endif; ?>
				<label for="email">Your e-mail:</label><br />
				<input type="email" id="email" name="email" /><br />
				<label for="botici">Only robots write here:</label><br />
				<input type="text" id="botici" name="botici" /><br />
				<input type="submit" value="Send" />
			</form>
				</div>
				<div class="front-flex-child front-explore">
				
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
