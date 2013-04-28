<?php
/**
 * Bookmarks sidebar
 */

$page_owner = elgg_get_page_owner_entity();

$options['subtypes'] = 'bookmarks';

if ($page_owner && elgg_instanceof($page_owner, 'group')) {
	$options['container_guid'] = elgg_get_page_owner_guid();
} else if ($page_owner && elgg_instanceof($page_owner, 'user')) {
	$options['owner_guid'] = elgg_get_page_owner_guid();
	$options['container_guid'] = elgg_get_page_owner_guid();
}
$options['limit'] = 30;
echo elgg_view('page/elements/comments_block', $options);
