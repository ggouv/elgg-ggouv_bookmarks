<?php
/**
 * Elgg bookmark view
 *
 * @package ElggBookmarks
 */

$full = elgg_extract('full_view', $vars, FALSE);
$bookmark = elgg_extract('entity', $vars, FALSE);

if (!$bookmark) {
	return;
}

$owner = $bookmark->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $bookmark->getContainerEntity();
$categories = elgg_view('output/categories', $vars);

$bits = parse_url($bookmark->address);
$site = $bits['scheme'] . '://' . $bits['host'];

$link = elgg_view('output/url', array(
	'href' => $bookmark->address,
	'target' => '_blank'
));
$description = elgg_view('output/longtext', array('value' => $bookmark->description, 'class' => ''));

/*$marked_this_bookmark = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'bookmarks',
	'metadata_name' => 'address',
	'metadata_value' => $bookmark->address,
));*/
/*$site_sql_string = sanitise_string($site);
$similar_bookmarks = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'bookmarks',
	'joins' => array(
		'JOIN ggouvfr_metadata n_table on e.guid = n_table.entity_guid',
		'JOIN ggouvfr_metastrings msn on n_table.name_id = msn.id',
		'JOIN ggouvfr_metastrings msv on n_table.value_id = msv.id'
	),
	'wheres' => array(
		"(msn.string IN ('address'))",
		"(msv.string LIKE '$site%')"
	)
));
//global $fb; $fb->info($similar_bookmarks);
/*$same_bookmark =
foreach ($similar_bookmarks as $key => $b) {
	if ($b->guid == $bookmarks->getGUID()) unset($similar_bookmarks[$key]);
	if ($b->address == $bookmarks->adrress)
}*/

$infos = elgg_view('output/url', array(
	'text' => elgg_echo('bookmarks:bookmarks_of_this_site', array($bits['host'])),
	'href' => "bookmarks/site/{$bits['host']}",
	'is_trusted' => true
));

if (function_exists('markdown_wiki_parse_link')) { // special for ggouv
	$echo = elgg_echo('bookmarks:wiki_of_this_site', array($bits['host']));
	$infos .= '<br/>' . elgg_view('output/longtext', array(
		'value' => "[{$echo}](site:{$bits['host']})"
	));
}

$owner_link = elgg_view('output/url', array(
	'href' => "bookmarks/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($bookmark->time_created);

$comments_count = $bookmark->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $bookmark->getURL() . '#comments',
		'text' => $text,
		'is_trusted' => true
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'bookmarks',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {

	$params = array(
		'entity' => $bookmark,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$description ='<div>' . $description . '</div><div class="elgg-heading-basic markdown-body pam mtm">' . $infos . '</div>';

	$bookmark_icon = elgg_view('output/img', array(
		'src' => "https://plus.google.com/_/favicon?domain={$bits['scheme']}://{$bits['host']}?canAudit=false", //http://a.fvicon.com/http://stackoverflow.com?canAudit=false
		'width' => '16px',
		'height' => '16px',
		'class' => 'mrs favicon'
	));
	$body = <<<HTML
<div class="bookmark elgg-content mts">
	$bookmark_icon<span class="mbs">$link</span>
	$description
</div>
HTML;

	echo elgg_view('object/elements/full', array(
		'entity' => $bookmark,
		'icon' => $owner_icon,
		'summary' => $summary,
		'body' => $body,
	));

} elseif (elgg_in_context('gallery')) {
	echo <<<HTML
<div class="bookmarks-gallery-item">
	<h3>$bookmark->title</h3>
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;
} else {
	// brief view
	$url = $bookmark->address;
	$display_text = $url;
	$excerpt = elgg_get_excerpt($bookmark->description);
	if ($excerpt) {
		$excerpt = " - $excerpt";
	}

	if (isset($bits['host'])) {
		$display_text = $bits['host'];
	} else {
		$display_text = elgg_get_excerpt($url, 100);
	}

	$link = elgg_view('output/url', array(
		'href' => $url,
		'text' => $display_text,
		'target' => '_blank'
	));

	$content = elgg_view('output/img', array(
		'src' => "https://plus.google.com/_/favicon?domain={$bits['scheme']}://{$bits['host']}?canAudit=false", //http://a.fvicon.com/http://stackoverflow.com?canAudit=false
		'width' => '16px',
		'height' => '16px',
		'class' => 'mrs favicon'
	)) . "$link{$excerpt}";

	$params = array(
		'entity' => $bookmark,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $content,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($owner_icon, $body);
}
