<?php
/**
 * View a bookmark
 *
 * @package ElggBookmarks
 */

$bookmark = get_entity(get_input('guid'));
if (!$bookmark) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
}

$page_owner = elgg_get_page_owner_entity();

$crumbs_title = $page_owner->name;

if (elgg_instanceof($page_owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "bookmarks/group/$page_owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "bookmarks/owner/$page_owner->username");
}

$title = $bookmark->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($bookmark, array('full_view' => true));
$content .= elgg_view_comments($bookmark, true, array('preview' => 'toggle'));

$body = elgg_view_layout('one_column', array(
	'content' => '<div class="elgg-head clearfix">' . elgg_view_title($title, array('class' => 'elgg-heading-main')) . '</div>' . $content,
	'filter' => '',
));

$body = '<div class="row-fluid"><div class="span4">' . $body . '</div>';
$body .= '<div class="span8 iframe-fixed">' . elgg_view('output/iframe', array(
										'src' => $bookmark->address,
										'class' => 'bookmark-iframe',
										'width' => '100%',
										'frameborder' => '0'
									)) . '</div></div>';

echo elgg_view_page($title, $body);
