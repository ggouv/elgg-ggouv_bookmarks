<?php
/**
 * Elgg bookmarks plugin everyone page
 *
 * @package ElggBookmarks
 */

$site = get_input('site');
if (!$site) {
	forward('bookmarks/all');
}

elgg_push_breadcrumb($site);

elgg_register_title_button();

global $CONFIG;

$site_sql_string = sanitise_string($site);
$content = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'bookmarks',
	'joins' => array(
		"JOIN {$CONFIG->dbprefix}fr_metadata n_table on e.guid = n_table.entity_guid",
		"JOIN {$CONFIG->dbprefix}fr_metastrings msn on n_table.name_id = msn.id",
		"JOIN {$CONFIG->dbprefix}fr_metastrings msv on n_table.value_id = msv.id"
	),
	'wheres' => array(
		"(msn.string IN ('address'))",
		"(msv.string LIKE '%$site%')"
	),
	'limit' => 50,
	'full_view' => false,
	'view_toggle_type' => false
));

if (!$content) {
	$content = elgg_echo('bookmarks:none');
}

$title = elgg_echo('bookmarks:bookmarks_of_this_site', array($site));

if (function_exists('markdown_wiki_parse_link')) { // special for ggouv
	$echo = elgg_echo('bookmarks:wiki_of_this_site', array($site));
	$infos .= elgg_view('output/longtext', array(
		'value' => "[{$echo}](site:{$site})"
	));
}

$body = elgg_view_layout('content_two_right_sidebars', array(
	'filter' => '<div class="elgg-heading-basic markdown-body pam mvm">' . $infos . '</div>',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('bookmarks/sidebar'),
	'sidebar_2' => elgg_view('bookmarks/sidebar_2'),
));

echo elgg_view_page($title, $body);